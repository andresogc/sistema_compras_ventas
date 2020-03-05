<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    //

    protected $fillable = [
        'idventa',
        'idproducto',
        'cantidad',
        'precio',
        'descuento'
    ];

    public $timestamps = false;
}
