<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Functions\Helper;

class CreditoSaldo extends Model
{
    use HasFactory;

    protected $table = 'credito__saldos';
    protected $guarded = [];
    protected $appends = [
        'date', 
        'due', 
        'abonos', 
        'abonado', 
        'abonadomora',
        'interes_causado',
        'pendiente',
    ];
    protected $dates = ['created_at', 'updated_at', 'fecha'];

    public function columns()
    {
        //Name, Desc, Type, Required, Unique, Default, Width, Options
        return [
			[ 'credito_id', 	null, true, false, null, 100 ],
			[ 'activo', 		null, true, false, null, 100 ],
			[ 'tipo', 			null, true, false, null, 100 ],
			[ 'num_pago', 		null, true, false, null, 100 ],
			[ 'fecha', 			null, true, false, null, 100 ],
			[ 'capital', 		null, true, false, null, 100 ],
			[ 'interes', 		null, true, false, null, 100 ],
			[ 'total', 			null, true, false, null, 100 ],
			[ 'deuda', 			null, true, false, null, 100 ],
        ];
    }

    public function credito()
    {
        return $this->belongsTo('App\Models\Credito', 'credito_id');
    }

    public function getDateAttribute()
    {
        return $this->fecha->format('Y-m-d');
    }

	public function getDueAttribute()
	{
		return $this->fecha->lt(Carbon::now());
		//return $this->fecha->lt("2021-06-10");
	}

    public function getAbonosAttribute()
    {
        return $this->hasMany('App\Models\CreditoAbono', 'saldo_id', 'id')->get();
    }

    public function getAbonadoAttribute()
    {
        return $this->abonos->sum(function ($Abono) {
            return ( $Abono['paga'] == 'Cuota' ) ? $Abono['valor'] : 0;
        });
    }

    public function getAbonadomoraAttribute()
    {
        return $this->abonos->sum(function ($Abono) {
            return ( $Abono['paga'] == 'Mora' ) ? $Abono['valor'] : 0;
        });
    }

    public function CalcMora()
    {
        $this->mora = 0;
        if(!$this->due OR $this->pendiente == 0){ return false; }

        $this->dias_mora = $Dias = $this->fecha->diffInDays(Carbon::today());
        //$this->dias_mora = $Dias = $this->fecha->diffInDays("2021-06-10");
        
        $Opciones = Helper::getOpciones(true);

        $Interes;

             if($Dias <= 30)                { $Interes = $Opciones['CREDITO_MORA_MENOS_30'] / 100; }
        else if($Dias >= 31 && $Dias <=  60){ $Interes = $Opciones['CREDITO_MORA_31_60'] / 100;   }
        else if($Dias >= 61 && $Dias <=  90){ $Interes = $Opciones['CREDITO_MORA_61_90'] / 100;   }
        else if($Dias >= 91 && $Dias <= 120){ $Interes = $Opciones['CREDITO_MORA_91_120'] / 100;  }
                       else if($Dias >= 121){ $Interes = $Opciones['CREDITO_MORA_MAS_120'] / 100;  }

        $ValMora = CEIL($this->pendiente * $Interes);  

        $this->mora = $ValMora - $this->abonadomora;
        if($this->mora < 0){ $this->mora = 0; }
    }

    public function getPendienteAttribute()
    {
        return $this->capital + $this->interes_causado - $this->abonado;
    }

    public function CalcEstado()
    {
        $Estado = 'Pendiente';

        if($this->pendiente == 0){
            $Estado = 'Pagado';
        }else{
            if($this->due){ //si ya debió haber pagado
                $Estado = 'Mora';
            }

            if($this->abonado > 0){
                $Estado .= ' Pago Parcial';
            }
        }

        $this->estado = trim($Estado);

        //Agregar colores
        $Colors = [
            'Pendiente' => '#a2a2a2',
            'Pendiente Pago Parcial' => '#008E7D',
            'Pagado'    => '#00695c',
            'Mora'      => '#ce0202',
            'Mora Pago Parcial' => '#D32F2F',
        ];

        $this->estado_color = $Colors[$this->estado];

    }

    public function getInteresCausadoAttribute()
    {
        if($this->due) return $this->interes;

        $FechaCredito = $this->credito->fecha;
        if(!$FechaCredito) $FechaCredito = $this->credito->created_at;

        $DiasCuota = $FechaCredito->diffInDays($this->fecha);
        $DiasAHoy  = $FechaCredito->diffInDays(Carbon::today());
        //$DiasAHoy  = $FechaCredito->diffInDays("2021-06-10");
        $PorcCausa = $DiasAHoy / $DiasCuota;

        return ceil($this->interes * $PorcCausa);
    }

}