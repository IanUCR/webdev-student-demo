<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Seed;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreSeed;
use App\Http\Requests\Api\V1\UpdateSeed;
use App\Http\Resources\SeedResource;
use Illuminate\Http\Response;
class SeedController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $seeds = $request->seed_type()->seeds()
        ->with('type')
        ->latest()
        ->paginate(15);

        return SeedResource::collection($seeds);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSeed $request)
    {
        //
        $seed = $request->seed_type()->seeds()->create($request->validated());
        return (new SeedResource($seed->load('type')))
        ->response()
        ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Seed $seed)
    {
        $this->ensureSeedType($request, $seed);
        return new SeedResource($seed->load('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSeed $request, Seed $seed)
    {
        $this->ensureSeedType($request, $seed);
        $seed->update($request->validated());
        return new SeedResource($seed->load('type'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Seed $seed)
    {
        $this->ensureSeedType($request, $seed);
        $seed->delete();
        return response()->json([
            'message' => 'Seed deleted successfully'
        ], Response::HTTP_NO_CONTENT);
    }

    private function ensureSeedType(Request $request, Seed $seed): void
    {
        if ($request->seed_type()->id !== $seed->type_id) {
            abort(Response::HTTP_FORBIDDEN);
        }
    }
}

