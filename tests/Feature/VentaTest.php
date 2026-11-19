<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VentaTest extends TestCase
{
    use RefreshDatabase;

    public function test_se_puede_registrar_una_venta_con_un_solo_producto(): void
    {
        $usuario = User::factory()->create();
        $categoria = Categoria::create(['nom_categoria' => 'Bebidas']);
        $producto = Producto::create([
            'nom_producto' => 'Agua',
            'detalle_producto' => 'Botella',
            'cant_producto' => '10',
            'valor_producto' => '5',
            'foto_producto' => 'productos/agua.jpg',
            'estado_producto' => 'Activo',
            'id_categoria' => $categoria->id,
        ]);

        $respuesta = $this->actingAs($usuario)->post(route('ventas.store'), [
            'productos' => [
                ['id_producto' => $producto->id, 'cantidad' => 1],
                ['id_producto' => '', 'cantidad' => ''],
                ['id_producto' => '', 'cantidad' => ''],
            ],
        ]);

        $respuesta->assertRedirect(route('ventas.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseCount('ventas', 1);
        $this->assertDatabaseCount('detalle_ventas', 1);
        $this->assertDatabaseHas('detalle_ventas', [
            'id_producto' => $producto->id,
            'cantidad' => 1,
        ]);
        $this->assertDatabaseHas('productos', [
            'id' => $producto->id,
            'cant_producto' => '9',
        ]);
    }
}
