<?php

namespace Tests\Feature;

use App\Models\Tree;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TreeCareTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    private function careUrl(Tree $tree): string
    {
        return "/api/trees/{$tree->idTree}/care";
    }

    public function test_usuario_cuida_su_arbol_activo_fuera_de_cooldown(): void
    {
        $tree = Tree::factory()->create([
            'owner_id' => $this->user->id,
            'health' => 60,
        ]);

        Sanctum::actingAs($this->user);

        $response = $this->postJson($this->careUrl($tree));

        $response->assertOk()
            ->assertJsonPath('message', 'Cuidado aplicado con éxito')
            ->assertJsonPath('tree.id', $tree->idTree)
            ->assertJsonPath('tree.progress', 1)
            ->assertJsonPath('tree.health', 80)
            ->assertJsonPath('tree.status', 'ACTIVE')
            ->assertJsonStructure([
                'message',
                'tree' => [
                    'id',
                    'level',
                    'health',
                    'progress',
                    'status',
                    'next_care_at',
                ],
            ]);

        $tree->refresh();

        $this->assertSame(1, $tree->progress);
        $this->assertNotNull($tree->next_care_at);
        $this->assertTrue($tree->next_care_at->isFuture());
    }

    public function test_segunda_peticion_seguida_es_bloqueada_por_cooldown(): void
    {
        $tree = Tree::factory()->create([
            'owner_id' => $this->user->id,
        ]);

        Sanctum::actingAs($this->user);

        $this->postJson($this->careUrl($tree))->assertOk();

        $this->postJson($this->careUrl($tree))
            ->assertStatus(409)
            ->assertJsonStructure(['error', 'next_care_at']);

        $this->assertSame(1, $tree->refresh()->progress);
    }

    public function test_cinco_cuidados_validos_suben_de_nivel_y_reinician_progreso(): void
    {
        $tree = Tree::factory()->create([
            'owner_id' => $this->user->id,
        ]);

        Sanctum::actingAs($this->user);

        for ($i = 0; $i < 5; $i++) {
            $this->postJson($this->careUrl($tree))->assertOk();

            $this->travel(61)->minutes(); // Salir del cooldown.
        }

        $tree->refresh();

        $this->assertSame(1, $tree->level);
        $this->assertSame(0, $tree->progress);
        $this->assertSame('ACTIVE', $tree->status);
    }

    public function test_arbol_nivel_9_con_progreso_4_evoluciona_a_mature(): void
    {
        $tree = Tree::factory()->create([
            'owner_id' => $this->user->id,
            'level' => 9,
            'progress' => 4,
        ]);

        Sanctum::actingAs($this->user);

        $this->postJson($this->careUrl($tree))
            ->assertOk()
            ->assertJsonPath('tree.level', 10)
            ->assertJsonPath('tree.progress', 0)
            ->assertJsonPath('tree.status', 'MATURE');

        $this->assertSame('MATURE', $tree->refresh()->status);
    }

    public function test_no_se_puede_cuidar_el_arbol_de_otro_usuario(): void
    {
        $otro = User::factory()->create();

        $tree = Tree::factory()->create([
            'owner_id' => $otro->id,
        ]);

        Sanctum::actingAs($this->user);

        $this->postJson($this->careUrl($tree))->assertForbidden();

        $tree->refresh();

        $this->assertSame(0, $tree->progress);
        $this->assertNull($tree->next_care_at);
    }

    public function test_arboles_dead_y_mature_no_reciben_cuidados(): void
    {
        Sanctum::actingAs($this->user);

        foreach (['DEAD', 'MATURE'] as $status) {
            $tree = Tree::factory()->create([
                'owner_id' => $this->user->id,
                'status' => $status,
            ]);

            $this->postJson($this->careUrl($tree))->assertStatus(409);

            $this->assertSame(0, $tree->refresh()->progress);
        }
    }

    public function test_usuario_sin_autenticar_recibe_401(): void
    {
        $tree = Tree::factory()->create([
            'owner_id' => $this->user->id,
        ]);

        $this->postJson($this->careUrl($tree))->assertUnauthorized();
    }
}