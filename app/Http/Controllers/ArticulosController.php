<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Articulo;
use App\Models\ArticuloSeccion;
use App\Functions\CRUD;

class ArticulosController extends Controller
{
 	public function postArticulos()
 	{
 		$CRUD = new CRUD('App\Models\Articulo');
        return $CRUD->call(request()->fn, request()->ops);
 	}

 	public function postSecciones()
 	{
 		$CRUD = new CRUD('App\Models\ArticuloSeccion');
        return $CRUD->call(request()->fn, request()->ops);
 	}

 	public function postObtener()
	{
		$Articulos = Articulo::with(['secciones', 'autor'])->activos()->accesibles()->get();
		return $Articulos;
	} 

}
