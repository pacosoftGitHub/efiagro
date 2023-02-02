<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LotesLabores;
use App\Models\Labor as Labores;
use App\Models\Lotes;
use App\Functions\CRUD;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class LotesLaboresController extends Controller
{
    public function postLotesLabores()
 	{
 		$CRUD = new CRUD('App\Models\LotesLabores');
        return $CRUD->call(request()->fn, request()->ops);
	}

	public function postObtener()
	{
		$LotesLabores = LotesLabores::All();
		return $LotesLabores;
	}

    public function postPersonalizar(Request $req)
	{
		$fields = $req->Datos;
        // dd($fields);
        // $LotesLabores = new LotesLabores();
        //     $LotesLabores->lote_id          = $fields['lote'];
        //     $LotesLabores->labor_id         = $fields['labor'];
        //     $LotesLabores->labor            = $fields['labor_des'];
        //     $LotesLabores->inicio           = $fields['inicio'];
        //     $LotesLabores->frecuencia       = $fields['frecuencia'];
        //     $LotesLabores->margen           = $fields['margen'];
        // $LotesLabores->save();
        $this->obtenerLabores($fields['zona'], $fields['linea'], $fields['lote']);
	}

    // Obtener la informacion de labores unida con los datos del lote.
    public function postLoteid(Request $req)
	{
		return LotesLabores::
            join('lotes', 'lotes.id', '=', 'lote_id')
            ->where("lote_id", $req->lote)
            ->get();
	}

    public function obtenerLabores($zona, $linea, $lote)
	{
        // Consultamos las Labores para la Zona y Linea productiva
		$Labores = Labores::where('zona_id', $zona)
            ->where('linea_productiva_id', $linea)
            ->get();
        
        if ( count($Labores) > 0 ) {
            // echo 'Hay labores';
            // Si existen labores, entonces, validar si AUN no estan registradas, para crear el cronograma
            $existeCronograma = LotesLabores::where('lote_id', $lote)
            ->get();
            if ( !$existeCronograma ) {
                foreach ( $Labores as $labor ) {
                    //echo $labor['labor'] . '<br>';
                    $LotesLabores = new LotesLabores();
                        $LotesLabores->lote_id          = $lote;
                        $LotesLabores->labor_id         = $labor['id'];
                        $LotesLabores->labor            = $labor['labor'];
                        $LotesLabores->inicio           = $labor['inicio'];
                        $LotesLabores->frecuencia       = $labor['frecuencia'];
                        $LotesLabores->margen           = $labor['margen'];
                    $LotesLabores->save();
            }
        }
            } else {
            // Pendiente definir la actividad a realizar.
            // echo 'Sin labores';
        }
	}

    public function postCrear(Request $req)
	{
        $LotesLabores = new LotesLabores();
            $LotesLabores->lote_id          = $req['lote_id'];
            $LotesLabores->labor_id         = $req['labor_id'];
            $LotesLabores->labor            = $req['labor'];
            $LotesLabores->inicio           = $req['inicio'];
            $LotesLabores->frecuencia       = $req['frecuencia'];
            $LotesLabores->margen           = $req['margen'];
        $LotesLabores->save();
	}
        
    public function postActualizar(Request $req)
	{
        LotesLabores::where('lote_id', '=', $req['lote_id'])
            ->where('labor', '=', $req['labor'])
            ->update($req->all());
	}

}