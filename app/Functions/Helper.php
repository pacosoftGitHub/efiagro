<?php 

namespace App\Functions;
use Carbon\Carbon;
use Crypt;

class Helper
{
	public static function getElm($Collection, $Value, $Key = 'id')
    {
        return collect($Collection)->filter(function ($elm) use ($Key, $Value){
            return $elm[$Key] == $Value;
        })->first();
    }

    public static function getUsuario($with = [])
    {
        $token = request()->header('token');
        if(!$token) abort(412);
        $id = Crypt::decrypt($token);

        return $Usuario = \App\Models\Usuario::where('id', $id)->with($with)->first();
    }

    public static function getUsuarioId()
    {
    	$Usuario = self::getUsuario();
        return $Usuario->id;
    }

    public static function prepOpcion($Tipo, $Valor)
    {
        if($Tipo == 'Numero')  return intval($Valor);
        if($Tipo == 'Boolean') return boolval($Valor);
        if($Tipo == 'Lista')   return json_decode($Valor);
        if($Tipo == 'Decimal') return floatval($Valor);

        return $Valor;
    }

    public static function getOpciones($just_values = false)
    {
        //Obtener los valores por defecto
        $Opciones = \App\Models\Opcion::where('organizacion_id', 1)->get()->keyBy('opcion')->transform(function($Op){
            $Op->valor = self::prepOpcion($Op->tipo, $Op->valor);
            return $Op;
        });

        //Obtener valores específicos
        $Usuario = self::getUsuario();
        if($Usuario->organizacion_id !== 1){
            $OpcionesEsp = \App\Models\Opcion::where('organizacion_id', $Usuario->organizacion_id)->get()->keyBy('opcion')->transform(function($Op){
                $Op->valor = self::prepOpcion($Op->tipo, $Op->valor);
                return $Op;
            });

            foreach ($OpcionesEsp as $k => $Op) {
                $Opciones[$k] = $Op;
            }
        }

        if($just_values) {
            $Opciones->transform(function($Op){
                return $Op['valor'];
            });
        }

        return $Opciones;
    }

    public static function getOpcionesOrganizacion($organizacion_id = 1)
    {
        //Obtener los valores por defecto
        $Opciones = \App\Models\Opcion::where(function($query) use ($organizacion_id){
            $query->where('organizacion_id', $organizacion_id)
                ->orWhere('organizacion_id',0);
            })
            ->get()->keyBy('opcion')->transform(function($Op){
            $Op->valor = self::prepOpcion($Op->tipo, $Op->valor);
            return $Op;
        });
        
        $Opciones->transform(function($Op){
            return $Op['valor'];
        });

        return json_encode($Opciones);
    }

    public static function generateDateRangeArr(Carbon $start_date, Carbon $end_date, $format = 'd/m/Y', $value = 0)
    {
        $dates = [];
        for($date = $start_date->copy(); $date->lte($end_date); $date->addDay()) {
            $dates[$date->format($format)] = $value;
        }
        return $dates;
    }

    public static function keyValueToArr($Arr)
    {
        $New = [];
        foreach ($Arr as $k => $v) {
            $New[] = [$k, $v];
        }
        return $New;
    }

}