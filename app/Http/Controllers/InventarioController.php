<?php
namespace App\Http\Controllers;

use App\Models\Articulos;
use Illuminate\Http\Request;
use App\Models\ArticuloKardex;
use App\Models\Clasificacion;

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
        $response = Articulos::GuardarListas($request);
        return response()->json($response);
    }
    public function postKardex(Request $request)
    {
        $response = ArticuloKardex::getKardex($request);
        return response()->json($response);
    }
    public function InitKardex(Request $request)
    {
        ArticuloKardex::initKardex($request);
    }

    public function getKardex(Request $request)
    {
        $d1 = $request->input('startDate');
        $d2 = $request->input('endDate');

        $Kardex = ArticuloKardex::getReporteKardex($request);
        return view('Inventario.Kardex', compact('Kardex','d1','d2'));
    }

    public function rmKardex(Request $request)
    {
        $response = ArticuloKardex::rmKardex($request);
        return response()->json($response);
    }

    public function GuardarCantidad(Request $request)
    {
        
        Articulos::GuardarCantidad($request);
        
        return back()->withInput();
    }

    public function getArticulos()
    {  
        $Articulos      = Articulos::getArticulos();
        $Clasifica      = Clasificacion::all();
        
        return view('Inventario.Articulos', compact('Articulos','Clasifica'));         
    }
    public function UpdateArticulo(Request $request)
    {
        $response = Articulos::UpdateArticulo($request);
        return response()->json($response);
    }
}  