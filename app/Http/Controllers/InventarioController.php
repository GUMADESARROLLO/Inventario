<?php
namespace App\Http\Controllers;
use App\Models\Articulos;
use Illuminate\Http\Request;
use App\Models\TablaArticulos;
class InventarioController extends Controller {
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getHome()
    {        
        $Productos      = Articulos::getArticulos();  
        return view('Inventario.Home', compact('Productos'));
   
    }

    public function postGuardarInventario(Request $request)
    {
        $response = TablaArticulos::GuardarListas($request);
        return response()->json($response);
    }
}  