<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoteCosechas extends Model
{
    use HasFactory;
    protected $table = 'lotes_cosechas';
    protected $guarded = ['id'];
    protected $appends = [];
    protected $casts = [
        'lote_id' => 'integer',
         ];
    
    public function columns()
    {    
        

        //Name,                 Desc,               Type,    Required,  Unique, Default,     Width, Options
        return [
            ['lote_id',         'Lotes',           null,       true,     false,  null,       100],
            ['cantidad',        'Cantidades',      null,       true,     false,  null,       100],
            ['kilogramo',       'Kilogramos',      null,       true,     false,  null,       100],
            ['tipo',            'Tipos',           'select',       true,     false,  null,   100], 
            ['fecha',           'Fechas',          null,       true,     false,  null,       100]
        ]; 

    }
    public function scopeId($q, $id) {
        return $q->where('id', $id);
    }

    public function labor() {
        return $this->belongsTo('App\Models\Labor', 'labor_id');
    }

    public function lote() {
        return $this->belongsTo('App\Models\Lote', 'lote_id');
    }
}
