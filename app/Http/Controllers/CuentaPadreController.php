<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CuentaPadre;
use Illuminate\Support\Facades\DB;

class CuentaPadreController extends Controller
{
    // Mostrar solo cuentas activas
    public function index()
    {
        return CuentaPadre::where('Estado', 1)->get();
    }

    // Mostrar solo cuentas inactivas (borradas lógicamente)
    public function cuentasInactivas()
    {
        return CuentaPadre::where('Estado', 0)->get();
    }

    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([    
            'Codigo' => 'required|integer',
            'Nombre' => 'required|string|max:500',
            'Descripcion' => 'nullable|string|max:1000',
            'Tipo' => 'nullable|string|max:20',
            'Estado' => 'required|boolean',
        ]);
    
        // Verificar si ya existe un registro con el mismo código y estado
        $existe = CuentaPadre::where('Codigo', $request->Codigo)
                              ->where('Estado', $request->Estado)
                              ->exists();
    
        if ($existe) {
            return response()->json(['mensaje' => 'Ya existe un registro con ese código y estado en la base de datos.'], 400);
        }
    
        // Si no existe, proceder a crear el nuevo registro
        $data = $request->only([
            'Codigo',
            'Nombre',
            'Descripcion',
            'Tipo',
            'Estado'
        ]);
    
        $cuenta = CuentaPadre::create($data);
    
        return response()->json(['mensaje' => 'Cuenta padre creada correctamente.', 'data' => $cuenta], 201);
    }
    

    
    public function show($id)
    {
        $cuenta = CuentaPadre::findOrFail($id);
        return response()->json($cuenta);
    }

    public function update(Request $request, $id)
    {
        $cuenta = CuentaPadre::findOrFail($id);
        $cuenta->update($request->all());
        return response()->json($cuenta);
    }


    public function destroy($id)
    {
        DB::beginTransaction();
    
        try {
            $cuenta = CuentaPadre::findOrFail($id);
    
            // Cambiar el Estado a 0
            $cuenta->Estado = 0;
            $cuenta->save();
    
            DB::commit();  // Confirmar transacción
    
            return response()->json(['message' => 'Cuenta inactivada correctamente'], 200);
        } catch (\Exception $e) {
            DB::rollBack();  // Si algo falla, revertir cambios
    
            return response()->json(['message' => 'Error al intentar inactivar la cuenta', 'error' => $e->getMessage()], 500);
        }
    }
    
    public function obtenerCodigoPorId($id)
        {
            $cuenta = CuentaPadre::select('Codigo')->find($id);

            if (!$cuenta) {
                return response()->json(['message' => 'Cuenta no encontrada'], 404);
            }

            return response()->json(['Codigo' => $cuenta->Codigo], 200);
        }
        public function listarSoloIds()
        {
            $ids = CuentaPadre::where('Estado', 1)->pluck('Idcuenta_Padre');
            return response()->json($ids, 200);
        }
        
}
