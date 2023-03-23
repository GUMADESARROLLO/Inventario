<?php

namespace App\Models;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class TablaArticulos extends Model
{
    protected $connection = 'sqlsrv';
    public $timestamps = false;
    protected $table = "PRODUCCION.dbo.tbl_inventario_innova";

    public static function GuardarListas(Request $request) {
        if ($request->ajax()) {
            try {
                $datos_a_insertar = array();    
                TablaArticulos::where('Activo', 'S')->delete();
                foreach ($request->input('datos') as $key => $val) {
                    $datos_a_insertar[$key]['ARTICULO']         = $val['Articulo'];
                    $datos_a_insertar[$key]['CANTIDAD']         = $val['Total'];                 
                    $datos_a_insertar[$key]['FECHA']            = date('Y-m-d H:i:s');
                    $datos_a_insertar[$key]['created_at']       = date('Y-m-d H:i:s');
                    $datos_a_insertar[$key]['Activo']           = 'S';
                    
                }
                $response = TablaArticulos::insert($datos_a_insertar); 

                
                
                return $response;
                
            } catch (Exception $e) {
                $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";
                return response()->json($mensaje);
            }
        }
    }
}