<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zona;
use App\Functions\CRUD;

class ZonasController extends Controller
{
    public function postZonas() {
		$CRUD = new CRUD('App\Models\Zona');
        return $CRUD->call(request()->fn, request()->ops);
	}

	public function postObtener()
	{
		$Zona = Zona::All();
		return $Zona;
	} 
}
