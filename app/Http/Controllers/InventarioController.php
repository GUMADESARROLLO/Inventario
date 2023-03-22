<?php
namespace App\Http\Controllers;
class InventarioController extends Controller {
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getHome()
    {          
        //return view('Inventario.Home', compact(''));
        return view('Inventario.Home');
    }
}  