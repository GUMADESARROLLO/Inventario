<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clasificacion extends Model
{
    protected $connection = 'sqlsrv';
    public $timestamps = false;
    protected $table = "PRODUCCION.dbo.tbl_inventario_innova_clasificacion";
   
}
