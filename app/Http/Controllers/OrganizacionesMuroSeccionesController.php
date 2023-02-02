<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\OrganizacionesMuroSecciones;
use App\Functions\CRUD;

class OrganizacionesMuroSeccionesController extends Controller
{
 	public function postOrganizacionesmurosecciones()
 	{
 		$CRUD = new CRUD('App\Models\OrganizacionesMuroSecciones');
        return $CRUD->call(request()->fn, request()->ops);
 	}

}
