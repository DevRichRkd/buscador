<?php

namespace App\Http\Controllers;

use Lang;
use Auth;
use Storage;
use App\Secciones;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeccionesController extends Controller{
    
    public function __construct(){
        $this->middleware('auth');
        $this->cadenaBuscada = "secciones";
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

        $secciones =  DB::connection('mysql')->select("SELECT * FROM criterios_secciones");
        return view('secciones/listar')->with([
                                                'secciones' => $secciones,
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

        return view('secciones/registrar')->with([
                                                'perm'     => $perm[0],
                                                ]);
    }

    public function store(Request $request){
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
            'nombre'      => 'required|unique:criterios_secciones|max:1500',
        ]);
        
        $estatus = NULL;
        $mensaje = NULL;

         /*Guardamos Imagen*/
        /*$file = $request->file('imagenUno');
        $imagenUno = time().str_replace(" ","-",$_FILES["imagenUno"]["name"]);
        Storage::disk("imagenes")->put($imagenUno, file_get_contents($file->getRealPath()));
        */
        $estatus = ($request['estatus']) ? '1' : '0';
        $secciones = new Secciones;
        $secciones->nombre      = $request['nombre'];
        $secciones->estatus     = $estatus;

        if ($secciones->save()) {
            return redirect('/secciones')->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.exito'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess')
            ]);
        }else{
            return redirect('/secciones')->with([
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

        $secciones = Secciones::findOrFail($id);

        return view('secciones/modificar')->with([
                                                    "secciones" => $secciones,
                                                    "perm"     => $perm[0]
                                                ]);
    }

    public function update(Request $request, $id){
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

        $seccion = Secciones::findOrFail($id);
        
        if ($request->nombre != $request->nombreOriginal) {
            $this->validate($request, [
                'nombre'      => 'required|max:1500|unique:criterios_secciones,nombre,'.$seccion->id,
            ]);
        }else{
            
        }

        $estatus = ($request['estatus']) ? '1' : '0';
        $seccion->nombre      = $request['nombre'];
        $seccion->estatus     = $estatus;

        if ($seccion->save()) {
            return redirect('/secciones')->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.exito'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess'),
            ]);
        }else{
            return redirect('/secciones')->with([
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
            return redirect('/secciones')->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.error'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.danger'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconDanger'),
                'msj'   => Lang::get('messages.errorPermisos'),
            ]);
        }

        $existe = $this->existenDependientes('id_secciones',$id);
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
            Secciones::destroy($id);
            return redirect()->back()->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.exito'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess'),
            ]);
        }
    }
}
