<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Functions\CRUD;
use App\Models\LoteLaboresRealizadas;
use App\Functions\Helper;

class LoteLaboresRealizadasController extends Controller
{
    public function postlotelaboresrealizadas()
 	{
		$CRUD = new CRUD('App\Models\LoteLaboresRealizadas');
		return $CRUD->call(request()->fn, request()->ops);
	}
	public function postObtener()
	 {
		$LoteLabores = LoteLabores::All();
		return $LoteLabores;
	 } 

	 //INICIO DEV ANGELICA
	 /*public function postRegistrar(Request $request){
		$d = new LoteLaboresRealizadas(); 
		$d->lote_id
	 }*/
	 //FIN DEV ANGELICA
}
