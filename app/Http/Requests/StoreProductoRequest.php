<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom_producto' => ['required', 'string', 'max:150'],
            'detalle_producto' => ['nullable', 'string', 'max:2000'],
            'cant_producto' => ['required', 'integer', 'min:0'],
            'valor_producto' => ['required', 'numeric', 'min:0'],
            'foto_producto' => [
                'nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'
            ],
            'estado_producto' => ['required', 'in:Activo,Inactivo'],
            'id_categoria' => ['required', 'exists:categoria,id'],
            //
        ];
    }

    public function messages(): array
    {
        return [
            'nom_producto.required' => 'El nombre del producto es obligatorio.',
            'cant_producto.min' => 'La cantidad no puede ser negativa.',
            'valor_producto.min' => 'El precio no puede ser negativo.',
            'id_categoria.exists' => 'Seleccione una categoria valida.',
            'foto_producto.image' => 'El archivo debe ser una imagen.',
        ];           
    }
}
