<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Functions\CRUD;
use App\Models\Organizacion;
use App\Models\UsuarioOrganizacion;
use App\Models\Infpromedioproduccion as Promedio;
use App\Models\Departamento;
use App\Functions\Helper;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class OrganizacionController extends Controller
{
    public function postOrganizaciones()
	{
		$CRUD = new CRUD('App\Models\Organizacion');
        return $CRUD->call(request()->fn, request()->ops);
	}
	
	public function postDepartamentos()
 	{
 		$CRUD = new CRUD('App\Models\Departamento');
        return $CRUD->call(request()->fn, request()->ops);
	}

	public function postObtenerOrganizacion()
	{
		$Usuario = Helper::getUsuario();
		$Organizacion = Organizacion::where('id', $Usuario->organizacion_id)->first();
		return $Organizacion;
	}

    public function postDatosOrganizacion(Request $request)
	{
		$Organizacion = Organizacion::where('id', $request->input("organizacion_id"))->first();
		return $Organizacion;
	}

	// Funcion para obtener las organizaciones que corresponden a un usuario_id
	public function postUsuario()
    {
		$usuario = request('usuario');
		return UsuarioOrganizacion::
            join('organizaciones', 'organizaciones.id', '=', 'organizacion_id')
            ->where("usuario_organizacion.usuario_id", $usuario)
            ->get();
    }

	// Funcion para obtener las organizaciones que corresponden a un usuario_id
	public function postUsuarios()
    {
		$organizacion = request('organizacion');
		return UsuarioOrganizacion::
            join('usuarios', 'usuarios.id', '=', 'usuario_id')
            ->where("usuario_organizacion.organizacion_id", $organizacion)
            ->get();
    }

	// Funcion para obtener las organizaciones que no se han asignado a un usuario_id
	public function postNoasignada()
    {
		$usuario = request('usuario');
		$organizaciones = UsuarioOrganizacion::select('organizacion_id')
            ->where("usuario_id", $usuario)
            ->get();
		
		return Organizacion::whereNotIn("id", $organizaciones)
            ->get();
    }

	public function postCrearusuarioorganizacion(Request $req)
	{
        $OU = new UsuarioOrganizacion();
            $OU->usuario_id		= $req['usuario'];
            $OU->organizacion_id= $req['organizacion'];
        $OU->save();
	}

	public function postLinea(Request $req)
	{
		return Organizacion::where('linea_productiva_id', $req['linea'])
			->get();
	}

	// Funcion para obtener el ultimo registro activo del informe de Promedio de Produccion
	public function postPromedioproduccion()
    {
		$organizacion = request('organizacion');
		return Promedio::where("organizacion_id", $organizacion)
            ->where("estado", "A")
            ->get();
    }

    // Funcion para calcular el valor de la produccion por cada Organizacion.
	public function getCalculoproduccion()
    {
		$periodoActual = intval(date('m')/2);
		$datosActuales = Promedio::where("estado", "A")
            ->get();
        $anio = date('Y');
        if ( $periodoActual == 1 ) {
            $inicio = $anio . '-11-01';
            $final = $anio . '-12-31';
            $periodoActual = 6;
        } else {
            $periodoActual--;
            $mes2 = $periodoActual * 2;
            $inicio = $anio . '-' . ( $mes2 - 1 ) . '-01';
            $final = $anio . '-' . $mes2 . '-31';
        }
        echo $periodoActual." / ".$mes2;die;
        //echo empty($datosActuales) ? $datosActuales[0]['periodo'] : "Sin Datos";
        //die;

        if ($datosActuales[0]['periodo'] == $periodoActual ) {
            return;
        } else {
            $organizaciones = Organizacion::All();
            for ($o = 0; $o < count($organizaciones); $o++ ) {
                $idLotePromedio = 0;
                $valores = DB::select("SELECT AVG(l.hectareas) as 'hectareas', SUM(kilogramo) as kilogramos
                    FROM lotes l
                        inner join lotes_cosechas c on l.id = c.lote_id
                    where l.organizacion_id = {$organizaciones[$o]['id']} and c.fecha between '$inicio' and '$final' ");
                foreach ($valores as $otro) {
                    $hectareas = $otro->hectareas;
                    $kilogramos = $otro->kilogramos;
                    if ( $hectareas > 0 && $kilogramos > 0 ) {
                        $promedio = $kilogramos / $hectareas;
                    } else {
                        $promedio = 0;
                    }
                    $datosOrg = Promedio::where("estado", "A")
                        ->where("organizacion_id", $organizaciones[$o]['id'])
                        ->get();
                    if ( count($datosOrg) > 0 ) {
                        foreach ($datosOrg as $datosOrgOK) {
                            $datos = new Promedio([
                                'organizacion_id' => $organizaciones[$o]['id'],
                                'periodo'=> $periodoActual,
                                'bimestre1'=> $promedio,
                                'bimestre2'=> $datosOrgOK->bimestre1,
                                'bimestre3'=> $datosOrgOK->bimestre2,
                                'bimestre4'=> $datosOrgOK->bimestre3,
                                'bimestre5'=> $datosOrgOK->bimestre4,
                                'bimestre6'=> $datosOrgOK->bimestre5,
                                'estado' => 'A'
                            ]);
                            $idLotePromedio = $datosOrgOK->id;
                        }
                        $inactivar = Promedio::findOrFail($idLotePromedio);
                        $inactivar->estado = 'I';
                        $inactivar->deleted_at = date('Y-m-d');
                        $inactivar->save();
                    } else {
                        $datos = new Promedio([
                            'organizacion_id' => $organizaciones[$o]['id'],
                            'periodo'=> $periodoActual,
                            'bimestre1'=> $promedio,
                            'bimestre2'=> 0,
                            'bimestre3'=> 0,
                            'bimestre4'=> 0,
                            'bimestre5'=> 0,
                            'bimestre6'=> 0,
                            'estado' => 'A'
                        ]);
                    }
                    $datos->save();
                }
            }
        }
    }
}
