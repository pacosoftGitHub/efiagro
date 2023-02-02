<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CasoNovedad;
use App\Models\Caso;
use App\Functions\CRUD;

class ContactoController extends Controller
{
    public function postCasos()
 	{
 		$CRUD = new CRUD('App\Models\Caso');
        return $CRUD->call(request()->fn, request()->ops);
	}
	
	public function postNovedades()
 	{
 		$CRUD = new CRUD('App\Models\CasoNovedad');
        return $CRUD->call(request()->fn, request()->ops);
	}
	
	public function postObtener()
	{
		$Casos = CasoNovedad::with(['novedades', 'solicitante'])->activos()->accesibles()->get();
		return $Casos;
	} 
	
}
