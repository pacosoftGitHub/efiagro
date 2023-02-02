<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use DB;

class CreditoAbono extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'credito__abonos';
    protected $guarded = [];

    public function columns()
    {
        //Name, Desc, Type, Required, Unique, Default, Width, Options
        return [
			[ 'credito_id', 	null, true, false, null, 100 ],
			[ 'recibo_id', 		null, true, false, null, 100 ],
			[ 'saldo_id', 		null, true, false, null, 100 ],
			[ 'paga', 		    null, true, false, null, 100 ],
			[ 'tipo', 			null, true, false, null, 100 ],
			[ 'valor', 		    null, true, false, null, 100 ],
        ];
    }

    public function getSaldo()
    {
        $this->saldo = DB::table('credito__saldos')->where('id', $this->saldo_id)->first();
    }

    //public function saldo()
    //{
    //    return $this->hasOne('App\Models\CreditoSaldo', 'id', 'saldo_id');
    //}


    public function getColor()
    {
    	$Colors = [
    		'CuotaParcial'   => '#d8f1e4',
    		'CuotaTotal'     => '#8ecead',
    		'MoraParcial'    => '#ead3d7',
    		'MoraTotal'      => '#f9ebed',
			'CapitalParcial' => '#cfe7f3',
    		'CapitalTotal'   => '#acdaf1',
    	];

    	$this->color = $Colors[$this->paga.$this->tipo];
    }
}
