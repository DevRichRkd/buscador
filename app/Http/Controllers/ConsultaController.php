<?php

namespace App\Http\Controllers;

use Lang;
use Auth;
use Storage;
use App\Consulta;
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
                                                        niveles.nombre as sector 
                                                        FROM 
                                                            consultas
                                                        LEFT JOIN niveles ON niveles.id = consultas.sector_id ");*/

        $consultas =  DB::table('consultas')
                    ->select(
                            'consultas.*',
                            'niveles.nombre as nivel',
                            'temas.nombre as tema',
                            'ejercicios.nombre as ejercicio',
                            'institucion_pertenencia.nombre as pertenencia',
                            'institucion_procedencia.nombre as procedencia',
                            'paises.nombre as pais',
                        )
                    ->Join(
                        "consulta_sector",
                        'consultas.id',
                        '=',
                        'consulta_sector.id_consulta')

                    ->Join(
                        "niveles",
                        'consulta_sector.id_sector',
                        '=',
                        'niveles.id')
                    
                    ->Join(
                        "temas",
                        'consultas.id_tema',
                        '=',
                        'temas.id')
                    ->Join(
                        "ejercicios",
                        'consultas.id_ejercicio',
                        '=',
                        'ejercicios.id')
                    ->Join(
                        "institucion_pertenencia",
                        'consultas.id_pertenencia',
                        '=',
                        'institucion_pertenencia.id')
                    ->Join(
                        "institucion_procedencia",
                        'consultas.id_procedencia',
                        '=',
                        'institucion_procedencia.id')
                    ->Join(
                        "paises",
                        'consultas.id_pais',
                        '=',
                        'paises.id')
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

        $niveles     = DB::table('niveles')->where('estatus',1)->get();
        $ejercicios  = DB::table('ejercicios')->where('estatus',1)->get();
        $temas       = DB::table('temas')->where('estatus',1)->get();
        $pertenencia = DB::table('institucion_pertenencia')->where('estatus',1)->get();
        $procedencia = DB::table('institucion_procedencia')->where('estatus',1)->get();
        $paises      = DB::table('paises')->where('estatus',1)->get();

        return view('consultas/registrar')->with([
                                                'perm'     => $perm[0],
                                                'niveles' => $niveles,
                                                'ejercicios' => $ejercicios,
                                                'temas' => $temas,
                                                'pertenencias' => $pertenencia,
                                                'procedencias' => $procedencia,
                                                'paises' => $paises,
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
            'nivel'   => 'required|not_in:0',
            'pertenencia'   => 'required|not_in:0',
            'procedencia'   => 'required|not_in:0',
            'tema'   => 'required|not_in:0',
            'pais'   => 'required|not_in:0',
            'ejercicio'   => 'required|not_in:0',
            'titulo'   => 'required|unique:consultas',
            'nombre'   => 'required',
            'descripcion'   => 'required',
            'palabras'   => 'required',
            'pdf'   => 'required|file|mimes:pdf',
        ]);
        
        $estatus = NULL;
        $mensaje = NULL;

         /*Guardamos Imagen*/
        /*$file = $request->file('word');
        $word = time().$_FILES["word"]["name"];
        Storage::disk("documentos")->put($word, file_get_contents($file->getRealPath()));*/

        $file = $request->file('pdf');
        $pdf = time().$_FILES["pdf"]["name"];
        Storage::disk("documentos")->put($pdf, file_get_contents($file->getRealPath()));

        $estatus = ($request['estatus']) ? '1' : '0';
        $consultas = new Consulta;
        //$consultas->sector_id = $request['sector'];
        $consultas->id_nivel = $request['nivel'];
        $consultas->id_pertenencia = $request['pertenencia'];
        $consultas->id_procedencia = $request['procedencia'];
        $consultas->id_tema = $request['tema'];
        $consultas->id_pais = $request['pais'];
        $consultas->id_ejercicio = $request['ejercicio'];
        $consultas->titulo = $request['titulo'];
        $consultas->autor = $request['nombre'];
        $consultas->sintesis = $request['descripcion'];
        $consultas->palabras_clave = $request['palabras'];
        $consultas->pdf = $pdf;

        $consultas->estatus     = $estatus;

        if ($consultas->save()) {

            //foreach ($request['sector'] as $key => $value) {
                ConsultaSector::create([
                    'id_sector'          => $request['nivel'],
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

        $niveles   = DB::table('niveles')->where('estatus',1)->get();
        $ejercicios = DB::table('ejercicios')->where('estatus',1)->get();
        $temas      = DB::table('temas')->where('estatus',1)->get();
        $sectorSelected = DB::table('consulta_sector')
                            ->where('id_consulta',$id)
                            ->Join(
                                    "niveles",
                                    'consulta_sector.id_sector',
                                    '=',
                                    'niveles.id')
                            ->get();
        $array = [];
        foreach($sectorSelected as $sector => $key){
            $array[$sector] = $key->id_sector;
        }

        $niveles   = DB::table('niveles')
                        ->whereNotIn('id', $array)
                        ->get();

        $pertenencia = DB::table('institucion_pertenencia')->where('estatus',1)->get();
        $procedencia = DB::table('institucion_procedencia')->where('estatus',1)->get();
        $paises      = DB::table('paises')->where('estatus',1)->get();

        return view('consultas/modificar')->with([
                                                'perm'     => $perm[0],
                                                'consultas' => $consultas,
                                                'niveles' => $niveles,
                                                'ejercicios' => $ejercicios,
                                                'temas' => $temas,
                                                'sectorSelected' => $sectorSelected,
                                                'pertenencias' => $pertenencia,
                                                'procedencias' => $procedencia,
                                                'paises' => $paises,
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
            'nivel'   => 'required|not_in:0',
            'pertenencia'   => 'required|not_in:0',
            'procedencia'   => 'required|not_in:0',
            'tema'   => 'required|not_in:0',
            'pais'   => 'required|not_in:0',
            'ejercicio'   => 'required|not_in:0',
            'titulo'   => 'required|unique:consultas,titulo,'.$consulta->id,
            'nombre'   => 'required',
            'descripcion'   => 'required',
            'palabras'   => 'required',
            'pdf'   => 'file|mimes:pdf',
        ]);

        $estatus = ($request['estatus']) ? '1' : '0';
        //$consultas = Consulta::findOrFail($id);

         /*Guardamos Imagen*/
        if($request->has('pdf')){
            Storage::disk('documentos')->delete($consulta->pdf);
            $file = $request->file('pdf');
            $pdf = time().$_FILES["pdf"]["name"];
            Storage::disk("documentos")->put($pdf, file_get_contents($file->getRealPath()));
            $consulta->pdf = $pdf;
        }   

        $consulta->id_nivel = $request['nivel'];
        $consulta->id_pertenencia = $request['pertenencia'];
        $consulta->id_procedencia = $request['procedencia'];
        $consulta->id_tema = $request['tema'];
        $consulta->id_pais = $request['pais'];
        $consulta->id_ejercicio = $request['ejercicio'];
        $consulta->titulo = $request['titulo'];
        $consulta->autor = $request['nombre'];
        $consulta->sintesis = $request['descripcion'];
        $consulta->palabras_clave = $request['palabras'];
        $consulta->estatus     = $estatus;

        if ($consulta->save()) {

            ConsultaSector::where('id_consulta',$consulta->id)->delete();
            //foreach ($request['sector'] as $key => $value) {
                ConsultaSector::create([
                    'id_sector'          => $request['nivel'],
                    'id_consulta'         => $consulta->id
                ]);
            //}


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
            $consulta = Consulta::findOrFail($id);
            Consulta::destroy($id);
            ConsultaSector::where('id_consulta',$id)->delete();
            Storage::disk('documentos')->delete($consulta->pdf);
            return redirect()->back()->with([
               'titulo'  => Lang::get('messages.mensajeTransaccion.exito'),
                'tipo'  => Lang::get('messages.mensajeTransaccion.success'),
                'icono' => Lang::get('messages.mensajeTransaccion.iconSuccess'),
                'msj'   => Lang::get('messages.mensajeTransaccion.msjSuccess'),
            ]);
        }
    }
}
