<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Functions\CRUD;
use App\Models\Lote;
use App\Functions\Helper;
use App\Models\Finca;

class LoteController extends Controller
{
    public function postLotes()
 	{
 		$CRUD = new CRUD('App\Models\Lote');
        return $CRUD->call(request()->fn, request()->ops);
	}
	

	public function postTareasLote()
 	{
 		$CRUD = new CRUD('App\Models\LoteTarea');
        return $CRUD->call(request()->fn, request()->ops);
	}
	
	public function postObtener()
	{
		$Lotes = TareasLotes::with(['tarea'])->activos()->accesibles()->get();
		return $Lotes;
	}

	// Funcion para obtener los lotes de las fincas segun el id :: Luigi
	public function postFinca()
    {
		$finca = request('finca');
		return Lote::where('finca_id', $finca)->get();
    }

	// Funcion para obtener las fincas y luego los lotes de las fincas que corresponden a un usuario_id :: Luigi
	public function postFincas()
    {
		$usuario = request('usuario');
		$fincas = Finca::where('usuario_id', $usuario)->get('id');
		return Lote::whereIn('finca_id', $fincas)->get();
    }

	public function postActualizar(Request $req)
	{
        // dd($req);
		$campos = $req->Datos;
		$lote = Lote::findOrFail($campos['id']);
            $lote->organizacion_id 	    = $campos['organizacion_id'];
            $lote->linea_productiva_id 	= $campos['linea_productiva_id'];
            $lote->labores_id       	= $campos['labores_id']; // 0; // 
            $lote->hectareas 			= $campos['hectareas'];
            $lote->sitios    			= $campos['sitios'];
            $lote->coordenadas      	= $campos['coordenadas'];
            $lote->fecha_establecimiento= substr($campos['fecha_establecimiento'], 0, 10);
            $lote->kg_promedio			= $campos['kg_promedio'];
            $lote->un_promedio			= $campos['un_promedio'];
            $lote->frec_corte			= $campos['frec_corte'];
        $lote->save();
	}

	public function postCrear(Request $req)
	{
        // dd($req);
		$campos = $req->Datos;
        //dd($campos['fecha_establecimiento']);
        $lote = new Lote();
            $lote->finca_id      		= $req->finca;
            $lote->organizacion_id   	= $req->organizacion;
            $lote->linea_productiva_id 	= $campos['linea_productiva_id'];
            $lote->labores_id       	= 0; // $campos['labores_id']; 
            $lote->hectareas 			= $campos['hectareas'];
            $lote->sitios    			= $campos['sitios'];
            $lote->coordenadas      	= $campos['coordenadas'];
            $lote->fecha_establecimiento= substr($campos['fecha_establecimiento'], 0, 10);
            $lote->kg_promedio			= $campos['kg_promedio'];
            $lote->un_promedio			= $campos['un_promedio'];
            $lote->frec_corte			= $campos['frec_corte'];
        $lote->save();
	}

    // Funcion para obtener las fincas y luego los lotes de las fincas que corresponden a un usuario_id :: Luigi
	public function postLineaproductivausuario()
    {
		$usuario = request('usuario');
		$fincas = Finca::where('usuario_id', $usuario)->get('id');
		return Lote::whereIn('finca_id', $fincas)->distinct('linea_productiva_id')->get(['linea_productiva_id']);
    }

}
