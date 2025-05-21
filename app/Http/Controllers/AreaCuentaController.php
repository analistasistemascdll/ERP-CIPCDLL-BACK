<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\AreaCuenta;
class AreaCuentaController extends Controller
{
    // ✅ Agregar una nueva relación
    public function store(Request $request)
    {
        $request->validate([    
            'IdArea' => 'required|exists:Area,IdArea',
            'IdCuenta_Hija' => 'required|exists:Cuenta_Hija,Idcuenta_Hija',
            'estado' => 'required|integer',
        ]);
    
        $data = $request->only([
            'IdArea',
            'IdCuenta_Hija',
            'estado'
        ]);
    
        $cuenta = AreaCuenta::create($data);
    
        return response()->json($cuenta, 201);
    }
    
    
    // ✏️ Editar una relación existente
    public function editar(Request $request, $id)
    {
        $areaCuenta = AreaCuenta::findOrFail($id);
        $request->validate([
            'IdArea' => 'required|exists:Area,IdArea',
            'IdCuenta_Hija' => 'required|exists:Cuenta_Hija,IdCuenta_Hija',
        ]);
        $areaCuenta->update([
            'IdArea' => $request->IdArea,
            'IdCuenta_Hija' => $request->IdCuenta_Hija,
        ]);
        return response()->json($areaCuenta, 200);
    }
    
    // 🗑️ Eliminar (lógico) una relación: estado = false
    public function eliminar($id)
    {
        $areaCuenta = AreaCuenta::findOrFail($id);
        $areaCuenta->estado = 0;
        $areaCuenta->save();
        return response()->json(['mensaje' => 'Relación desactivada correctamente'], 200);
    }
    
    // ✅ Listar relaciones activas (estado = true)
    public function listarActivos()
    {
        $activos = AreaCuenta::where('estado', 1)->get();
        return response()->json($activos, 200);
    }
}