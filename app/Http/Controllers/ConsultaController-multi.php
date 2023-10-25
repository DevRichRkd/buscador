<?php

namespace App\Http\Controllers;

use Lang;
use Auth;
use Storage;
use App\Tema;
use App\Sector;
use App\Consulta;
use App\Ejercicio;
use App\Http\Requests;
use App\ConsultaSector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultaController extends Controller{
    
    public function __construct(){
        $this->middleware('auth');
        $this->cadenaBuscada = "consultas";
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
                                                        sectores.nombre as sector 
                                                        FROM 
                                                            consultas
                                                        LEFT JOIN sectores ON sectores.id = consultas.sector_id ");*/

        $consultas =  DB::table('consultas')
                    ->select(
                            'consultas.*',
                            'sectores.nombre as sector',
                            'temas.nombre as tema',
                            'ejercicios.nombre as ejercicio'
                        )
                    ->Join(
                        "consulta_sector",
                        'consultas.id',
                        '=',
                        'consulta_sector.id_consulta')

                    ->Join(
                        "sectores",
                        'consulta_sector.id_sector',
                        '=',
                        'sectores.id')
                    
                    ->Join(
                        "temas",
                        'consultas.tema',
                        '=',
                        'temas.id')
                    ->Join(
                        "ejercicios",
                        'consultas.ejercicio',
                        '=',
                        'ejercicios.id')
                    ->orderBy('consultas.id', 'Desc')
                    ->paginate(25);

        return view('consultas/listar')->with([
                                                'consultas' => $consultas,
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

        $sectores   = DB::table('sectores')->where('estatus',1)->get();
        $ejercicios = DB::table('ejercicios')->where('estatus',1)->get();
        $temas      = DB::table('temas')->where('estatus',1)->get();

        return view('consultas/registrar')->with([
                                                'perm'     => $perm[0],
                                                'sectores' => $sectores,
                                                'ejercicios' => $ejercicios,
                                                'temas' => $temas,
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
            'sector'   => 'required|not_in:0',
            'numero_consulta'   => 'required|unique:consultas',
            'tema'   => 'required|',
            'descripcion'   => 'required',
            'palabras'   => 'required',
            'ejercicio'   => 'required|not_in:0',
            'word'   => 'required|file|mimes:docx,doc',
            'pdf'   => 'required|file|mimes:pdf',
        ]);
        
        $estatus = NULL;
        $mensaje = NULL;

         /*Guardamos Imagen*/
        $file = $request->file('word');
        $word = time().$_FILES["word"]["name"];
        Storage::disk("documentos")->put($word, file_get_contents($file->getRealPath()));

        $file = $request->file('pdf');
        $pdf = time().$_FILES["pdf"]["name"];
        Storage::disk("documentos")->put($pdf, file_get_contents($file->getRealPath()));

        $estatus = ($request['estatus']) ? '1' : '0';
        $consultas = new Consulta;
        //$consultas->sector_id = $request['sector'];
        $consultas->numero_consulta = $request['numero_consulta'];
        $consultas->tema = $request['tema'];
        $consultas->descripcion = $request['descripcion'];
        $consultas->palabras_clave = $request['palabras'];
        $consultas->ejercicio = $request['ejercicio'];
        $consultas->word = $word;
        $consultas->pdf = $pdf;

        $consultas->estatus     = $estatus;

        if ($consultas->save()) {

            //foreach ($request['sector'] as $key => $value) {
                ConsultaSector::create([
                    'id_sector'          => $value,
                    'id_consulta'         => $consultas->id
                ]);
            //}
            

            return redirect('/consultas')->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.exito'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess')
            ]);
        }else{
            return redirect('/consultas')->with([
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

        $consultas = Consulta::findOrFail($id);

        $sectores   = DB::table('sectores')->where('estatus',1)->get();
        $ejercicios = DB::table('ejercicios')->where('estatus',1)->get();
        $temas      = DB::table('temas')->where('estatus',1)->get();
        $sectorSelected = DB::table('consulta_sector')
                            ->where('id_consulta',$id)
                            ->Join(
                                    "sectores",
                                    'consulta_sector.id_sector',
                                    '=',
                                    'sectores.id')
                            ->get();
        $array = [];
        foreach($sectorSelected as $sector => $key){
            $array[$sector] = $key->id_sector;
        }

        $sectores   = DB::table('sectores')
                        ->whereNotIn('id', $array)
                        ->get();

        return view('consultas/modificar')->with([
                                                'perm'     => $perm[0],
                                                'consultas' => $consultas,
                                                'sectores' => $sectores,
                                                'ejercicios' => $ejercicios,
                                                'temas' => $temas,
                                                'sectorSelected' => $sectorSelected,
                                                ]);
    }

    public function update(Request $request, Consulta $consulta){
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
            'sector'   => 'required|not_in:0',
            'numero_consulta'   => 'required|unique:consultas,numero_consulta,'.$consulta->id,
            'tema'   => 'required',
            'descripcion'   => 'required',
            'palabras'   => 'required',
            'ejercicio'   => 'required|not_in:0',
            'word'   => 'file|mimes:docx,doc',
            'pdf'   => 'file|mimes:pdf',
        ]);

        $estatus = ($request['estatus']) ? '1' : '0';
        //$consultas = Consulta::findOrFail($id);

         /*Guardamos Imagen*/
        if($request->has('word')){
            $file = $request->file('word');
            $word = time().$_FILES["word"]["name"];
            Storage::disk("documentos")->put($word, file_get_contents($file->getRealPath()));
            $consulta->word = $word;
        }

        if($request->has('word')){
            $file = $request->file('pdf');
            $pdf = time().$_FILES["pdf"]["name"];
            Storage::disk("documentos")->put($pdf, file_get_contents($file->getRealPath()));
            $consulta->pdf = $pdf;
        }   

        $estatus = ($request['estatus']) ? '1' : '0';
        //$consulta->sector_id = $request['sector'];
        $consulta->numero_consulta = $request['numero_consulta'];
        $consulta->tema = $request['tema'];
        $consulta->descripcion = $request['descripcion'];
        $consulta->palabras_clave = $request['palabras'];
        $consulta->ejercicio = $request['ejercicio'];
        $consulta->estatus     = $estatus;

        if ($consulta->save()) {

            ConsultaSector::where('id_consulta',$consulta->id)->delete();
            foreach ($request['sector'] as $key => $value) {
                ConsultaSector::create([
                    'id_sector'          => $value,
                    'id_consulta'         => $consulta->id
                ]);
            }


            return redirect('/consultas')->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.exito'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess'),
            ]);
        }else{
            return redirect('/consultas')->with([
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
            return redirect('/consultas')->with([
                'titulo'  => Lang::get('messages.mensajeTransaccion.error'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.danger'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconDanger'),
                'msj'   => Lang::get('messages.errorPermisos'),
            ]);
        }

        $existe = $this->existenDependientes('id_consultas',$id);
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
            Consulta::destroy($id);
            ConsultaSector::where('id_consulta',$consulta->id)->delete();
            return redirect()->back()->with([
               'titulo'  => Lang::get('messages.mensajeTransaccion.exito'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess'),
            ]);
        }
    }
}
