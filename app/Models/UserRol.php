<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRol extends Model
{
    protected $table = 'user_rol';
    protected $fillable = ['id', 'idRol']; // Ajusta si usas otros campos
}
