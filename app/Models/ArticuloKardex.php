<?php


namespace App\Models;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArticuloKardex extends Model
{
    protected $connection = 'sqlsrv';
    public $timestamps = false;
    protected $table = "PRODUCCION.dbo.tbl_inventario_innova_kardex";

    public static function getKardex(Request $request)
    {
        $id = $request->input('ArticuloID');
        $d1 = $request->input('DateStart');
        $d2 = $request->input('DateEnd');
        return ArticuloKardex::where('ID_ART ',$id)
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

        $dtFechas = ArticuloKardex::select('FECHA')
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
            foreach($json_arrays['header_date'] as $dtFecha => $valor){

                $rows_in = 'IN01_'.date('Ymd',strtotime($valor));
                $rows_out = 'OUT02_'.date('Ymd',strtotime($valor));
                $rows_stock = 'STOCK03_'.date('Ymd',strtotime($valor));

                $json_arrays['header_date_rows'][$i][$rows_in] = ($r->$rows_in=='0.0' || $r->$rows_in=='00.00') ? '' : number_format($r->$rows_in,2)  ;
                $json_arrays['header_date_rows'][$i][$rows_out] = ($r->$rows_out=='0.0' || $r->$rows_out=='00.00') ? '' : number_format($r->$rows_out,2);
                $json_arrays['header_date_rows'][$i][$rows_stock] =($r->$rows_stock=='0.0' || $r->$rows_stock=='00.00') ? '' : number_format($r->$rows_stock,2) ;
            }
            $i++;
        }



        return $json_arrays;
    }
}
