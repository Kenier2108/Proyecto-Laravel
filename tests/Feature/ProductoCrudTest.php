<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductoCrudTest extends TestCase
{
    use RefreshDatabase;
    public function test_admin_puede_crear_producto(): void
    {
        $usuario= User::factory()->create([
            'rol' => 'administrador',
        ]);

        $categoria = Categoria::create([
            'nom_categoria' => 'Aseo',
        ]);

        $this->actingAs($usuario)
            ->post(route('productos.store'), [
                'nom_producto' => 'Jabon de prueba',
                'detalle_producto' => 'Registro de prueba',
                'cant_producto' => 10,
                'valor_producto' => 1000,
                'estado_producto' => 'activo',
                'id_categoria' => $categoria->id,
            ])
            ->assertRedirect(route('productos.index'));

        $this->assertDatabaseHas('productos', [
            'nom_producto' => 'Jabon de prueba',
            'id_categoria' => $categoria->id,
        ]);
    }

    public function test_no_acepta_precio_negativo(): void
    {
        $usuario = User::factory()->create([
            'rol' => 'administrador',
        ]);

        $categoria = Categoria::create([
            'nom_categoria' => 'Aseo',
        ]);

        $this->actingAs($usuario)
            ->from(route('productos.create'))
            ->post(route('productos.store'), [
                'nom_producto' => 'Producto invalido',
                'detalle_producto' => 'Prueba',
                'cant_producto' => 5,
                'valor_producto' => -100,
                'estado_producto' => 1,
                'id_categoria' => $categoria->id,
            ])
            ->assertSessionHasErrors('valor_producto');

        $this->assertDatabaseMissing('productos', [
            'nom_producto' => 'Producto invalido',
        ]);
    }
}
