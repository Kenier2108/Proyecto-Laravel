<?php

namespace App\Models;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    protected $fillable = [
        'nom_producto',
        'detalle_producto',
        'cant_producto',
        'valor_producto',
        'foto_producto',
        'estado_producto',
        'id_categoria',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }
}
