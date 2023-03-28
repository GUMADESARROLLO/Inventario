<?php

namespace App\Models;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Articulos extends Model
{
    protected $connection = 'sqlsrv';
    public $timestamps = false;
    protected $table = "PRODUCCION.dbo.tbl_inventario_innova";

    public static function getArticulos()
    {
        if (Auth::check()){
            /*$Bodegas = array();
            $Usuario = Usuario::where('id',Auth::id())->get();
            foreach ($Usuario as $rec){            
                foreach ($rec->Detalles as $Rts){
                    $Bodegas[] = $Rts->BODEGA;
                }
            }*/
            return Articulos::where('ID_USER',Auth::id())->get();
        }
    }
}
