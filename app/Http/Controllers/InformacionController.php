<?php

namespace App\Http\Controllers;

use Lang;
use Auth;
use App\Informacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformacionController extends Controller{
    
    public function __construct(){
        $this->middleware('auth');
        $this->cadenaBuscada = "informacion";
    }

    public function index(){
        # Validamos que el usuario logueado este activo. En caso el usuario no este activo se manda al home
        if (!Auth::guest()){
            if(Auth::user()->estatus != 1){
               return redirect('home');
            }
        }
        # Fin de validación usuario activo

        $perm[] = $this->permisos($this->cadenaBuscada,Auth::user()->id);

        /*$consultas =  DB::connection('mysql')->select("SELECT 
                                                        consultas.*,
                                                        niveles.nombre as sector 
                                                        FROM 
                                                            consultas
                                                        LEFT JOIN niveles ON niveles.id = consultas.sector_id ");*/

        $informacion =  DB::table('informacion')
                    ->select(
                            'informacion.*',
                            'expedientes.nombre as expediente',
                            'anios.nombre as anio',
                            'entidades.nombre as entidad',
                            'organismos.nombre as organismo',
                            'materias.nombre as materia',
                            'criterios.nombre as criterio',
                            'epocas.nombre as epoca',
                            'criterios_secciones.nombre as criterio_seccion'
                        )
                    ->Join(
                        "expedientes",
                        'informacion.id_expediente',
                        '=',
                        'expedientes.id')
                    ->Join(
                        "anios",
                        'informacion.id_anio',
                        '=',
                        'anios.id')
                    ->Join(
                        "entidades",
                        'informacion.id_entidad',
                        '=',
                        'entidades.id')
                    ->Join(
                        "organismos",
                        'informacion.id_organismo',
                        '=',
                        'organismos.id')
                    ->Join(
                        "materias",
                        'informacion.id_materia',
                        '=',
                        'materias.id')
                    ->Join(
                        "criterios",
                        'informacion.id_criterio',
                        '=',
                        'criterios.id')
                    ->Join(
                        "epocas",
                        'informacion.id_epoca',
                        '=',
                        'epocas.id')
                    ->Join(
                        "criterios_secciones",
                        'informacion.id_criterio_seccion',
                        '=',
                        'criterios_secciones.id')
                    ->orderBy('informacion.id', 'Desc')
                    ->paginate(25);
                    //$informacion = 'sisisisi';
        return view('informacion/listar')->with([
                                                'informacion' => $informacion,
                                                'perm'     => $perm[0],
                                            ]);
    }

    public function create(){
        # Validamos que el usuario logueado este activo. En caso el usuario no este activo se manda al home
        if (!Auth::guest()){
            if(Auth::user()->estatus != 1){
               return redirect('home');
            }
        }
        # Fin de validación usuario activo

        $perm[] = $this->permisos($this->cadenaBuscada,Auth::user()->id);

        $expedientes            = DB::table('expedientes')->where('estatus',1)->get();
        $anios                  = DB::table('anios')->where('estatus',1)->get();
        $entidades              = DB::table('entidades')->where('estatus',1)->get();
        $organismos             = DB::table('organismos')->where('estatus',1)->get();
        $materias               = DB::table('materias')->where('estatus',1)->get();
        $criterios              = DB::table('criterios')->where('estatus',1)->get();
        $epocas                 = DB::table('epocas')->where('estatus',1)->get();
        $criterios_secciones    = DB::table('criterios_secciones')->where('estatus',1)->get();

        return view('informacion/registrar')->with([
                                                'perm'     => $perm[0],
                                                'expedientes' => $expedientes,
                                                'anios' => $anios,
                                                'entidades' => $entidades,
                                                'organismos' => $organismos,
                                                'materias' => $materias,
                                                'criterios' => $criterios,
                                                'epocas' => $epocas,
                                                'criterios_secciones' => $criterios_secciones,
                                                ]);
    }

    public function store(Request $request){
        //dd($request);
        # Validamos que el usuario logueado este activo. En caso el usuario no este activo se manda al home
        if (!Auth::guest()){
            if(Auth::user()->estatus != 1){
               return redirect('home');
            }
        }
        # Fin de validación usuario activo
        
        $perm[] = $this->permisos($this->cadenaBuscada,Auth::user()->id);
        
        if($perm[0]['I'] == 0){
            return redirect(Route('home'))->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.error'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.danger'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconDanger'),
                'msj'   => Lang::get('messages.errorPermisos')
            ]);
        }
        
        $this->validate($request, [
            'expediente'   => 'required|not_in:0',
            'anio'   => 'required|not_in:0',
            'entidad'   => 'required|not_in:0',
            'organismo'   => 'required|not_in:0',
            'materia'   => 'required|not_in:0',
            'criterio'   => 'required|not_in:0',
            'epoca'   => 'required|not_in:0',
            'criterio_seccion'   => 'required|not_in:0',
            'rubro'   => 'required',
            'palabras'   => 'required',
            'clave'   => 'required|unique:informacion',
            'vinculo'   => 'required',
            'presedentes'   => 'required',
            'solicitud'   => 'required',
            'respuesta'   => 'required',
            'agravio'   => 'required',
            'relevancia'   => 'required',
        ]);
        
        $estatus = NULL;
        $mensaje = NULL;

        $estatus = ($request['estatus']) ? '1' : '0';
        $informacion = new Informacion;
        $informacion->id_expediente = $request['expediente'];
        $informacion->id_anio = $request['anio'];
        $informacion->id_entidad = $request['entidad'];
        $informacion->id_organismo = $request['organismo'];
        $informacion->id_materia = $request['materia'];
        $informacion->id_criterio = $request['criterio'];
        $informacion->id_epoca = $request['epoca'];
        $informacion->id_criterio_seccion = $request['criterio_seccion'];
        $informacion->rubro = $request['rubro'];
        $informacion->palabras_clave = $request['palabras'];
        $informacion->clave_de_control = $request['clave'];
        $informacion->vinculo = $request['vinculo'];
        $informacion->presedentes = $request['presedentes'];
        $informacion->solicitud = $request['solicitud'];
        $informacion->respuesta = $request['respuesta'];
        $informacion->agravio = $request['agravio'];
        $informacion->relevancia = $request['relevancia'];
        $informacion->estatus     = $estatus;

        if ($informacion->save()) {

            return redirect('/informacion')->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.exito'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess')
            ]);
        }else{
            return redirect('/informacion')->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.error'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.danger'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconDanger'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjDanger')
            ]);
        }
    }

    public function show($id){
    }

    public function edit($id){
        # Validamos que el usuario logueado este activo. En caso el usuario no este activo se manda al home
        if (!Auth::guest()){
            if(Auth::user()->estatus != 1){
               return redirect('home');
            }
        }
        # Fin de validación usuario activo
        $perm[] = $this->permisos($this->cadenaBuscada,Auth::user()->id);

        $informacion = Informacion::findOrFail($id);

        $expedientes            = DB::table('expedientes')->where('estatus',1)->get();
        $anios                  = DB::table('anios')->where('estatus',1)->get();
        $entidades              = DB::table('entidades')->where('estatus',1)->get();
        $organismos             = DB::table('organismos')->where('estatus',1)->get();
        $materias               = DB::table('materias')->where('estatus',1)->get();
        $criterios              = DB::table('criterios')->where('estatus',1)->get();
        $epocas                 = DB::table('epocas')->where('estatus',1)->get();
        $criterios_secciones    = DB::table('criterios_secciones')->where('estatus',1)->get();

        return view('informacion/modificar')->with([
                                                'perm'     => $perm[0],
                                                'informacion' => $informacion,
                                                'expedientes' => $expedientes,
                                                'anios' => $anios,
                                                'entidades' => $entidades,
                                                'organismos' => $organismos,
                                                'materias' => $materias,
                                                'criterios' => $criterios,
                                                'epocas' => $epocas,
                                                'criterios_secciones' => $criterios_secciones,
                                                ]);
    }

    public function update(Request $request, Informacion $info){
        
        # Validamos que el usuario logueado este activo. En caso el usuario no este activo se manda al home
        if (!Auth::guest()){
            if(Auth::user()->estatus != 1){
               return redirect('home');
            }
        }
        # Fin de validación usuario activo

        $perm[] = $this->permisos($this->cadenaBuscada,Auth::user()->id);
        if($perm[0]['U'] == 0){
            return redirect(Route('home'))->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.error'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.danger'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconDanger'),
                'msj'   => Lang::get('messages.errorPermisos')
            ]);
        }

        $this->validate($request, [
            'expediente'   => 'required|not_in:0',
            'anio'   => 'required|not_in:0',
            'entidad'   => 'required|not_in:0',
            'organismo'   => 'required|not_in:0',
            'materia'   => 'required|not_in:0',
            'criterio'   => 'required|not_in:0',
            'epoca'   => 'required|not_in:0',
            'criterio_seccion'   => 'required|not_in:0',
            'rubro'   => 'required',
            'palabras'   => 'required',
            'clave'   => 'required',
            'vinculo'   => 'required',
            'presedentes'   => 'required',
            'solicitud'   => 'required',
            'respuesta'   => 'required',
            'agravio'   => 'required',
            'relevancia'   => 'required',
        ]);

        $estatus = ($request['estatus']) ? '1' : '0';
        $info->id_expediente = $request['expediente'];
        $info->id_anio = $request['anio'];
        $info->id_entidad = $request['entidad'];
        $info->id_organismo = $request['organismo'];
        $info->id_materia = $request['materia'];
        $info->id_criterio = $request['criterio'];
        $info->id_epoca = $request['epoca'];
        $info->id_criterio_seccion = $request['criterio_seccion'];
        $info->rubro = $request['rubro'];
        $info->palabras_clave = $request['palabras'];
        $info->clave_de_control = $request['clave'];
        $info->vinculo = $request['vinculo'];
        $info->presedentes = $request['presedentes'];
        $info->solicitud = $request['solicitud'];
        $info->respuesta = $request['respuesta'];
        $info->agravio = $request['agravio'];
        $info->relevancia = $request['relevancia'];
        $info->estatus     = $estatus;

        if ($info->save()) {
        
            return redirect('/informacion')->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.exito'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess'),
            ]);
        }else{
            return redirect('/informacion')->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.error'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.danger'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconDanger'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjDanger'),
            ]);
        }
    }

    public function destroy($id){
        # Validamos que el usuario logueado este activo. En caso el usuario no este activo se manda al home
        if (!Auth::guest()){
            if(Auth::user()->estatus != 1){
               return redirect('/home');
            }
        }
        # Fin de validación usuario activo

        $perm[] = $this->permisos($this->cadenaBuscada,Auth::user()->id);
        if($perm[0]['D'] == 0){
            return redirect('/informacion')->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.error'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.danger'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconDanger'),
                'msj'   => Lang::get('messages.errorPermisos'),
            ]);
        }

        $existe = $this->existenDependientes('id_informacion',$id);
        if (count($existe) >= 1) {
            $modulos = implode(",", $existe);
            $replaced = str_replace("_", " ", $modulos);
            return redirect()->back()->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.error'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.danger'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconDanger'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjErrorBorrar').$replaced,
            ]);
        } else {
            Informacion::destroy($id);
            return redirect()->back()->with([
               'titulo'  => Lang::get('messages.mensajeTransaccion.exito'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess'),
            ]);
        }
    }
}
