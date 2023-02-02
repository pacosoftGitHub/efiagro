<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caso extends Model
{
    use HasFactory;

    protected $table = 'casos';
    protected $guarded = ['id'];
    protected $appends = [];
    protected $casts = [
        'solicitante_id' => 'integer'
         ]; 

    public function columns()
    {
        //Name, Desc, Type, Required, Unique, Default, Width, Options
        return [
            ['caso',            'Caso',        null, true, false, null, 100],
            ['titulo',          'Titulo',      null, true, false, null, 100],
            ['tipo',            'Tipo',        null, true, false, null, 100],
            ['estado',          'Estado',      null, true, false, null, 100],
            ['asignados',       'Asignados',   null, true, false, null, 100],
            ['solicitante_id',  'Solicitante', null, false, false, null, 100],
        ];
    }

    public function solicitante()
    {
        return $this->belongsTo('App\Models\Usuario', 'solicitante_id', 'id');
    }

    public function asignados()
    {
        return $this->belongsTo('App\Models\Usuario', 'asignados', 'id');
    }

    public function novedades()
    {
        return $this->hasMany('App\Models\CasoNovedad', 'caso_id');
    }
    
    //Inicio Dev Angélica
    //Filtra el tipo (sólo muestra los casos que deben aparecer en pantalla-->'Consulta General', 'Apoyo Tecnico', 'Contar Experiencia')
    public function scopeTipo($q)
    {
        return $q->whereIn('tipo', ['tipo', 'Consulta General', 'Apoyo Tecnico', 'Contar Experiencia']);
    } 

    public function scopeTipocontacto($q)
    {
        return $q->whereIn('tipo', ['Whatsapp', 'SMS', 'Llamada telefonica']);
    }
    //Fin Dev Angélica

    public function usuarios()
    {
        return $this->belongsTo('App\Models\Usuario', 'usuario_id');
    }

    public function autor()
    {
        return $this->belongsTo('App\Models\Usuario', 'usuario_id', 'id');
    }
}
