<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Http\Request;

class UsuarioBodegas extends Model {
    protected $table = "bodegas_asignadas";
    public static function AddBodega(Request $request) {
        if ($request->ajax()) {
            try {

                $Id         = $request->input('Id');
                $valor      = $request->input('valor');

                $obj = new UsuarioBodegas();   
                $obj->BODEGA        = $valor;                
                $obj->id_usuario  = $Id;
                
                $response = $obj->save();

                return response()->json($response);
                
            } catch (Exception $e) {
                $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";
                return response()->json($mensaje);
            }
        }
    }
    public static function Remover(Request $request)
    {
        if ($request->ajax()) {
            try {

                $id     = $request->input('id');
                
                $response = UsuarioBodegas::where('id',$id)->delete();

                return response()->json($response);


            } catch (Exception $e) {
                $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";
                return response()->json($mensaje);
            }
        }

    }
}
