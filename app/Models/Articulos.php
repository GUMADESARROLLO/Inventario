<?php

namespace App\Models;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Articulos extends Model
{
    protected $connection = 'sqlsrv';
    public $timestamps = false;
    protected $table = "PRODUCCION.dbo.tbl_inventario_innova";

  
    public function user()
    {
        return $this->belongsTo(Usuario::class, 'ID_USER');
    }
    public function articuloKardex()
    {
        return $this->hasMany(ArticuloKardex::class,'ID_ART');
    }
    public function getCANTIDAD()
    {
        return $this->CANTIDAD;
    }

    public static function getArticulos()
    {
        if (Auth::check()){
        
            $Rol = Auth::user()->id_rol;

            if ($Rol == 4|| $Rol == 1) {
                return Articulos::get();
            } else {
                return Articulos::where('ID_USER',Auth::id())->get();
            }
            
        }
    }

    public static function GuardarListas(Request $request) 
    {
        if ($request->ajax()) {
            try {
                $datos_a_insertar = array();    
                //TablaArticulos::where('ID_USER', Auth::id())->delete();
                foreach ($request->input('datos') as $key => $val) {
                    $datos_a_insertar[$key]['ARTICULO']         = $val['Articulo'];
                    $datos_a_insertar[$key]['DESCRIPCION']      = $val['Descr'];
                    $datos_a_insertar[$key]['CANTIDAD']         = $val['Total'];
                    $datos_a_insertar[$key]['UND']              = $val['Unida'];
                    $datos_a_insertar[$key]['JUMBOS']           = 0;       
                    $datos_a_insertar[$key]['created_at']       = date('Y-m-d H:i:s');
                    $datos_a_insertar[$key]['ID_USER']          = Auth::id();
                    
                }
                $response = Articulos::insert($datos_a_insertar); 
                ArticuloKardex::initKardex($request);


                
                
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
                
                $id                     = $request->input('art_code');
                $cantidad_evento        = $request->input('art_cant_ingreso');
                $Cantidad_actual        = $request->input('exist_actual');
                $ev                     = $request->input('id_event');
                $JB                     = $request->input('cant_jumbos');
                $Feha                   = $request->input('dateEvent');
                $observaciones          = $request->input('observaciones');
                $Feha                   = date('Y-m-d',strtotime($Feha));

                $Articulo               = Articulos::find($id);

                $Existencia             = ($ev == 'In') ? $Cantidad_actual + $cantidad_evento : max($Cantidad_actual - $cantidad_evento, 0);

                $obj                    = new ArticuloKardex();
                $obj->ID_ART            = $id;
                $obj->ARTICULO          = $Articulo->ARTICULO;
                $obj->DESCRIPCION       = $Articulo->DESCRIPCION;
                $obj->UND               = $Articulo->UND;
                $obj->ENTRADA           = ($ev == 'In') ? $cantidad_evento : 0 ;                
                $obj->SALIDA            = ($ev == 'In') ? 0 : $cantidad_evento ;
                $obj->STOCK             = $Existencia;
                $obj->TIPO_MOVIMIENTO   = $ev;
                $obj->FECHA             = $Feha;
                $obj->OBSERVACION       = $cadenalimpia = preg_replace("[\n|\r|\n\r]", "", $observaciones);
                $obj->USUARIO           = Auth::id();
                $obj->save();
                

                Articulos::where('ID',  $id)->update([
                    "CANTIDAD"  => $Existencia,
                    "JUMBOS"    => $JB,
                    "created_at"    => date('Y-m-d H:i:s')
                ]);

            });
        } catch (Exception $e) {
            $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";

            return response()->json($mensaje);
        } 
    }
    public static function isExiste($Articulos)
    {
        return TablaArticulos::where('ARTICULO', $Articulos)->get();
    }
}
