<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
class Usuario extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'usuarios';
    protected $guarded = ['id'];
    protected $appends = [ 
        'nombre'
    ];
    protected $casts = [
        'perfil_id' => 'integer',
        'organizacion_id' => 'integer',
        'finca_id' => 'integer'
    ];

    public function columns()
    { 
        // Arreglo para la carga de Tipos de documentos.
        $tipodocumento = [
            'CC' => 'Cedula Ciudadania', 'CE' => 'Cedula Extranjeria', 'TI' => 'Tarjeta Identidad', 'PA' => 'Pasaporte', 'RC' => 'Registro Civil', 'NI' => 'NIT'
        ];
        // Obtener informacion de los perfiles, y luego almacenarlo en formato de arreglo.
        $perfiles = \App\Models\Perfil::all()->keyBy('id')->map( function($p){
            return $p['perfil'];
        })->toArray();

        // Arreglo para la carga de Géneros.
        $sexo = [
            'F' => 'FEMENINO', 'M' => 'MASCULINO', 'ND' => 'NO BINARIO'
        ];
        
        // Arreglo para la carga de Etnías.
        $etnia = [
            'Ninguna' => 'Ninguna', 'Mestizo' => 'Mestizo', 'AfroColombiano' => 'AfroColombiano', 'Indígena' => 'Indígena', 'Palenquero' => 'Palenquero', 'Raizal' => 'Raizal', 'Room' => 'Room'
        ];
        
        // Arreglo para la carga de Etnías.
        $estado = [
            1 => 'ACTIVO', 2 => 'INACTIVO', 3 => 'SUSPENSIÓN'
        ];
        
        $organizacionesusuario= \App\Models\Organizacion::all()->keyBy('id')->map( function($o){
            return $o['nombre'];
        })->toArray();
        
        //Name,         Desc,               Type,   Required, Unique, Default, Width, Options
        return [
            [ 'tipo_documento', 'Tipo Documento',   'select',   true,   false, null, 30, [ 'options' => $tipodocumento ]],
            [ 'documento',      'Documento',        null, 	    true,   false, null, 70 ],
            [ 'nombres',        'Nombres',          null, 	    true,   false, null, 100 ],
            [ 'apellidos',      'Apellidos',        null, 	    true,   false, null, 100 ],
            [ 'edad',           'Edad',             null, 	    false,   false, null, 10 ],
            [ 'sexo',           'Género',           'select',    false,   false, null, 30, [ 'options' => $sexo ]],
            [ 'etnia',          'Etnía',            'select',    false,   false, null, 50, [ 'options' => $etnia ]],
            [ 'correo',         'Correo electrónico', 'email',  false,  false,  null, 100 ],
            [ 'celular',        'Celular',          'string',   false,  false,  null, 45 ],
            [ 'direccion_residencia', 'Dirección Residencia',  'string',   false,  false,  null, 100 ],
            [ 'perfil_id',      'Perfil',           'select',   true,   false,  null, 50, ['options' => $perfiles] ],
            [ 'organizacion_id','Organización',     'select',   true,   false,  null, 50, ['options' => $organizacionesusuario] ],
            [ 'finca_id',       'Finca',            'select',   false,  false,  null, 50 ],
            ['departamento',    'Departamento:',    'select',   false,   false, null, 100, [ 'options' => [] ]],
            ['municipio',       'Municipio:',       'select',   false,   false, null, 100, [ 'options' => [] ]],
            ['vereda',          'Vereda:',          'string',   false,   false, null, 100],
            ['finca',           'Finca:',           'string',   false,   false, null, 100],
            ['latitud',         'Latitud',          null,       false,   false, null, 100],
            ['longitud',        'Longitud',         null,       false,   false, null, 100],
            [ 'asociado_activo','Estado',           'select',    false,   false, null, 50, [ 'options' => $estado ]],
        ];
    }
    
    public function scopeLaorganizacion( $q, $organizacion_id) {
        return $q->where('usuarios.organizacion_id', $organizacion_id)->Where(function($query){
            $query->where('usuarios.perfil_id',4)->orWhere('usuarios.perfil_id',2);
        });
    }

    public function scopeOrganizacionUsuario( $q, $organizacion_id) {
        return $q->join("usuario_organizacion","usuarios.id","=","usuario_organizacion.usuario_id")->where('usuario_organizacion.organizacion_id', $organizacion_id)->Where('usuarios.perfil_id',4);
    }

    //Relaciones
    public function fincas()
    {
        return $this->hasMany('App\Models\Finca', 'usuario_id');
    }

    public function organizaciones()
    {
        return $this->hasMany('App\Models\Organizacion', 'usuario_id');
    }

    public function organizaciones_usuario()
    {
        return $this->hasMany('App\Models\UsuarioOrganizacion','usuario_id');
    }
    
    public function perfil()
    {
        return $this->belongsTo('App\Models\Perfil', 'perfil_id');
    }

    public function getNombreAttribute()
    {
    	return $this->nombres .' '. $this->apellidos;
    }
    
    // Metodo para encriptar la clave del usuario.
    public static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->attributes['contrasena'] = Crypt::encryptString($model->attributes['documento']);
        });
    }

    public function departamento()
    {
        return $this->hasMany('App\Models\Departamento', 'id_departamento', 'id');
    }

}
