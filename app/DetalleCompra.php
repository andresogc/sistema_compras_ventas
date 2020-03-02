<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    //

    protected $fillable = ['idcompra','idproducto','cantidad','precio'];


    public $timestamps = false;

    
}
