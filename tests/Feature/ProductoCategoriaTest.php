<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ProductoCategoriaTest extends TestCase
{
    use RefreshDatabase;

    public function test_productos_y_categorias_tienen_sus_columnas_y_relacion(): void
    {
        $this->assertTrue(Schema::hasColumns('categoria', ['id', 'nom_categoria']));
        $this->assertTrue(Schema::hasColumns('productos', [
            'id',
            'nom_producto',
            'detalle_producto',
            'cant_producto',
            'valor_producto',
            'foto_producto',
            'estado_producto',
            'id_categoria',
            'created_at',
            'updated_at',
        ]));

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

        $this->assertSame($categoria->id, $producto->categoria->id);
        $this->assertTrue($categoria->productos->contains($producto));
    }

    public function test_las_pantallas_de_productos_y_categorias_se_muestran_a_usuarios_autenticados(): void
    {
        $this->actingAs(User::factory()->create(['rol' => 'administrador']));
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

        $this->get(route('producto.index'))->assertOk();
        $this->get(route('producto.create'))->assertOk();
        $this->get(route('producto.edit', $producto))->assertOk();
        $this->get(route('categoria.index'))->assertOk();
        $this->get(route('categoria.create'))->assertOk();
        $this->get(route('categoria.edit', $categoria))->assertOk();
    }

    public function test_el_rol_inventario_no_puede_crear_categorias(): void
    {
        $this->actingAs(User::factory()->create(['rol' => 'inventario']));

        $this->get(route('categoria.create'))->assertForbidden();
        $this->post(route('categoria.store'), ['nom_categoria' => 'Nueva'])->assertForbidden();
        $this->get(route('categoria.index'))
            ->assertOk()
            ->assertDontSee(route('categoria.create'));

        $this->assertDatabaseMissing('categoria', ['nom_categoria' => 'Nueva']);
    }
}
