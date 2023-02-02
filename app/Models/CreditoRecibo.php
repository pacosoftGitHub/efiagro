<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreditoRecibo extends Model
{
    use HasFactory;
    use SoftDeletes;
 
    protected $table = 'credito__recibos';
    protected $guarded = [];
    protected $appends = [ 'fecha', 'dia', 'user' ];

    public function columns()
    {
        //Name, Desc, Type, Required, Unique, Default, Width, Options
        return [
			[ 'credito_id', 	    null, true, false, null, 100 ],
			[ 'user_id', 		    null, true, false, null, 100 ],
			[ 'medio', 		        null, true, false, null, 100 ],
			[ 'no_consignacion',    null, true, false, null, 100 ],
			[ 'valor_recibido', 	null, true, false, null, 100 ],
			[ 'valor', 		        null, true, false, null, 100 ],
			[ 'valor_devuelto', 	null, true, false, null, 100 ],
        ];
    }

    public function getFechaAttribute()
    {
    	return $this->created_at->format('Y-m-d h:ia');
    }

    public function getDiaAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }

    public function getUserAttribute()
    {
        return $this->hasOne('App\Models\Usuario', 'id', 'user_id')->first();
    }

    public function getAbonos()
    {
    	$Abonos = $this->hasMany('App\Models\CreditoAbono', 'recibo_id', 'id')->get();
    	foreach ($Abonos as $Abono) {
    		$Abono->getSaldo();
    		$Abono->getColor();
    	}
    	$this->abonos = $Abonos;
    }

}
