<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotesLaboresProductor extends Model
{
    use HasFactory;
    protected $table = 'lotes_labores_productor';
    protected $guarded = ['id'];
    protected $appends = [];
    protected $casts = [
        'lote_id' => 'integer',
        'labor' => 'string'
         ];
    
    public function columns()
    {
        //Name, Desc, Type, Required, Unique, Default, Width, Options
        return [
            ['lote_id',         'Lotes',             null,   true,   false,  null, 50 ],
            ['labor',           'Labores',           null,   true,   false,  null, 50 ],
            ['semana_id',       'Semanas',             null,   true,   false,  null, 50 ],
        ];

    }
    public function scopeId($q, $id) {
        return $q->where('id', $id);
    }

    public function labor() {
        return $this->belongsTo('App\Models\Labor', 'labor');
    }

    public function lote() {
        return $this->belongsTo('App\Models\Lote', 'lote_id');
    }
}
