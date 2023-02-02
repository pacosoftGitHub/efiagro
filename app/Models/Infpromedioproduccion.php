<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infpromedioproduccion extends Model
{
    use HasFactory;

    protected $table = 'inf_promedio_produccion';
    protected $guarded = ['id'];
    protected $appends = [];
    protected $casts = [
        'organizacion_id' => 'integer',
    ];

    public function columns()
    {
        //Name, Desc, Type, Required, Unique, Default, Width, Options
        return [
            ['organizacion_id', 'Organización', null, true, true, null, 100],
            ['bimestre1',       'Valor',        null, true, false, null, 100],
            ['bimestre2',       'Valor',        null, true, false, null, 100],
            ['bimestre3',       'Valor',        null, true, false, null, 100],
            ['bimestre4',       'Valor',        null, true, false, null, 100],
            ['bimestre5',       'Valor',        null, true, false, null, 100],
            ['bimestre6',       'Valor',        null, true, false, null, 100]
        ];
    }

    // $this->saldo = DB::table('credito__saldos')->where('id', $this->saldo_id)->first();
    // public function scopePeriodoactual($q)
    // {
    // 	return $q->where('estado', 'A');
    // }
}
