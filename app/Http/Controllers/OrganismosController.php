<?php

namespace App\Http\Controllers;

use Lang;
use Auth;
use App\Organismos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrganismosController extends Controller{
    private string $cadenaBuscada;
    public function __construct(){
        $this->middleware('auth');
        $this->cadenaBuscada = "organismos";
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

        $organismos =  DB::table('organismos')
                    ->select(
                            'organismos.*',
                            'entidades.nombre as entidad',
                        )
                    ->Join(
                        "entidades",
                        'organismos.id_entidad',
                        '=',
                        'entidades.id')
                    ->orderBy('organismos.id', 'Asc')
                    ->paginate(25);

        return view('organismos/listar')->with([
                                                'organismos' => $organismos,
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

        
        $entidades       = DB::table('entidades')->where('estatus',1)->get();

        return view('organismos/registrar')->with([
                                                'perm'     => $perm[0],
                                                'entidades' => $entidades,
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
            'entidad'   => 'required|not_in:0',
            'nombre'   => 'required|unique:organismos',
        ]);
        
        $estatus = NULL;
        $mensaje = NULL;

        $estatus = ($request['estatus']) ? '1' : '0';
        $organismos = new Organismos;
        $organismos->id_entidad = $request['entidad'];
        $organismos->nombre = $request['nombre'];
        $organismos->estatus     = $estatus;

        if ($organismos->save()) {
            return redirect('/organismos')->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.exito'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess')
            ]);
        }else{
            return redirect('/organismos')->with([
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

        $organismos = Organismos::findOrFail($id);

        $entidades      = DB::table('entidades')->where('estatus',1)->get();

        return view('organismos/modificar')->with([
                                                'perm'     => $perm[0],
                                                'organismos' => $organismos,
                                                'entidades' => $entidades,
                                                ]);
    }

    public function update(Request $request, Organismos $organismo){
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
            'entidad'   => 'required|not_in:0',
            'nombre'   => 'required|unique:organismos,nombre,'.$organismo->id,
        ]);

        $estatus = ($request['estatus']) ? '1' : '0';

        $organismo->id_entidad = $request['entidad'];
        $organismo->nombre = $request['nombre'];
        $organismo->estatus     = $estatus;

        if ($organismo->save()) {

            return redirect('/organismos')->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.exito'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess'),
            ]);
        }else{
            return redirect('/organismos')->with([
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
            return redirect('/organismos')->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.error'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.danger'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconDanger'),
                'msj'   => Lang::get('messages.errorPermisos'),
            ]);
        }

        $existe = $this->existenDependientes('id_organismos',$id);
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
            $organismo = Organismos::findOrFail($id);
            Organismos::destroy($id);
            return redirect()->back()->with([
               'titulo'  => Lang::get('messages.mensajeTransaccion.exito'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess'),
            ]);
        }
    }

    public function getOrganismosByIdEntidad($id)
    {
        # Validamos que el usuario logueado este activo. En caso el usuario no este activo se manda al home
        if (!Auth::guest()){
            if(Auth::user()->estatus != 1){
                return redirect('/home');
            }
        }
        # Fin de validación usuario activo
        $organismo = Organismos::where('id_entidad','=',$id)->get();
       
        return $organismo;

    }
}
