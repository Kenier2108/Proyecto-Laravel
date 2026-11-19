<form method="POST" action="{{ route('ventas.store') }}">
    @csrf

    <div class="mb-4">
        <label for="id_cliente" class="form-label">Cliente</label>
        <select name="id_cliente" id="id_cliente" class="form-select">
            <option value="">Venta sin cliente registrado</option>
            @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }}" @selected(old('id_cliente') == $cliente->id)>
                    {{ $cliente->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <p class="form-text mb-3">Puedes registrar la venta con un solo producto; los demás son opcionales.</p>

    @for ($i = 0; $i < 3; $i++)
        <fieldset class="border rounded p-3 mb-3">
            <legend class="float-none w-auto px-2 fs-6 fw-semibold mb-0">Producto {{ $i + 1 }}</legend>

            <div class="row g-3">
                <div class="col-md-8">
                    <label for="producto_{{ $i }}" class="form-label">Producto</label>
                    <select name="productos[{{ $i }}][id_producto]" id="producto_{{ $i }}" class="form-select">
                        <option value="">Seleccione producto</option>
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}" @selected(old("productos.$i.id_producto") == $producto->id)>
                                {{ $producto->nom_producto }} - ${{ number_format((float) $producto->valor_producto, 2) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="cantidad_{{ $i }}" class="form-label">Cantidad</label>
                    <input
                        type="number"
                        name="productos[{{ $i }}][cantidad]"
                        id="cantidad_{{ $i }}"
                        class="form-control"
                        min="1"
                        value="{{ old("productos.$i.cantidad") }}"
                        placeholder="Cantidad"
                    >
                </div>
            </div>
        </fieldset>
    @endfor

    <button type="submit" class="btn btn-primary">Registrar venta</button>
</form>