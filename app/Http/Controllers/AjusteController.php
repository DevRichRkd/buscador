<?php

namespace App\Http\Controllers;

use Lang;
use Auth;
use Storage;
use App\Ajuste;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjusteController extends Controller{
    
    public function __construct(){
        $this->middleware('auth');
        $this->cadenaBuscada = "ajustes";
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

        $ajustes = Ajuste::findOrFail($id);

        return view('ajustes/modificar')->with([
                                                    "ajustes" => $ajustes,
                                                    "perm"     => $perm[0]
                                                ]);
    }

    public function update(Request $request, Ajuste $ajuste){
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

        /*$this->validate($request, [
                'descripcion' => 'required|min:5|max:120'
            ]);*/

        /*Guardamos Imagen*/
        if($request->has('imagenUno')){
            Storage::disk('imagenes')->delete($ajuste->logo_uno);
            $file = $request->file('imagenUno');
            $imagenUno = str_replace(" ", "-", time().$_FILES["imagenUno"]["name"]);
            Storage::disk("imagenes")->put($imagenUno, file_get_contents($file->getRealPath()));
            $ajuste->logo_uno = $imagenUno;
        }

        if($request->has('imagenDos')){
            Storage::disk('imagenes')->delete($ajuste->logo_dos);
            $file = $request->file('imagenDos');
            $imagenDos =  str_replace(" ", "-", time().$_FILES["imagenDos"]["name"]);
            Storage::disk("imagenes")->put($imagenDos, file_get_contents($file->getRealPath()));
            $ajuste->logo_dos = $imagenDos;
        }

        if($request->has('imagenTres')){
            Storage::disk('imagenes')->delete($ajuste->logo_tres);
            $file = $request->file('imagenTres');
            $imagenTres =  str_replace(" ", "-", time().$_FILES["imagenTres"]["name"]);
            Storage::disk("imagenes")->put($imagenTres, file_get_contents($file->getRealPath()));
            $ajuste->logo_tres = $imagenTres;
        }

        if($request->has('imagenCuatro')){
            Storage::disk('imagenes')->delete($ajuste->logo_cuatro);
            $file = $request->file('imagenCuatro');
            $imagenCuatro =  str_replace(" ", "-", time().$_FILES["imagenCuatro"]["name"]);
            Storage::disk("imagenes")->put($imagenCuatro, file_get_contents($file->getRealPath()));
            $ajuste->logo_cuatro = $imagenCuatro;
        }

        //$ajuste = Ajuste::findOrFail($id);
       
        $ajuste->boton_uno = $request['boton_uno'];
        $ajuste->link_uno = $request['link_uno'];
        $ajuste->boton_dos = $request['boton_dos'];
        $ajuste->link_dos = $request['link_dos'];
        $ajuste->texto = $request['descripcion'];
        $ajuste->direccion = $request['direccion'];
        $ajuste->facebook = $request['facebook'];
        $ajuste->twitter = $request['twitter'];
        $ajuste->instagram = $request['instagram'];
        $ajuste->youtube = $request['youtube'];
        $ajuste->derechos = $request['derechos'];

        if ($ajuste->save()) {
            return redirect('/home')->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.exito'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess'),
            ]);
        }else{
            return redirect('/home')->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.error'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.danger'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconDanger'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjDanger'),
            ]);
        }
    }

}
