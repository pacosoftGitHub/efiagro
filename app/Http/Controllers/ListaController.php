<?php
//Inicio Dev ANGÉLICA

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListaDetalle;
use App\Models\Lista;
use App\Functions\CRUD;

class ListaController extends Controller
{
    public function postListas()
 	{
 		$CRUD = new CRUD('App\Models\Lista');
        return $CRUD->call(request()->fn, request()->ops);
	}
	
	public function postDetalles()
 	{
 		$CRUD = new CRUD('App\Models\ListaDetalle');
        return $CRUD->call(request()->fn, request()->ops);
	}

	public function getLista($id)
	{
		//$L = Lista:: with ("listadetalle") -> where ("id", 1); // me trae la lista con los detalles donde el id sea 1
		$L = Lista::with ("listadetalle")->where("id", $id)->first();
		return $L;
	}

	//
	public function postObtenerdetalle()
	{
		$lista_id = request('lista_id');
		$codigo = request('codigo');
		//$L = Lista:: with ("listadetalle") -> where ("id", 1); // me trae la lista con los detalles donde el id sea 1
		$D = ListaDetalle::where("lista_id", $lista_id)->where("codigo", $codigo)->first();
		return $D;
	}
	//

	public function postObtener()
	{
		$lista = request('lista');

		$L = Lista::where('lista', $lista)->first();
		$Q = ListaDetalle::where('lista_id', $L->id);

		if(request('Op1')){ $Q = $Q->where('op1', request('Op1')); }

		return $Op = $Q->get()->keyBy('codigo')->transform(function($op){
			return $op->descripcion;
		});
	}



	public function getDepartamentos()
	{
		$L = ListaDetalle::where("lista_id", 2)->get();
		foreach($L as $$listadetalles){
			$LM = ListaDetalle::where("lista_id", 3) //LM = LISTA MUNICIPIOS
			->where("op1",$listadetalles->codigo)
			->get(); 
			$listadetalles->municipios=$LM;
		}
		return $L;
	}

	public function postActualizar(Request $req)
	{
		$lista=$req->Lista;
		$listadetalles=$req->Lista['listadetalle'];
		foreach($listadetalles as $d){
			if($d['id']>0){ 
				$listadetalle=ListaDetalle::findOrFail($d['id']);
			}else{
				$listadetalle = new Listadetalle();
			}	
			if(strlen($d['descripcion'])>0){ //si no hay una descripcion, el sistema no actualiza
				$listadetalle->lista_id=$lista['id']; //todos los campos de la tabla
				$listadetalle->codigo=$d['codigo']; 
				$listadetalle->descripcion=$d['descripcion']; 
				$listadetalle->op1=$d['op1']; 
				$listadetalle->op2=$d['op2']; 
				$listadetalle->op3=$d['op3']; 
				$listadetalle->op4=$d['op4']; 
				$listadetalle->op5=$d['op5'];
				$listadetalle->save(); 
				//return $listadetalle;
			}		
		}
		$L = Lista::with ("listadetalle")->findOrFail($lista['id']); 
		return $L;
	}

	public function postDelete(Request $req)
	{
		$listadetalle=ListaDetalle::findOrFail($req->id);
		$id=$listadetalle->lista_id;
		$listadetalle->delete();
		/*$L = Lista::with ("listadetalle")->findOrFail($id); 
		return $L;*/
	}

	// Funcion para traer todos los registros de una tabla 
	// con un solo criterio de consulta y ordenado por la descripcion
	public function postListacompleta(Request $req)
	{
		return ListaDetalle::where("lista_id", $req->id)
			->orderBy('descripcion')
			->get();
	}
	
}
//fIN Dev ANGÉLICA