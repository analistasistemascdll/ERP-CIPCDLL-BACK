<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRol;
class UserRolController extends Controller
{
    public function getRol($id)
    {
        $userRol = UserRol::where('id', $id)->first();
    
        if (!$userRol) {
            return response()->json(['message' => 'Rol no encontrado'], 404);
        }
    
        return response()->json([
            'idRol' => $userRol->idRol // Asegúrate que la columna en DB se llama exactamente 'idRol'
        ]);
    }
}