<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Functions\CRUD;
use App\Models\LotesLaboresProductor;
use App\Functions\Helper;

class LotesLaboresProductorController extends Controller
{
    public function postloteslaboresproductor()
 	{
 		$CRUD = new CRUD('App\Models\LotesLaboresProductor');
        return $CRUD->call(request()->fn, request()->ops);
	}

	public function getLoteslaboresproductor($lote, $semana_id)
	 {
		$Loteslaboresproductor = LotesLaboresProductor::where('lote_id', $lote)
		->where('semana_id', '=', $semana_id)->get();
		return $Loteslaboresproductor;
	 } 
	/*public function postObtener()
	 {
		 $LoteLabores = LoteLabores::All(); 
		 return $LoteLabores;
	 } 

	 //INICIO DEV ANGELICA
	 public function getLotelaborsemana($loteid, $lineaproductivaid, $numsemana)
	 {
		//var_dump($loteid); die(); 
		$result = array();
		$L = LotesLabores::join('labores','lotes_labores.labor_id', '=', 'labores.id')
		->select('lotes_labores.labor_id', 'lotes_labores.labor', 'lotes_labores.inicio', 'lotes_labores.frecuencia', 'labores.labor AS otraLabor', 'lotes_labores.margen')
		->where('labores.linea_productiva_id', $lineaproductivaid)
		->where('lote_id', $loteid)->get();

		// return $q->leftJoin('perfiles_secciones', 'id', '=', 'seccion_id');

		foreach($L as $lotelabor){
			$encontrado = false;
			if($numsemana - $lotelabor->inicio >= 0){
				if(($numsemana - $lotelabor->inicio) % $lotelabor->frecuencia==0){
					$lotelabor->delta=0;  //Hace variable delta referencia a la margen
					$encontrado = true;
				}else{
					if($lotelabor->margen!=0){
						for($i = $lotelabor->margen; $i >= $lotelabor->margen*-1; $i--){
							if($i!=0 && (($numsemana + $i) - $lotelabor->inicio >= 0)){
								if((($numsemana + $i) - $lotelabor->inicio) % $lotelabor->frecuencia==0){
									$lotelabor->delta = $i >0?-1:1; //Hace variable delta referencia a la margen
									$encontrado = true;
								}
							}
						}
					}
				}
			}
			if ($encontrado){
				//Se trae un registro de la tabla labores donde lote sea el que ingresa por parametro y la labor sea la labor seleccionada
				$lr = LoteLaboresRealizadas::where('lote_id', $loteid)->where('labor_id', $lotelabor->labor_id)->exists();
				$lotelabor->encontrado=$lr;
				array_push($result, $lotelabor);				
			}

		}
		return $result;
	 }*/
	 //FIN DEV ANGELICA
}
