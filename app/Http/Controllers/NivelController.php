<?php

namespace App\Http\Controllers;

use Lang;
use Auth;
use Storage;
use App\Nivel;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NivelController extends Controller{
    
    public function __construct(){
        $this->middleware('auth');
        $this->cadenaBuscada = "niveles";
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

        $niveles =  DB::connection('mysql')->select("SELECT * FROM niveles");
        return view('niveles/listar')->with([
                                                'niveles' => $niveles,
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

        return view('niveles/registrar')->with([
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
            'nombre'      => 'required|unique:niveles|max:1500',
            'descripcion' => 'max:3000',
            'imagenUno'  => 'required|file|mimes:png,jpg',
        ]);
        
        $estatus = NULL;
        $mensaje = NULL;

         /*Guardamos Imagen*/
        $file = $request->file('imagenUno');
        $imagenUno = time().str_replace(" ","-",$_FILES["imagenUno"]["name"]);
        Storage::disk("imagenes")->put($imagenUno, file_get_contents($file->getRealPath()));

        $estatus = ($request['estatus']) ? '1' : '0';
        $niveles = new Nivel;
        $niveles->nombre      = $request['nombre'];
        $niveles->descripcion = $request['descripcion'];
        $niveles->estatus     = $estatus;
        $niveles->imagen_uno = $imagenUno;

        if ($niveles->save()) {
            return redirect('/niveles')->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.exito'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess')
            ]);
        }else{
            return redirect('/niveles')->with([
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

        $niveles = Nivel::findOrFail($id);

        return view('niveles/modificar')->with([
                                                    "niveles" => $niveles,
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

        $nivel = Nivel::findOrFail($id);

        /*Guardamos Imagen*/
        if($request->has('imagenUno')){
            Storage::disk('imagenes')->delete($nivel->imagen_uno);
            $file = $request->file('imagenUno');
            $imagenUno = str_replace(" ","-",time().$_FILES["imagenUno"]["name"]);
            Storage::disk("imagenes")->put($imagenUno, file_get_contents($file->getRealPath()));
            $nivel->imagen_uno = $imagenUno;
        }
        
        if ($request->nombre != $request->nombreOriginal) {
            $this->validate($request, [
                'nombre'      => 'required|max:1500|unique:niveles,nombre,'.$nivel->id,
                'descripcion' => 'max:3000'
            ]);
        }else{
             $this->validate($request, [
                'descripcion' => 'max:3000'
            ]);
        }

        $estatus = ($request['estatus']) ? '1' : '0';
        $nivel->nombre      = $request['nombre'];
        $nivel->descripcion = $request['descripcion'];
        $nivel->estatus     = $estatus;

        if ($nivel->save()) {
            return redirect('/niveles')->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.exito'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess'),
            ]);
        }else{
            return redirect('/niveles')->with([
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
            return redirect('/niveles')->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.error'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.danger'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconDanger'),
                'msj'   => Lang::get('messages.errorPermisos'),
            ]);
        }

        $existe = $this->existenDependientes('id_niveles',$id);
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
            Nivel::destroy($id);
            return redirect()->back()->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.exito'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess'),
            ]);
        }
    }
}
