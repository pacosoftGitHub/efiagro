<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Functions\CRUD;
use App\Models\Labor;

class LaboresController extends Controller
{
    public function postLabores()
	{
		$CRUD = new CRUD('App\Models\Labor');
		return $CRUD->call(request()->fn, request()->ops);
	}

	public function postObtener()
	{
		$Labor = Labor::All();
		return $Labor;
	} 
}
