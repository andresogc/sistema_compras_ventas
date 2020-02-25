<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    //

    protected $fillable= ['name','tipo_documento','num_documento','direccion','email','telefono'];
}
