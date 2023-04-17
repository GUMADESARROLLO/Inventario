<?php

namespace App\Models;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Articulos extends Model
{
    protected $connection = 'sqlsrv';
    public $timestamps = false;
    protected $table = "PRODUCCION.dbo.tbl_inventario_innova";

  
    public function user()
    {
        return $this->belongsTo(Usuario::class, 'ID_USER');
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
}
