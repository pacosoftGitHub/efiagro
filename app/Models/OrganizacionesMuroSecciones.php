<?php
//INICIO DEV ANGÉLICA 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizacionesMuroSecciones extends Model
{
    use HasFactory;

    protected $table = 'organizaciones_muro_secciones';
    protected $guarded = ['id'];
    protected $appends = [];
    protected $casts = [
        'organizacion_id' => 'integer',
        'usuario_id' => 'integer'
         ];
    public function columns()
    { 
        //      Name,       Desc,       Type,   Required, Unique, Default, Width, Options
        // [ 'organizaciones_muro_id', 'organizaciones_muro_id',   null,   true,  false, null, 100 ],
        return [
            [ 'organizacion_id',  	    'organizacion_id',          null,   false, false, null, 100 ],
            [ 'url',  	                'url',                      null,   false, false, null, 100 ],
            [ 'contenido',              'contenido',      null,   true,  false, null, 100 ],
            [ 'ruta',                   'ruta',      null,   true,  false, null, 100 ],
            [ 'ext',                   'ext',      null,   true,  false, null, 100 ],
            ['estado',                  'Estado',      null, true, false, null, 100],
            ['usuario_id',              'Usuario',   null, true, false, null, 100],
        ];
    }

    public function Organizacionesmuro()
    {
    	return $this->belongsTo('App\Models\OrganizacionesMuro', 'organizaciones_muro_id', 'id');
    }
    

    public function scopeElorganizacion($q, $organizacion_id)
    {
    	return $q->where('organizacion_id', $organizacion_id);
    }

    public function organizacion()
    {
        return $this->belongsTo('App\Models\Organizacion', 'organizaciones_id', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario', 'usuario_id', 'id');
    }

    /*
    public static function boot()
    {
        parent::boot();

        self::saving(function($model){
            if(!is_string($model->attributes['novedad']) AND !is_null($model->attributes['novedad'])) 
                $model->attributes['novedad'] = json_encode($model->attributes['novedad']);
        });
    }

    public function getNovedadAttribute($novedad)
    {
        if($this->tipo == 'Tabla') return json_decode($novedad);
        return $novedad;
    }

    public function autor()
    {
        return $this->belongsTo('App\Models\Usuario', 'usuario_id', 'id');
    }
*/
    //FIN DEV ANGÉLICA

}

