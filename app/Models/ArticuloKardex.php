<?php


namespace App\Models;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

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
}
