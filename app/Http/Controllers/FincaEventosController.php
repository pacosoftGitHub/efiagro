<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Functions\CRUD;
use App\Models\FincaEvento;
use App\Functions\Helper;

class FincaEventosController extends Controller
{
    public function postfincaeventos()
 	{
 		$CRUD = new CRUD('App\Models\FincaEvento');
        return $CRUD->call(request()->fn, request()->ops);
	}
	
}
