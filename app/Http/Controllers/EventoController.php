<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Functions\CRUD;
use App\Models\Evento;
use App\Functions\Helper;

class EventoController extends Controller
{
    public function postEventos()
 	{
 		$CRUD = new CRUD('App\Models\Evento');
        return $CRUD->call(request()->fn, request()->ops);
	}
	
}
