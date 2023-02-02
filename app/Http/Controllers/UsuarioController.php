<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\UsuarioOrganizacion;
use App\Functions\CRUD;
use App\Functions\Helper;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Support\Facades\Crypt;
use Hash;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelExcel;

use App\Exports\UsuariosExportar;
use App\Imports\UsuariosImportar;

class UsuarioController extends Controller
{
    public function postUsuarios()
    {
        $CRUD = new CRUD('App\Models\Usuario');
        return $CRUD->call(request()->fn, request()->ops);
    }

    public function postUsuariosOrganizacion(){
        // $usuario = Usuario::join('usuario_organizacion', 'usuarios.id', '=', 'usuario_organizacion.usuario_id')->where('usuario_organizacion.organizacion_id', 1)->get();
        // return $usuario;
    }

    public function postLogin()
    {
    	$Credenciales = request('Credenciales');
        $claveSesion = $Credenciales['Password'];
        $usuarioSesion = $Credenciales['Correo'];
    	$Usuario = Usuario::Where('documento', $usuarioSesion)
            ->first();
            
        //where('correo', $usuarioSesion)->or
        //$dato = Crypt::encrypt($Usuario['contrasena']);
        // $dato = $Usuario['contrasena'];

    	if ( $Usuario ) {
            //return Crypt::encrypt($Usuario->id);
            if ( Hash::check($claveSesion, $Usuario->contrasena)) {
                return ['token' => Crypt::encrypt($Usuario->id), 'perfil_id' => $Usuario->perfil_id];
            } else {
                return response()->json(['Msg' => 'Error en la contraseña registrada'], 500);
            }
    	} else {
    		return response()->json(['Msg' => 'Error en el usuario registrado'], 500);
    	}
    }
 
    public function postRevisarToken()
    {
        $token = request('token');
        if(!$token) return response()->json(['Msg' => 'Usuario no autorizado'], 412);

        $id = Crypt::decrypt($token);
        $Usuario = Usuario::where('id', $id)->with([ 'fincas', 'organizaciones' ])->first();

        return $Usuario;
    }
    
    // Medoto para la actualizacion solo de la clave del usuario.
    public function postActualizarClave()
    {
        $usuario_id = request('usuario_id');
        $contrasena = request('contrasena');
        $usuario = Usuario::where('id', $usuario_id)->first();
        $usuario->contrasena = Hash::make(trim($contrasena));
        $usuario->save();
    }

    public function postActualizarClaveUsuario()
    {
        $claveAnterior = request('claveAnterior');
        $claveNueva = request('claveNueva');

        $usuario = Helper::getUsuario();

        //Validamos si la clave es correacta
        if(Hash::check($claveAnterior, $usuario->contrasena)){
            //CAmbiamos la clave
            $usuario->contrasena = Hash::make($claveNueva);
            $usuario->save();
        }else{
            return response()->json(['Msg' => 'Error en la contraseña registrada'], 500);
        }
    }

    // Metodo para buscar en todos los usuarios del sistema (Solo administradores)
    public function postBuscarUsuario()
    {
        $query = request('query');
        return Usuario::where('nombres',   'LIKE', "%$query%")
                    ->orWhere('apellidos', 'LIKE', "%$query%")
                    ->orWhere('documento',    'LIKE', "$query%")
                    ->with(['fincas'])
                    ->get();
    }

    // Metodo para buscar en todos los usuarios que pertececen a una organizacion
    public function postBuscarUsuarioOrganizacion()
    {
        $organizacion = request('organizacion');
        return Usuario
            ::join('usuario_organizacion', 'usuarios.id', '=', 'usuario_organizacion.usuario_id')
            ->where("usuario_organizacion.organizacion_id", $organizacion)
            ->where(
                function($sentencia){
                    $query = request('query');
                    $sentencia->orWhere('apellidos', 'LIKE', "%$query%");
                    $sentencia->orWhere('nombres',   'LIKE', "%$query%");
                    $sentencia->orWhere('documento',    'LIKE', "$query%");
                }
            )
            ->get();
    }

    // Medoto para la actualizacion de cualquier campo de la tabla del usuario. // Luigi
    public function postActualizarcampo()
    {
        extract(request()->all());
        $usuario = Usuario::where('id', $usuarioid)->first();
        $usuario->$campo = $valor;
        $usuario->save();
    }

    //Método para la actualización del estado del usuario
    public function postActualizarEstadoUsuario()
    {
        $usuario_id = request('usuario_id');
        $estado = request('estado');
        $usuario = Usuario::where('id', $usuario_id)->first();
        $usuario->asociado_activo = $estado;
        $usuario->save();
    }

    //Metodo para generar una clave
    //http://127.0.0.1:8000/api/usuario/generar-clave/12345
    public function getGenerarClave($texto){
        return Hash::make($texto);
    }

    public function postActualizarorganizacion()
    {
        $usuario = request('usuario');
        $organizacion = request('organizacion');
        $usuario = Usuario::where('id', $usuario)->first();
        $usuario->organizacion_id = $organizacion;
        $usuario->save();
    }

    public function postQuitarorganizacion()
    {
        $usuario = request('usuario');
        $usuario = Usuario::where('id', $usuario)->first();
        $usuario->organizacion_id = NULL;
        $usuario->save();
    }

    public function exportXLSX($id){
        return Excel::download(new UsuariosExportar($id), 'lista-usuarios.xlsx');
    }

    public function postImportarTest(Request $request)
    {
        
        if($request->has("organizacion_id")){
            //echo "Organizacion:".$request->input("organizacion_id")."<br/>";
        }
        if($request->hasFile("archivo")){
            //$file = $request->file("archivo");
            $lista_usuarios = array();

            $rows = Excel::ToArray(new UsuariosImportar, $request->file('archivo'),ExcelExcel::XLSX);
            //print_r($rows);
            foreach($rows[0] as $usuario){
                $usuario["existe"] = $this->existeUsuarioOrganizacion($usuario["documento"],$request->input("organizacion_id"));
                $lista_usuarios[] = $usuario;
            }

            return json_encode($lista_usuarios);
        }else{
            echo "no hay archivo<br/>";
        }
    }

    public function existeUsuarioOrganizacion($identificacion, $organizacion_id)
    {

    	$usuario = Usuario::join('usuario_organizacion','usuarios.id','=','usuario_organizacion.usuario_id')
                        ->Where('usuarios.documento', $identificacion)
                        ->Where('usuario_organizacion.organizacion_id',$organizacion_id)
                        ->first();

        return $usuario ? true : false;
    }

}
