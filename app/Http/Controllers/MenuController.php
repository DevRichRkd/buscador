<?php

namespace App\Http\Controllers;

use Lang;
use Auth;
use App\Menu;
use App\Recurso;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller{
    
    public function __construct(){
        $this->middleware('auth');
        $this->cadenaBuscada = "menu";
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

        $menus = DB::connection('mysql')->select("SELECT * FROM menus");
        return view('menu/listar')->with(['menus' => $menus, 'perm' => $perm[0]]);
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

        $menu = Menu::where('estatus','!=','0')->get();
        $recursos = Recurso::where('estatus','!=','0')->get();
        return view('menu.registrar')->with(['menu' => $menu, 'recursos' => $recursos, 'perm' => $perm[0]]);
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
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.errorPermisos')
            ]);
        }

        $this->validate($request, [
            'nombre'  => 'required|unique:menus',
            'descripcion' => 'required|min:1|max:200'
        ]);

        $estandar = $request['page_url_estandar'];
        if (empty($request['page_url_estandar'])) {
            $estandar = '#';
        }

        $status = $request['estatus'];
        if (empty($request['estatus'])) {
            $status = 0;
        }

        $menu = new Menu;
        $menu->nombre = $request['nombre'];
        $menu->descripcion = $request['descripcion'];
        $menu->url = $estandar;
        $menu->estatus = $status;
        $menu->id_padre = $request['padre'];
        $menu->orden = $request['orderr'];
        $menu->id_recursos = $request['optrecurso'];
        $menu->icono = $request['icon'];

        if ($menu->save()) {
            return redirect('/menu')->with([
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess')
            ]);
        }else{
            return redirect('/menu')->with([
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

        $menu = Menu::where('estatus','!=','0')->get();
        $recursos = Recurso::where('estatus','!=','0')->get();
        $menuData = Menu::findOrFail($id);

        return view('menu/modificar')->with([
                                                'menu' => $menu, 
                                                'recursos' => $recursos, 
                                                'menuData' => $menuData,
                                                'perm'     => $perm[0]

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
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.errorPermisos')
            ]);
        }

        $estandar = $request['page_url_estandar'];
        if (empty($request['page_url_estandar'])) {
            $estandar = '#';
        }

        $status = $request['estatus'];
        if (empty($request['estatus'])) {
            $status = 0;
        }

        $menu = Menu::findOrFail($id);

        $menu->nombre = $request['nombre'];
        $menu->descripcion = $request['descripcion'];
        $menu->url = $estandar;
        $menu->estatus = $status;
        $menu->id_padre = $request['padre'];
        $menu->orden = $request['orderr'];
        $menu->id_recursos = $request['optrecurso'];
        $menu->icono = $request['icon'];

        if ($menu->save()) {
            return redirect('/menu')->with([
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess')
            ]);
        }else{
            return redirect('/menu')->with([
                'tipo'  => Lang::get('messages.mensajeTransaccion.danger'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconDanger'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjDanger')
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
            return redirect(Route('home'))->with([
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.errorPermisos')
            ]);
        }

        $existe = $this->existenDependientes('id_menu',$id);
        if (count($existe) >= 1) {
            $modulos = implode(",", $existe);
            $replaced = str_replace("_", " ", $modulos);
            return redirect()->back()->with([
                'tipo'  => Lang::get('messages.mensajeTransaccion.danger'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconDanger'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjErrorBorrar').$replaced,
            ]);
        } else {
            Menu::destroy($id);
            return redirect()->back()->with([
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess'),
            ]);
        }
    }
}
