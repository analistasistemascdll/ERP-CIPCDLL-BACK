<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AreaCuenta extends Model
{
    use HasFactory;

    protected $table = 'area_cuenta';
    protected $primaryKey = 'IdArea_cuenta';
    public $timestamps = false;

    protected $fillable = [
        'IdArea',
        'IdCuenta_Hija',
        'estado',
    ];
}
