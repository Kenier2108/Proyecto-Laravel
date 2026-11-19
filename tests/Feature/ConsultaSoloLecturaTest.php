<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConsultaSoloLecturaTest extends TestCase
{
    use RefreshDatabase;

    public function test_consulta_no_puede_abrir_formularios_ni_ejecutar_acciones_de_escritura(): void
    {
        $this->actingAs(User::factory()->create(['rol' => 'consulta']));
        $categoria = Categoria::create(['nom_categoria' => 'Bebidas']);
        $producto = Producto::create([
            'nom_producto' => 'Agua',
            'detalle_producto' => 'Botella',
            'cant_producto' => 10,
            'valor_producto' => 5,
            'foto_producto' => 'productos/agua.jpg',
            'estado_producto' => 'Activo',
            'id_categoria' => $categoria->id,
        ]);

        $this->get(route('empleado.create'))->assertForbidden();
        $this->get(route('producto.create'))->assertForbidden();
        $this->get(route('categoria.create'))->assertForbidden();
        $this->get(route('movimientos.create'))->assertForbidden();
        $this->get(route('ventas.create'))->assertForbidden();
        $this->get(route('clientes.create'))->assertForbidden();

        $this->post(route('empleado.store'))->assertForbidden();
        $this->post(route('producto.store'))->assertForbidden();
        $this->post(route('categoria.store'), ['nom_categoria' => 'Nueva'])->assertForbidden();
        $this->post(route('movimientos.store'))->assertForbidden();
        $this->post(route('ventas.store'))->assertForbidden();
        $this->post(route('clientes.store'))->assertForbidden();

        $this->get(route('categoria.edit', $categoria))->assertForbidden();
        $this->put(route('categoria.update', $categoria))->assertForbidden();
        $this->delete(route('categoria.destroy', $categoria))->assertForbidden();

        $this->get(route('producto.edit', $producto))->assertForbidden();
        $this->put(route('producto.update', $producto))->assertForbidden();
        $this->delete(route('producto.destroy', $producto))->assertForbidden();
    }

    public function test_consulta_puede_ver_listados_sin_acciones_de_escritura(): void
    {
        $this->actingAs(User::factory()->create(['rol' => 'consulta']));
        Categoria::create(['nom_categoria' => 'Bebidas']);

        $this->get(route('empleado.index'))
            ->assertOk()
            ->assertDontSee('Registrar Nuevo Empleado')
            ->assertDontSee('Editar')
            ->assertDontSee('Borrar');

        $this->get(route('categoria.index'))
            ->assertOk()
            ->assertDontSee('Registrar nueva categoría')
            ->assertDontSee('Editar')
            ->assertDontSee('Borrar');

        $this->get(route('producto.index'))
            ->assertOk()
            ->assertDontSee('Registrar nuevo producto')
            ->assertDontSee('Editar')
            ->assertDontSee('Borrar');

        $this->get(route('movimientos.index'))
            ->assertOk()
            ->assertDontSee('Registrar nuevo movimiento');

        $this->get(route('ventas.index'))
            ->assertOk()
            ->assertDontSee('Registrar venta');
    }
}
