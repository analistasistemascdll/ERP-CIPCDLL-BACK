<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CuentaHija;
class CuentaHijaController extends Controller
{
    // Mostrar todas las cuentas hijas activas (Estado = 1)
    public function index()
    {
        $cuentasHijas = CuentaHija::where('Estado', 1)
            ->with('cuentaPadre:Idcuenta_Padre,Codigo') // solo lo necesario
            ->get()
            ->map(function ($cuenta) {
                return [
                    'IdCuenta_Hija' => $cuenta->IdCuenta_Hija,
                    'Codigo_Hija' => $cuenta->Codigo_Hija,
                    'Descripcion' => $cuenta->Descripcion,
                    'Estado' => $cuenta->Estado,
                    'Idcuenta_Padre' => $cuenta->Idcuenta_Padre,
                    'Nombre' => $cuenta->Nombre,
                    'Codigo_Padre' => $cuenta->cuentaPadre->Codigo ?? null, // aquí el dato relacionado
                ];
            });
    
        return response()->json($cuentasHijas);
    }
    
    public function index2($idCuentaPadre)
    {
        $cuentasHijas = CuentaHija::where('Estado', 1)
            ->where('Idcuenta_Padre', $idCuentaPadre)
            ->with('cuentaPadre:Idcuenta_Padre,Codigo') // solo lo necesario
            ->get()
            ->map(function ($cuenta) {
                return [
                    'IdCuenta_Hija' => $cuenta->IdCuenta_Hija,
                    'Codigo_Hija' => $cuenta->Codigo_Hija,
                    'Descripcion' => $cuenta->Descripcion,
                    'Estado' => $cuenta->Estado,
                    'Idcuenta_Padre' => $cuenta->Idcuenta_Padre,
                    'Nombre' => $cuenta->Nombre,
                    'Codigo_Padre' => $cuenta->cuentaPadre->Codigo ?? null, // dato relacionado
                ];
            });
    
        return response()->json($cuentasHijas);
    }
    

    // Método para eliminar lógicamente (cambiar estado a 0)
    public function destroy($id)
    {
        $cuentaHija = CuentaHija::find($id);

        if (!$cuentaHija) {
            return response()->json(['mensaje' => 'Cuenta hija no encontrada.'], 404);
        }

        $cuentaHija->Estado = 0;
        $cuentaHija->save();

        return response()->json(['mensaje' => 'Cuenta hija desactivada correctamente.']);
    }


    public function update(Request $request, $id)
{
    $cuentaHija = CuentaHija::find($id);

    if (!$cuentaHija) {
        return response()->json(['mensaje' => 'Cuenta hija no encontrada.'], 404);
    }

    // Validar los datos que se van a actualizar
    $request->validate([
        'Codigo_Hija' => 'nullable|integer',
        'Descripcion' => 'nullable|string|max:100',
        'Estado' => 'nullable|boolean',
        'Idcuenta_Padre' => 'nullable|exists:Cuenta_Padre,Idcuenta_Padre',
        'Nombre' =>'nullable|string|max:100'
    ]);

    // Actualizar campos
    $cuentaHija->update($request->only([
        'Codigo_Hija',
        'Descripcion',
        'Estado',
        'Idcuenta_Padre'
    ]));

    return response()->json(['mensaje' => 'Cuenta hija actualizada correctamente.', 'data' => $cuentaHija]);
}

public function store(Request $request)
{
    $request->validate([
        'Codigo_Hija' => 'required|integer',
        'Descripcion' => 'required|string|max:100',
        'Estado' => 'required|boolean',
        'Idcuenta_Padre' => 'required|exists:Cuenta_Padre,Idcuenta_Padre',
        'Nombre' => 'required|string|max:100',
    ]);
 // Verificar si ya existe un registro con el mismo código y estado
        $existe = CuentaHija::where('Codigo_Hija', $request->Codigo_Hija)
                              ->where('Estado', $request->Estado)
                              ->where('Idcuenta_Padre', $request ->Idcuenta_Padre)
                              ->exists();
    
        if ($existe) {
            return response()->json(['mensaje' => 'Ya existe un registro con ese código y estado en la base de datos.'], 400);
        }
    $data = $request->only([
        'Codigo_Hija',
        'Descripcion',
        'Estado',
        'Idcuenta_Padre',
        'Nombre'
    ]);
    $cuenta = CuentaHija::create($data);
    
        return response()->json(['mensaje' => 'Sub cuenta creada correctamente.', 'data' => $cuenta], 201);
    
}

public function show($id)
{
    $cuentaHija = CuentaHija::find($id);

    if (!$cuentaHija) {
        return response()->json(['mensaje' => 'Cuenta hija no encontrada.'], 404);
    }

    return response()->json($cuentaHija);
}

// Obtener solo el nombre de la cuenta hija por su ID
public function obtenerNombre($id)
{
    $cuentaHija = CuentaHija::find($id);

    if (!$cuentaHija) {
        return response()->json(['mensaje' => 'Cuenta hija no encontrada.'], 404);
    }

    return response()->json(['Nombre' => $cuentaHija->Nombre]);
}

}
