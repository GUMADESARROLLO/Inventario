<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Bodegas extends Model
{
    protected $connection = 'sqlsrv';
    public $timestamps = false;
    protected $table = "Softland.innova.bodega";


    public static function getBodegas()
    {  
        return Bodegas::all();
        //return Vendedor::whereIn('VENDEDOR',['F05'])->get();
    }

   
}
