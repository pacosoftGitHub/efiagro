<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perfil;
use App\Models\PerfilSeccion;
use App\Functions\CRUD;
use Carbon\Carbon;

use function PHPSTORM_META\map;

class PerfilesController extends Controller
{
    public function postPerfiles()
 	{
 		$CRUD = new CRUD('App\Models\Perfil');
        return $CRUD->call(request()->fn, request()->ops);
 	}

	public function postSecciones()
 	{
 		$CRUD = new CRUD('App\Models\PerfilSeccion');
        return $CRUD->call(request()->fn, request()->ops);
 	}

	public function postGuardarPermisos()
 	{
 		$perfil_id = request()->perfil_id;
 		$secciones = request()->secciones;
		PerfilSeccion::perfil($perfil_id)->delete();
		
		$perfilessecciones = collect($secciones)->map( function ($s)  use ($perfil_id) {
			return [
				'perfil_id' 	=> $perfil_id,
				'seccion_id' 	=> $s['id'],
				'nivel' 		=> $s['nivel'],
				'created_at'	=> Carbon::now(),
				'updated_at'	=> Carbon::now()
			];
		})->toArray();
		// dd($perfilessecciones);
		PerfilSeccion::insert($perfilessecciones);
 	}
}
