<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Functions\CRUD;
use App\Models\LoteCosechas;
use App\Functions\Helper;

class LoteCosechasController extends Controller
{
    public function postlotecosechas()
 	{
		$CRUD = new CRUD('App\Models\LoteCosechas');
		return $CRUD->call(request()->fn, request()->ops);
	}
	public function getCosechalote($lote, $fecha)
	 {
		$LoteCosechas = LoteCosechas::where('lote_id', $lote)->orderBy('fecha','Asc')->limit(4)->get();
		return $LoteCosechas;
	 } 

	 //INICIO DEV ANGELICA
	 /*public function postRegistrar(Request $request){
		$d = new LoteLaboresRealizadas(); 
		$d->lote_id
	 }*/
	 //FIN DEV ANGELICA
}
