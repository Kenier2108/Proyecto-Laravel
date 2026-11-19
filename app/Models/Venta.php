<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';

    protected $fillable = [
        'id_cliente',
        'usuario_id',
        'fecha',
        'total',
        'estado'
    ];

    public function detalles() {
        return $this->hasMany(DetalleVenta::class, 'id_venta');
    }

    public function cliente() {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function usuario() {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
