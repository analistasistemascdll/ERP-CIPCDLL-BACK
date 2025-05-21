<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CuentaHija extends Model
{
    use HasFactory;

    protected $table = 'Cuenta_Hija';
    protected $primaryKey = 'IdCuenta_Hija';

    public $timestamps = false;

    protected $fillable = [
        'Codigo_Hija',
        'Descripcion',
        'Estado',
        'Idcuenta_Padre', // corregido
        'Nombre'
    ];
    
    // Relación correcta
    public function cuentaPadre()
    {
        return $this->belongsTo(CuentaPadre::class, 'Idcuenta_Padre', 'Idcuenta_Padre');
    }
    
}
