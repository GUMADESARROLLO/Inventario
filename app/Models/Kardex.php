<?php
namespace App\Models;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kardex extends Model
{
    protected $connection = 'sqlsrv';
    public $timestamps = false;
    protected $table = "PRODUCCION.dbo.tbl_inventario_innova_kardex";
    public function articulo()
    {
        return $this->belongsTo(Articulos::class,'ID_ART');
    }

    public static function getKardex(Request $request)
    {
        $id = $request->input('ArticuloID');
        $d1 = $request->input('DateStart');
        $d2 = $request->input('DateEnd');
        return Kardex::where('ID_ART ',$id)
                ->orderBy('ID', 'DESC')
                ->whereBetween('FECHA', [$d1, $d2])
                ->get();
    }

    public static function getReporteKardex(Request $request)
    {
        $d1 = $request->input('startDate');
        $d2 = $request->input('endDate');

        $json_arrays = array();
        $i = 0 ;
        $Id = Auth::id();

        $dtFechas = Kardex::select('FECHA')
                ->whereBetween('FECHA', [$d1, $d2])
                ->groupBy('FECHA')
                ->get();

        $json_arrays['header_date_count'] = count($dtFechas) ;

        foreach($dtFechas as $f){
            $json_arrays['header_date'][$i] = $f->FECHA;
            $i++;
        }
        
        $Rows = DB::connection('sqlsrv')->select('SET NOCOUNT ON ;EXEC PRODUCCION.dbo.gnet_calcular_kardex '."'".$d1."'".','."'".$d2."'".', '."'".$Id."'".'');
        foreach($Rows as $r){


        
            $json_arrays['header_date_rows'][$i]['ARTICULO'] = $r->ARTICULO;
            $json_arrays['header_date_rows'][$i]['DESCRIPCION'] = $r->DESCRIPCION;
            $json_arrays['header_date_rows'][$i]['UND'] = $r->UND;
            foreach($json_arrays['header_date'] as $dtFecha => $valor){

                $rows_in = 'IN01_'.date('Ymd',strtotime($valor));
                $rows_out = 'OUT02_'.date('Ymd',strtotime($valor));
                $rows_stock = 'STOCK03_'.date('Ymd',strtotime($valor));

                $json_arrays['header_date_rows'][$i][$rows_in] = ($r->$rows_in=='0.0' || $r->$rows_in=='00.00') ? '' : number_format($r->$rows_in,2)  ;
                $json_arrays['header_date_rows'][$i][$rows_out] = ($r->$rows_out=='0.0' || $r->$rows_out=='00.00') ? '' : number_format($r->$rows_out,2);
                $json_arrays['header_date_rows'][$i][$rows_stock] =($r->$rows_stock=='0.0' || $r->$rows_stock=='00.00') ? '' : number_format($r->$rows_stock,2) ;

                $json_arrays['header_date_rows'][$i]['IN_TODAY'] = ($r->IN_TODAY=='0.0' || $r->IN_TODAY=='00.00') ? '' : number_format($r->IN_TODAY,2)  ;
                $json_arrays['header_date_rows'][$i]['OUT_TODAY'] = ($r->OUT_TODAY=='0.0' || $r->OUT_TODAY=='00.00') ? '' : number_format($r->OUT_TODAY,2);
                $json_arrays['header_date_rows'][$i]['STOCK_TODAY'] =($r->STOCK_TODAY=='0.0' || $r->STOCK_TODAY=='00.00') ? '' : number_format($r->STOCK_TODAY,2) ;
            }
            $i++;
        }




        return $json_arrays;
    }

    public static function initKardex(Request $request)
    {
        try {
            $inserts = array(); // Nombres en plural para variables que contienen múltiples valores
            $articulosKardex = array(); // Cambiado el nombre de la variable para seguir estándares

            // Se busca en la tabla Kardex los artículos que ya han sido agregados al kardex por el usuario actual
            $articulosKardex = Kardex::where('USUARIO', Auth::id())->groupBy('ID_ART')->pluck('ID_ART')->toArray();

            // Se buscan los artículos que aún no han sido agregados al kardex
            $articulos = Articulos::getArticulos()->whereNotIn('ID', $articulosKardex);

            // Se recorre el array de artículos no agregados para preparar el array de inserts
            foreach ($articulos as $key => $val) {
                $inserts[$key]['ID_ART']           = $val->ID;
                $inserts[$key]['ARTICULO']         = $val->ARTICULO;
                $inserts[$key]['DESCRIPCION']      = $val->DESCRIPCION;
                $inserts[$key]['ENTRADA']          = 0;
                $inserts[$key]['SALIDA']           = 0;
                $inserts[$key]['STOCK']            = $val->CANTIDAD;
                $inserts[$key]['TIPO_MOVIMIENTO']  = 'In';
                $inserts[$key]['FECHA']            = date('Y-m-d');
                $inserts[$key]['USUARIO']          = Auth::id();
                $inserts[$key]['created_at']       = date('Y-m-d H:i:s');
                $inserts[$key]['OBSERVACION']      = 'INVENTARIO INICIAL';
            }

            // Se insertan los datos en la tabla Kardex
            Kardex::insert($inserts);
            
        } catch (Exception $e) {
            $mensaje = 'Excepción capturada: ' . $e->getMessage() . "\n";
            return response()->json($mensaje);
        }
    }

    public static function rmKardex(Request $request)
    {
        if ($request->ajax()) {
            try {

                $id         = $request->input('id');
                $registro   = Kardex::find($id);
                $articulo   = $registro->articulo;
                $Cantidad   = $articulo->getCANTIDAD();                

                $Cantidad = ($registro->TIPO_MOVIMIENTO=='In')? $Cantidad - $registro->ENTRADA : $Cantidad + $registro->SALIDA;

                Articulos::where('ID',  $registro->ID_ART)->update([
                    "CANTIDAD"  => $Cantidad,
                    "created_at"    => date('Y-m-d H:i:s')
                ]);
                
                $response =   Kardex::where('ID',  $id)->delete();

                return response()->json($response);


            } catch (Exception $e) {
                $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";
                return response()->json($mensaje);
            }
        }
    }
}
