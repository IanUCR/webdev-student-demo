<?php
namespace App\Http\Controllers\Api\v1;
use App\Http\Requests\Api\V1\StoreTree;
use App\Http\Resources\TreeResource;
use App\Models\Tree;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class TreeController
{
    /**
    * Lista los árboles del usuario autenticado.
    */
    public function index(Request $request)
    {
        $trees = $request->user()->trees()->latest()->paginate(15);

        return TreeResource::collection($trees);
    }
    
    /**
    * Planta un árbol nuevo para el usuario autenticado.
    * El dueño y los valores iniciales los define el servidor, no el cliente.
    */
    public function store(StoreTree $request): JsonResponse
    {
        $tree = $request->user()->trees()->create([
            'idSeed' => $request->validated('idSeed'),
            'level' => 0,
            'health' => Tree::MAX_HEALTH,
            'progress' => 0,
            'status' => Tree::STATUS_ACTIVE,
        ]);

        return (new TreeResource($tree))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
    
    public function show(Tree $tree): TreeResource
    {
        Gate::authorize('view', $tree);

        return new TreeResource($tree);
    }
    
    /**
    * POST /api/trees/{tree}/care
    */
    public function care(Tree $tree): JsonResponse
    {
        // 1. Autorización: el árbol debe pertenecer al usuario autenticado (403)
        Gate::authorize('care', $tree);

        return DB::transaction(function () use ($tree) {
            // Bloqueo de fila para evitar que dos peticiones simultáneas se salten el cooldown
            $tree = Tree::lockForUpdate()->findOrFail($tree->getKey());

            // 2. Estado terminal: DEAD o MATURE no reciben cuidados (409)
            if (in_array($tree->status, [Tree::STATUS_DEAD, Tree::STATUS_MATURE], true)) {
                return response()->json([
                    'error' => 'El árbol está en estado '.$tree->status.' y ya no puede recibir cuidados.',
                ], Response::HTTP_CONFLICT);
            }

            // 3. Cooldown validado en el servidor (409)
            if ($tree->next_care_at !== null && now()->lt($tree>next_care_at)) {
                return response()->json([
                    'error' => 'El árbol se encuentra en período de enfriamiento.', 'next_care_at' => $tree->next_care_at->toIso8601ZuluString(),
                ], Response::HTTP_CONFLICT);
            }
            // 4. Reglas de cuidado y progreso
            $tree->progress += 1;
            $tree->health = min(Tree::MAX_HEALTH, $tree->health + Tree::HEALTH_PER_CARE);
        
            if ($tree->progress >= Tree::CARES_PER_LEVEL) {
                $tree->level += 1;
                $tree->progress = 0;
            }
        
            if ($tree->level >= Tree::MATURE_LEVEL) {
                $tree->status = Tree::STATUS_MATURE;
            }

            $tree->last_cared_at = now();
            $tree->next_care_at = now()->addMinutes(Tree::COOLDOWN_MINUTES);
            $tree->save();

            return response()->json([
                'message' => 'Cuidado aplicado con éxito',
                'tree' => [
                    'id' => $tree->idTree,
                    'level' => $tree->level,
                    'health' => $tree->health,
                    'progress' => $tree->progress,
                    'status' => $tree->status,
                    'next_care_at' => $tree->next_care_at->toIso8601ZuluString(),
                ],
            ], Response::HTTP_OK);
        });
    }
}