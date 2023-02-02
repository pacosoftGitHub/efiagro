<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seccion;
use App\Functions\CRUD;

class SeccionesController extends Controller
{
    public function postSecciones()
 	{
 		$CRUD = new CRUD('App\Models\Seccion');
        return $CRUD->call(
			request()->fn, 
			request()->ops
		);
 	} 

    
}
