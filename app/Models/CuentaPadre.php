<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaPadre extends Model
{
    use HasFactory;

    protected $table = 'Cuenta_Padre';
    protected $primaryKey = 'Idcuenta_Padre'; // <- Esto es lo que te falta

    public $timestamps = false; // <- si no usas created_at / updated_at

    protected $fillable = [
        'Codigo',
        'Nombre',
        'Descripcion',
        'Tipo',
        'Estado',
    ];
}