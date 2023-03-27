<?php

namespace App\Models;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TablaArticulos extends Model
{
    protected $connection = 'sqlsrv';
    public $timestamps = false;
    protected $table = "PRODUCCION.dbo.tbl_inventario_innova";

    public static function GuardarListas(Request $request) {
        if ($request->ajax()) {
            try {
                $datos_a_insertar = array();    
                TablaArticulos::where('Manual', 'N')->delete();
                foreach ($request->input('datos') as $key => $val) {
                    $datos_a_insertar[$key]['ARTICULO']         = $val['Articulo'];
                    $datos_a_insertar[$key]['CANTIDAD']         = $val['Total'];
                    $datos_a_insertar[$key]['JUMBOS']           = $val['Jumbo'];                 
                    $datos_a_insertar[$key]['FECHA']            = date('Y-m-d H:i:s');
                    $datos_a_insertar[$key]['created_at']       = date('Y-m-d H:i:s');
                    $datos_a_insertar[$key]['Manual']           = 'N';
                    
                }
                $response = TablaArticulos::insert($datos_a_insertar); 

                
                
                return $response;
                
            } catch (Exception $e) {
                $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";
                return response()->json($mensaje);
            }
        }
    }
   
    public static function GuardarCantidad(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                
                $id     = $request->input('art_code');
                $CT     = $request->input('art_cant_ingreso');
                $JB     = $request->input('cant_jumbos');

                $isExit = TablaArticulos::isExiste($id);

                if(count($isExit) <= 0){
                    $Articulo = new TablaArticulos();
                    $Articulo->ARTICULO         = $id;
                    $Articulo->CANTIDAD         = $CT;  
                    $Articulo->JUMBOS           = $JB;  
                    $Articulo->FECHA            = date('Y-m-d H:i:s');  
                    $Articulo->created_at       = date('Y-m-d H:i:s');
                    $Articulo->Manual           = 'S';                  
                    $Articulo->save();

                }else{
                    TablaArticulos::where('ARTICULO',  $id)->update([
                        "CANTIDAD"  => $CT,
                        "JUMBOS"    => $JB,
                    ]);
                }
            });
        } catch (Exception $e) {
            $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";

            return response()->json($mensaje);
        } 
    }
    public static function isExiste($Articulos){
        return TablaArticulos::where('ARTICULO', $Articulos)->get();
    }

    
}