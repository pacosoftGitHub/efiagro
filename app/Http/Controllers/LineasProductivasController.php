<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LineaProductiva;
use App\Functions\CRUD;

class LineasProductivasController extends Controller
{
    public function postLineasproductivas()
 	{
 		$CRUD = new CRUD('App\Models\LineaProductiva');
        return $CRUD->call(request()->fn, request()->ops);
	}

	public function postObtener()
	{
		$LineaProductiva = LineaProductiva::All();
		return $LineaProductiva;
	} 
}
