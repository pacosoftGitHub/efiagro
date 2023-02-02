<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Functions\CRUD;
use App\Models\Opcion;
use App\Functions\Helper;

class OpcionesController extends Controller
{
    public function postOpciones()
 	{
 		$CRUD = new CRUD('App\Models\Opcion');
        return $CRUD->call(request()->fn, request()->ops);
	}

	public function postIndex()
	{
		$Opciones = Helper::getOpciones();
		return $Opciones;
	}
	public function postActualizar()
	{
		$Opciones = request('Opciones');
		foreach($Opciones as $O){
			$Opcion = Opcion::where('organizacion_id', 1)
			->where('opcion', $O['opcion'])->first();
			$Opcion->valor = $O['valor'];
			$Opcion->save();

		}
		// dd($req);		
	}



	public function postGetOpciones(Request $request)
	{
		//echo $request->input("organizacion_id");
		$Opciones = Helper::getOpcionesOrganizacion($request->input("organizacion_id"));
		return $Opciones;
	}


	//Funciones Juan Carlos
	public function adicionar(Request $request){

		$fecha_hoy = "2023-01-23";//date('Y-m-d');
		$datos = array();
		$datos[] = array(
			"organizacion_id" => $request->input("organizacion_id"),
			"opcion" => "CREDITO_INTERES",
			"tipo" => "Decimal",
			"valor" => 12.5,
			"created_at" => $fecha_hoy,
			"updated_at" => $fecha_hoy
		);
		$datos[] = array(
			"organizacion_id" => $request->input("organizacion_id"),
			"opcion" => "CREDITO_MORA_MENOS_30",
			"tipo" => "Decimal",
			"valor" => 22.2,
			"created_at" => $fecha_hoy,
			"updated_at" => $fecha_hoy
		);
		$datos[] = array(
			"organizacion_id" => $request->input("organizacion_id"),
			"opcion" => "CREDITO_MORA_31_60",
			"tipo" => "Decimal",
			"valor" => 2.3,
			"created_at" => $fecha_hoy,
			"updated_at" => $fecha_hoy
		);
		$datos[] = array(
			"organizacion_id" => $request->input("organizacion_id"),
			"opcion" => "CREDITO_MORA_61_90",
			"tipo" => "Decimal",
			"valor" => 2.4,
			"created_at" => $fecha_hoy,
			"updated_at" => $fecha_hoy
		);
		$datos[] = array(
			"organizacion_id" => $request->input("organizacion_id"),
			"opcion" => "CREDITO_MORA_91_120",
			"tipo" => "Decimal",
			"valor" => 2.5,
			"created_at" => $fecha_hoy,
			"updated_at" => $fecha_hoy
		);
		$datos[] = array(
			"organizacion_id" => $request->input("organizacion_id"),
			"opcion" => "CREDITO_MORA_MAS_120",
			"tipo" => "Decimal",
			"valor" => 3.25,
			"created_at" => $fecha_hoy,
			"updated_at" => $fecha_hoy
		);

		$resultado = Opcion::insert($datos);

		return json_encode($resultado);
	}

	public function actualizar(Request $request){

		$datos = json_decode($request->input("intereses"), true);
		$organizacion_id = $request->input("organizacion_id");

		Opcion::where('organizacion_id',$organizacion_id)->where('opcion','CREDITO_INTERES')->update(['valor' => $datos["interes"]]);
		Opcion::where('organizacion_id',$organizacion_id)->where('opcion','CREDITO_MORA_MENOS_30')->update(['valor' => $datos["interes3160"]]);
		Opcion::where('organizacion_id',$organizacion_id)->where('opcion','CREDITO_MORA_31_60')->update(['valor' => $datos["interes6190"]]);
		Opcion::where('organizacion_id',$organizacion_id)->where('opcion','CREDITO_MORA_61_90')->update(['valor' => $datos["interes91120"]]);
		Opcion::where('organizacion_id',$organizacion_id)->where('opcion','CREDITO_MORA_91_120')->update(['valor' => $datos["interesmas120"]]);
		Opcion::where('organizacion_id',$organizacion_id)->where('opcion','CREDITO_MORA_MAS_120')->update(['valor' => $datos["interesmenos30"]]);
	}

		
}