<?php

namespace App\Models;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'categoria';

    public $timestamps = false;

    protected $fillable = [
        'nom_categoria',
    ];

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'id_categoria');
    }
}
