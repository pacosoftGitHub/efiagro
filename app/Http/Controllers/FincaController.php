<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Functions\CRUD;
use App\Models\Finca;

class FincaController extends Controller
{
    public function postFincas()
 	{
 		$CRUD = new CRUD('App\Models\Finca');
        return $CRUD->call(request()->fn, request()->ops);
	}

	public function zonasFincas()
    {
        $Finca = Finca::where('id', $id)->with([ 'zonas' ])->first();
        return $Finca;
    }

    // Funcion para obtener las fincas que corresponden a un usuario_id
	public function postUsuario()
    {
        $usuario = request('usuario');
        $Fincas = Finca::where('usuario_id', $usuario)->get();
        return $Fincas;
    }

    public function postObtener()
	{
		$Finca = Finca::All();
		return $Finca;
	} 

    public function postActualizar(Request $req)
	{
		$campos = $req->Datos;
		$finca = Finca::findOrFail($campos['id']);
            $finca->nombre          = $campos['nombre'];
            $finca->direccion       = $campos['direccion'];
            $finca->departamento_id = $campos['departamento_id'];
            $finca->municipio_id    = $campos['municipio_id'];
            $finca->area_total      = $campos['area_total'];
            $finca->tipo_cultivo    = $campos['tipo_cultivo'];
            $finca->total_lotes     = $campos['total_lotes'];
            $finca->tipo_suelo      = $campos['tipo_suelo'];
            $finca->zona_id         = $campos['zona_id'];
            $finca->latitud         = $campos['latitud'];
            $finca->longitud        = $campos['longitud'];
            $finca->hectareas       = $campos['hectareas'];
            $finca->sitios          = $campos['sitios'];
            $finca->temperatura     = $campos['temperatura'];
            $finca->humedad_relativa= $campos['humedad_relativa'];
            $finca->precipitacion   = $campos['precipitacion'];
            $finca->altimetria      = $campos['altimetria'];
            $finca->pendiente       = $campos['pendiente'];
            $finca->brillo_solar    = $campos['brillo_solar'];
        $finca->save();
	}

    public function postCrear(Request $req)
	{
        // echo 'hola';
		$campos = $req->Datos;
        // dd($campos['nombre']);
        $finca = new Finca();
            $finca->usuario_id      = $req->usuario;
            $finca->nombre          = $campos['nombre'];
            $finca->direccion       = $campos['direccion'];
            $finca->departamento_id = $campos['departamento_id'];
            $finca->municipio_id    = $campos['municipio_id'];
            $finca->area_total      = isset($campos['area_total']) ? $campos['area_total'] : NULL;
            $finca->tipo_cultivo    = isset($campos['tipo_cultivo']) ? $campos['tipo_cultivo'] : NULL;
            $finca->total_lotes     = isset($campos['total_lotes']) ? $campos['total_lotes'] : NULL;
            $finca->tipo_suelo      = isset($campos['tipo_suelo']) ? $campos['tipo_suelo'] : NULL;
            $finca->zona_id         = isset($campos['zona_id']) ? $campos['zona_id'] : NULL;
            $finca->latitud         = isset($campos['latitud']) ? $campos['latitud'] : NULL;
            $finca->longitud        = isset($campos['longitud']) ? $campos['longitud'] : NULL;
            $finca->hectareas       = isset($campos['hectareas']) ? $campos['hectareas'] : NULL;
            $finca->sitios          = isset($campos['sitios']) ? $campos['sitios'] : NULL;
            $finca->temperatura     = isset($campos['temperatura']) ? $campos['temperatura'] : NULL;
            $finca->humedad_relativa= isset($campos['humedad_relativa']) ? $campos['humedad_relativa'] : NULL;
            $finca->precipitacion   = isset($campos['precipitacion']) ? $campos['precipitacion'] : NULL;
            $finca->altimetria      = isset($campos['altimetria']) ? $campos['altimetria'] : NULL;
            $finca->pendiente       = isset($campos['pendiente']) ? $campos['pendiente'] : NULL;
            $finca->brillo_solar    = isset($campos['brillo_solar']) ? $campos['brillo_solar'] : NULL;
        $finca->save();
	}

    public function organizaciones()
    {
        $Finca = Finca::where('id', $id)->with([ 'zonas' ])->first();
        return $Finca;
    }

    public function postFincasMapa(Request $id){
        $fincas = Finca::select('fincas.*')
                        ->join('usuarios', 'fincas.usuario_id', '=' , 'usuarios.id')
                        ->join('usuario_organizacion','usuarios.id','=','usuario_organizacion.usuario_id')
                        ->where('usuario_organizacion.organizacion_id','=',$id)
                        ->get();
    }
}