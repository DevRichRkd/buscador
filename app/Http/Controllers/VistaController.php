<?php

namespace App\Http\Controllers;

use App\Informacion;
use Lang;
use Auth;
use App\Nivel;
use App\Ejercicio;
use App\Pais;
use App\Pertenencia;
use App\Procedencia;
use App\Ajuste;
use App\Tema;
use App\Consulta;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class Vistacontroller extends Controller{
    
    public function index(){

        $niveles = Nivel::where('estatus','1')->get();

        $ajustes = Ajuste::findOrFail(1);

        $diaActual = Carbon::now()->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');

        return view('welcome')->with([
                                        'niveles' => $niveles,
                                        'actual' => $diaActual,                                         
                                        'ajustes' => $ajustes,                                         
                                    ]);
    }

    public function getTipoExpedienteById($id){

        $expedientes = Informacion::where('id_expediente',$id)->get();

        $idEntidad = 0;
        $idAnio  = 0;
        $idTipo  = 0;
        $idEpoca  =  0;
        $idMateria  =  0;

        $sqlEntidades = "SELECT e.id, e.nombre, COUNT(e.id) AS total FROM entidades AS e, informacion AS i WHERE e.id = i.id_entidad AND i.id_expediente = $id GROUP BY id";
        $totalEntidades = DB::select($sqlEntidades);

        $sqlAnios = "SELECT a.id, a.nombre, COUNT(a.id) AS total FROM anios AS a, informacion AS i WHERE a.id = i.id_anio AND i.id_expediente = $id GROUP BY id";
        $totalAnios = DB::select($sqlAnios);

        $sqlCriterios = "SELECT c.id, c.nombre, COUNT(c.id) AS total FROM criterios AS c, informacion AS i WHERE c.id = i.id_criterio AND i.id_expediente = $id GROUP BY id";
        $totalCriterios = DB::select($sqlCriterios);

        $sqlEpocas = "SELECT e.id, e.nombre, COUNT(e.id) AS total FROM epocas AS e, informacion AS i WHERE e.id = i.id_epoca AND i.id_expediente = $id GROUP BY id";
        $totalEpocas = DB::select($sqlEpocas);

        $sqlMaterias = "SELECT m.id, m.nombre, COUNT(m.id) AS total FROM materias AS m, informacion AS i WHERE m.id = i.id_epoca AND i.id_expediente = $id GROUP BY id";
        $totalMaterias = DB::select($sqlMaterias);

        return view('expedientes')->with([
                                        'expedientes' => $expedientes,
                                        'totalEntidades'=> $totalEntidades,
                                        'totalAnios'=> $totalAnios,
                                        'totalCriterios'=> $totalCriterios,
                                        'totalEpocas'=> $totalEpocas,
                                        'totalMaterias'=> $totalMaterias,

                                        'idExpediente'=> $id,
                                        'idEntidad'=> $idEntidad,
                                        'idAnio'=> $idAnio,
                                        'idTipo'=> $idTipo,
                                        'idEpoca'=> $idEpoca,
                                        'idMateria'=> $idMateria,
                                    ]);
    }

    public function filters($expediente = 0, $entidad = 0, $anio = 0, $tipo = 0, $epoca = 0, $materia = 0){

        $expedientes = Informacion::where('id_expediente',$expediente)
        ->when($entidad, function ($query, $entidad){
            return $query->where('id_entidad', $entidad);
        })
        ->when($anio, function ($query, $anio){
            return $query->where('id_anio', $anio);
        })
        ->when($tipo, function ($query, $tipo){
            return $query->where('id_criterio', $tipo);
        })
        ->when($epoca, function ($query, $epoca){
            return $query->where('id_epoca', $epoca);
        })
        ->when($materia, function ($query, $materia){
            return $query->where('id_materia', $materia);
        })
        ->get();

        

        $sqlEntidades = "SELECT e.id, e.nombre, COUNT(e.id) AS total FROM entidades AS e, informacion AS i WHERE e.id = i.id_entidad AND i.id_expediente = $expediente";
        if ($entidad > 0){
            $sqlEntidades .= " AND i.id_entidad = $entidad";
        }
        if ($anio > 0){
            $sqlEntidades .= " AND i.id_anio = $anio";
        }
        if ($tipo > 0){
            $sqlEntidades .= " AND i.id_criterio = $tipo";
        }
        if ($epoca > 0){
            $sqlEntidades .= " AND i.id_epoca = $epoca";
        }
        if ($materia > 0){
            $sqlEntidades .= " AND i.id_materia = $materia";
        }
        $sqlEntidades .= " GROUP BY id";
        $totalEntidades = DB::select($sqlEntidades);

        $sqlAnios = "SELECT a.id, a.nombre, COUNT(a.id) AS total FROM anios AS a, informacion AS i WHERE a.id = i.id_anio AND i.id_expediente = $expediente";
        if ($entidad > 0){
            $sqlAnios .= " AND i.id_entidad = $entidad";
        }
        if ($anio > 0){
            $sqlAnios .= " AND i.id_anio = $anio";
        }
        if ($tipo > 0){
            $sqlAnios .= " AND i.id_criterio = $tipo";
        }
        if ($epoca > 0){
            $sqlAnios .= " AND i.id_epoca = $epoca";
        }
        if ($materia > 0){
            $sqlAnios .= " AND i.id_materia = $materia";
        }
        $sqlAnios .= " GROUP BY id";
        $totalAnios = DB::select($sqlAnios);

        $sqlCriterios = "SELECT c.id, c.nombre, COUNT(c.id) AS total FROM criterios AS c, informacion AS i WHERE c.id = i.id_criterio AND i.id_expediente = $expediente";
        if ($entidad > 0){
            $sqlCriterios .= " AND i.id_entidad = $entidad";
        }
        if ($anio > 0){
            $sqlCriterios .= " AND i.id_anio = $anio";
        }
        if ($tipo > 0){
            $sqlCriterios .= " AND i.id_criterio = $tipo";
        }
        if ($epoca > 0){
            $sqlCriterios .= " AND i.id_epoca = $epoca";
        }
        if ($materia > 0){
            $sqlCriterios .= " AND i.id_materia = $materia";
        }
        $sqlCriterios .= " GROUP BY id";
        $totalCriterios = DB::select($sqlCriterios);

        $sqlEpocas = "SELECT e.id, e.nombre, COUNT(e.id) AS total FROM epocas AS e, informacion AS i WHERE e.id = i.id_epoca AND i.id_expediente = $expediente";
        if ($entidad > 0){
            $sqlEpocas .= " AND i.id_entidad = $entidad";
        }
        if ($anio > 0){
            $sqlEpocas .= " AND i.id_anio = $anio";
        }
        if ($tipo > 0){
            $sqlEpocas .= " AND i.id_criterio = $tipo";
        }
        if ($epoca > 0){
            $sqlEpocas .= " AND i.id_epoca = $epoca";
        }
        if ($materia > 0){
            $sqlEpocas .= " AND i.id_materia = $materia";
        }
        $sqlEpocas .= " GROUP BY id";
        $totalEpocas = DB::select($sqlEpocas);

        $sqlMaterias = "SELECT m.id, m.nombre, COUNT(m.id) AS total FROM materias AS m, informacion AS i WHERE m.id = i.id_epoca AND i.id_expediente = $expediente";
        if ($entidad > 0){
            $sqlMaterias .= " AND i.id_entidad = $entidad";
        }
        if ($anio > 0){
            $sqlMaterias .= " AND i.id_anio = $anio";
        }
        if ($tipo > 0){
            $sqlMaterias .= " AND i.id_criterio = $tipo";
        }
        if ($epoca > 0){
            $sqlMaterias .= " AND i.id_epoca = $epoca";
        }
        if ($materia > 0){
            $sqlMaterias .= " AND i.id_materia = $materia";
        }
        $sqlMaterias .= " GROUP BY id";
        $totalMaterias = DB::select($sqlMaterias);

        return view('result')->with([
                                    'expedientes' => $expedientes,
                                    'totalEntidades'=> $totalEntidades,
                                    'totalAnios'=> $totalAnios,
                                    'totalCriterios'=> $totalCriterios,
                                    'totalEpocas'=> $totalEpocas,
                                    'totalMaterias'=> $totalMaterias,

                                    'idExpediente'=> $expediente,
                                    'idEntidad'=> $entidad,
                                    'idAnio'=> $anio,
                                    'idTipo'=> $tipo,
                                    'idEpoca'=> $epoca,
                                    'idMateria'=> $materia,

        ]);
    }

    public function busqueda(){

        $niveles = Nivel::where('estatus','1')->get();
        $ejercicios = Ejercicio::where('estatus','1')->get();
        $paises = Pais::where('estatus','1')->get();
        $pertenencias = Pertenencia::where('estatus','1')->get();
        $procedencias = Procedencia::where('estatus','1')->get();
        $temas = Tema::where('estatus','1')->get();

        $ajustes = Ajuste::findOrFail(1);

        $diaActual = Carbon::now()->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');

        return view('busqueda')->with([
                                        'niveles' => $niveles,
                                        'actual' => $diaActual,                                         
                                        'ajustes' => $ajustes, 
                                        'ejercicios' => $ejercicios,
                                        'paises' => $paises,
                                        'pertenencias' => $pertenencias,
                                        'procedencias' => $procedencias,                                        
                                        'temas' => $temas,                                        
                                    ]);

        return view('busqueda')->with([
                                                                                  
                                    ]);
    }

    public function resultados(){

        $niveles = Nivel::where('estatus','1')->get();
        $ejercicios = Ejercicio::where('estatus','1')->get();
        $paises = Pais::where('estatus','1')->get();
        $pertenencias = Pertenencia::where('estatus','1')->get();
        $procedencias = Procedencia::where('estatus','1')->get();

        $ajustes = Ajuste::findOrFail(1);

        $diaActual = Carbon::now()->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');

        return view('resultados')->with([
                                        'niveles' => $niveles,
                                        'actual' => $diaActual,                                         
                                        'ajustes' => $ajustes,
                                        'ejercicios' => $ejercicios,
                                        'paises' => $paises,
                                        'pertenencias' => $pertenencias,
                                        'procedencias' => $procedencias,                                      
                                    ]);

        return view('resultados')->with([
                                                                                  
                                    ]);
    }

    public function show($id){
        $niveles = Nivel::where('estatus','1')->get();

        $ajustes = Ajuste::findOrFail(1);

        $diaActual = Carbon::now()->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');

        $autor = 0;
        $titulo  = 0;
        $clave  = 0;
        $ejercicio  =  0;
        $pais  =  0;
        $nivel  =  0;
        $tema  =  0;
        $pertenencia  =  0;
        $procedencia  =  0;

        $totalEjercicio= DB::table('consultas')
                            ->select(
                                    'ejercicios.id', 
                                    'ejercicios.nombre', 
                                    DB::raw('count(ejercicios.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.id',$id)
                            ->where('niveles.estatus','1')
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                            ->when($ejercicio, function ($query, $ejercicio) {
                                return $query->where('ejercicios.id', $ejercicio);
                            })
                            
                            ->when($pais, function ($query, $pais) {
                                return $query->where('paises.id', $pais);
                            })

                            ->when($nivel, function ($query, $nivel) {
                                return $query->where('niveles.id', $nivel);
                            })

                            ->when($tema, function ($query, $tema) {
                                return $query->where('temas.id', $tema);
                            })

                            ->when($procedencia, function ($query, $procedencia) {
                                return $query->where('institucion_procedencia.id', $procedencia);
                            })

                            ->when($pertenencia, function ($query, $pertenencia) {
                                return $query->where('institucion_pertenencia.id', $pertenencia);
                            })


                            ->when($clave, function ($query, $clave) {
                                return $query->where('consultas.palabras_clave','like', '%'.$clave.'%');
                            })

                            ->when($autor, function ($query, $autor) {
                                return $query->where('consultas.autor', 'like', '%'.$autor.'%');
                            })

                            ->when($titulo, function ($query, $titulo) {
                                return $query->where('consultas.titulo', 'like', '%'.$titulo.'%');
                            })

                            ->groupBy('ejercicios.id')
                            ->groupBy('ejercicios.nombre')
                            ->get();

        $totalNivel= DB::table('consultas')
                            ->select(
                                    'niveles.id', 
                                    'niveles.nombre', 
                                    DB::raw('count(niveles.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('niveles.id',$id)
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                            ->when($ejercicio, function ($query, $ejercicio) {
                                return $query->where('ejercicios.id', $ejercicio);
                            })
                            
                            ->when($pais, function ($query, $pais) {
                                return $query->where('paises.id', $pais);
                            })

                            ->when($nivel, function ($query, $nivel) {
                                return $query->where('niveles.id', $nivel);
                            })

                            ->when($tema, function ($query, $tema) {
                                return $query->where('temas.id', $tema);
                            })

                            ->when($procedencia, function ($query, $procedencia) {
                                return $query->where('institucion_procedencia.id', $procedencia);
                            })

                            ->when($pertenencia, function ($query, $pertenencia) {
                                return $query->where('institucion_pertenencia.id', $pertenencia);
                            })


                            ->when($clave, function ($query, $clave) {
                                return $query->where('consultas.palabras_clave','like', '%'.$clave.'%');
                            })

                            ->when($autor, function ($query, $autor) {
                                return $query->where('consultas.autor', 'like', '%'.$autor.'%');
                            })

                            ->when($titulo, function ($query, $titulo) {
                                return $query->where('consultas.titulo', 'like', '%'.$titulo.'%');
                            })

                            ->groupBy('niveles.id')
                            ->groupBy('niveles.nombre')
                            ->get();

        $totalTema = DB::table('consultas')
                            ->select(
                                    'temas.id', 
                                    'temas.nombre', 
                                    DB::raw('count(temas.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('niveles.id',$id)
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                            ->when($ejercicio, function ($query, $ejercicio) {
                                return $query->where('ejercicios.id', $ejercicio);
                            })
                            
                            ->when($pais, function ($query, $pais) {
                                return $query->where('paises.id', $pais);
                            })

                            ->when($nivel, function ($query, $nivel) {
                                return $query->where('niveles.id', $nivel);
                            })

                            ->when($tema, function ($query, $tema) {
                                return $query->where('temas.id', $tema);
                            })

                            ->when($procedencia, function ($query, $procedencia) {
                                return $query->where('institucion_procedencia.id', $procedencia);
                            })

                            ->when($pertenencia, function ($query, $pertenencia) {
                                return $query->where('institucion_pertenencia.id', $pertenencia);
                            })


                            ->when($clave, function ($query, $clave) {
                                return $query->where('consultas.palabras_clave','like', '%'.$clave.'%');
                            })

                            ->when($autor, function ($query, $autor) {
                                return $query->where('consultas.autor', 'like', '%'.$autor.'%');
                            })

                            ->when($titulo, function ($query, $titulo) {
                                return $query->where('consultas.titulo', 'like', '%'.$titulo.'%');
                            })

                            ->groupBy('temas.id')
                            ->groupBy('temas.nombre')
                            ->get();

        $totalPais = DB::table('consultas')
                            ->select(
                                    'paises.id', 
                                    'paises.nombre', 
                                    DB::raw('count(paises.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('niveles.id',$id)
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                            ->when($ejercicio, function ($query, $ejercicio) {
                                return $query->where('ejercicios.id', $ejercicio);
                            })
                            
                            ->when($pais, function ($query, $pais) {
                                return $query->where('paises.id', $pais);
                            })

                            ->when($nivel, function ($query, $nivel) {
                                return $query->where('niveles.id', $nivel);
                            })

                            ->when($tema, function ($query, $tema) {
                                return $query->where('temas.id', $tema);
                            })

                            ->when($procedencia, function ($query, $procedencia) {
                                return $query->where('institucion_procedencia.id', $procedencia);
                            })

                            ->when($pertenencia, function ($query, $pertenencia) {
                                return $query->where('institucion_pertenencia.id', $pertenencia);
                            })


                            ->when($clave, function ($query, $clave) {
                                return $query->where('consultas.palabras_clave','like', '%'.$clave.'%');
                            })

                            ->when($autor, function ($query, $autor) {
                                return $query->where('consultas.autor', 'like', '%'.$autor.'%');
                            })

                            ->when($titulo, function ($query, $titulo) {
                                return $query->where('consultas.titulo', 'like', '%'.$titulo.'%');
                            })

                            ->groupBy('paises.id')
                            ->groupBy('paises.nombre')
                            ->get();

        $totalPertenencia = DB::table('consultas')
                            ->select(
                                    'institucion_pertenencia.id', 
                                    'institucion_pertenencia.nombre', 
                                    DB::raw('count(institucion_pertenencia.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('niveles.id',$id)
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                            ->when($ejercicio, function ($query, $ejercicio) {
                                return $query->where('ejercicios.id', $ejercicio);
                            })
                            
                            ->when($pais, function ($query, $pais) {
                                return $query->where('paises.id', $pais);
                            })

                            ->when($nivel, function ($query, $nivel) {
                                return $query->where('niveles.id', $nivel);
                            })

                            ->when($tema, function ($query, $tema) {
                                return $query->where('temas.id', $tema);
                            })

                            ->when($procedencia, function ($query, $procedencia) {
                                return $query->where('institucion_procedencia.id', $procedencia);
                            })

                            ->when($pertenencia, function ($query, $pertenencia) {
                                return $query->where('institucion_pertenencia.id', $pertenencia);
                            })


                            ->when($clave, function ($query, $clave) {
                                return $query->where('consultas.palabras_clave','like', '%'.$clave.'%');
                            })

                            ->when($autor, function ($query, $autor) {
                                return $query->where('consultas.autor', 'like', '%'.$autor.'%');
                            })

                            ->when($titulo, function ($query, $titulo) {
                                return $query->where('consultas.titulo', 'like', '%'.$titulo.'%');
                            })

                            ->groupBy('institucion_pertenencia.id')
                            ->groupBy('institucion_pertenencia.nombre')
                            ->get();

        $totalProcedencia = DB::table('consultas')
                            ->select(
                                    'institucion_procedencia.id', 
                                    'institucion_procedencia.nombre', 
                                    DB::raw('count(institucion_procedencia.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('niveles.id',$id)
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                            ->when($ejercicio, function ($query, $ejercicio) {
                                return $query->where('ejercicios.id', $ejercicio);
                            })
                            
                            ->when($pais, function ($query, $pais) {
                                return $query->where('paises.id', $pais);
                            })

                            ->when($nivel, function ($query, $nivel) {
                                return $query->where('niveles.id', $nivel);
                            })

                            ->when($tema, function ($query, $tema) {
                                return $query->where('temas.id', $tema);
                            })

                            ->when($procedencia, function ($query, $procedencia) {
                                return $query->where('institucion_procedencia.id', $procedencia);
                            })

                            ->when($pertenencia, function ($query, $pertenencia) {
                                return $query->where('institucion_pertenencia.id', $pertenencia);
                            })


                            ->when($clave, function ($query, $clave) {
                                return $query->where('consultas.palabras_clave','like', '%'.$clave.'%');
                            })

                            ->when($autor, function ($query, $autor) {
                                return $query->where('consultas.autor', 'like', '%'.$autor.'%');
                            })

                            ->when($titulo, function ($query, $titulo) {
                                return $query->where('consultas.titulo', 'like', '%'.$titulo.'%');
                            })

                            ->groupBy('institucion_procedencia.id')
                            ->groupBy('institucion_procedencia.nombre')
                            ->get();

        $consultas = DB::table('consultas')
                            ->select(
                                    'consultas.autor as autor', 
                                    'consultas.titulo as titulo',
                                    'consultas.sintesis as sintesis',
                                    'consultas.pdf as pdf',
                                    'consultas.palabras_clave as palabras_clave',
                                    'niveles.nombre as nivel',
                                    'temas.nombre as tema',
                                    'ejercicios.nombre as ejercicio',
                                    'paises.nombre as pais',
                                    'institucion_pertenencia.nombre as pertenencia',
                                    'institucion_procedencia.nombre as procedencia'
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('niveles.id',$id)
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                            ->when($ejercicio, function ($query, $ejercicio) {
                                return $query->where('ejercicios.id', $ejercicio);
                            })
                            
                            ->when($pais, function ($query, $pais) {
                                return $query->where('paises.id', $pais);
                            })

                            ->when($nivel, function ($query, $nivel) {
                                return $query->where('niveles.id', $nivel);
                            })

                            ->when($tema, function ($query, $tema) {
                                return $query->where('temas.id', $tema);
                            })

                            ->when($procedencia, function ($query, $procedencia) {
                                return $query->where('institucion_procedencia.id', $procedencia);
                            })

                            ->when($pertenencia, function ($query, $pertenencia) {
                                return $query->where('institucion_pertenencia.id', $pertenencia);
                            })


                            ->when($clave, function ($query, $clave) {
                                return $query->where('consultas.palabras_clave','like', '%'.$clave.'%');
                            })

                            ->when($autor, function ($query, $autor) {
                                return $query->where('consultas.autor', 'like', '%'.$autor.'%');
                            })

                            ->when($titulo, function ($query, $titulo) {
                                return $query->where('consultas.titulo', 'like', '%'.$titulo.'%');
                            })
                            ->paginate(10);

        return view('resultados')->with([
                                        'niveles' => $niveles,
                                        'actual' => $diaActual,                                         
                                        'ajustes' => $ajustes,
                                        'totalEjercicio' => $totalEjercicio,
                                        'totalNivel' => $totalNivel,
                                        'totalTema' => $totalTema,
                                        'totalPais' => $totalPais,
                                        'totalPertenencia' => $totalPertenencia,
                                        'totalProcedencia' => $totalProcedencia,                                    
                                        'consultas' => $consultas,   

                                        'request' => 0,
                                        'nivel' => $id,
                                        'ejercicio' => 0,
                                        'tema' => 0,
                                        'pais' => 0,
                                        'procedencia' => 0,
                                        'pertenencia' => 0,
                                        'palabras' => 0,
                                        'autor' => 0,                                
                                        'titulo' => 0,                                 
                                    ]);
    }

    public function buscar(Request $request){
        $niveles = Nivel::where('estatus','1')->get();

        $diaActual = Carbon::now()->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');

        $ajustes = Ajuste::findOrFail(1);

        $autor= ($request->input('autor')) ? $request->input('autor') : 0 ;
        $titulo = ($request->input('publicacion')) ? $request->input('publicacion') : 0 ;
        $clave = ($request->input('clave')) ? $request->input('clave') : 0 ;
        $ejercicio = $request->input('anio'); //
        $pais = $request->input('pais'); //
        $nivel = $request->input('nivel'); //
        $tema = $request->input('tema'); //
        $pertenencia = $request->input('pertenencia'); //
        $procedencia = $request->input('procedencia'); //

        $totalEjercicio= DB::table('consultas')
                            ->select(
                                    'ejercicios.id', 
                                    'ejercicios.nombre', 
                                    DB::raw('count(ejercicios.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                            ->when($ejercicio, function ($query, $ejercicio) {
                                return $query->where('ejercicios.id', $ejercicio);
                            })
                            
                            ->when($pais, function ($query, $pais) {
                                return $query->where('paises.id', $pais);
                            })

                            ->when($nivel, function ($query, $nivel) {
                                return $query->where('niveles.id', $nivel);
                            })

                            ->when($tema, function ($query, $tema) {
                                return $query->where('temas.id', $tema);
                            })

                            ->when($procedencia, function ($query, $procedencia) {
                                return $query->where('institucion_procedencia.id', $procedencia);
                            })

                            ->when($pertenencia, function ($query, $pertenencia) {
                                return $query->where('institucion_pertenencia.id', $pertenencia);
                            })


                            ->when($clave, function ($query, $clave) {
                                return $query->where('consultas.palabras_clave','like', '%'.$clave.'%');
                            })

                            ->when($autor, function ($query, $autor) {
                                return $query->where('consultas.autor', 'like', '%'.$autor.'%');
                            })

                            ->when($titulo, function ($query, $titulo) {
                                return $query->where('consultas.titulo', 'like', '%'.$titulo.'%');
                            })

                            ->groupBy('ejercicios.id')
                            ->groupBy('ejercicios.nombre')
                            ->get();

        $totalNivel= DB::table('consultas')
                            ->select(
                                    'niveles.id', 
                                    'niveles.nombre', 
                                    DB::raw('count(niveles.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                            ->when($ejercicio, function ($query, $ejercicio) {
                                return $query->where('ejercicios.id', $ejercicio);
                            })
                            
                            ->when($pais, function ($query, $pais) {
                                return $query->where('paises.id', $pais);
                            })

                            ->when($nivel, function ($query, $nivel) {
                                return $query->where('niveles.id', $nivel);
                            })

                            ->when($tema, function ($query, $tema) {
                                return $query->where('temas.id', $tema);
                            })

                            ->when($procedencia, function ($query, $procedencia) {
                                return $query->where('institucion_procedencia.id', $procedencia);
                            })

                            ->when($pertenencia, function ($query, $pertenencia) {
                                return $query->where('institucion_pertenencia.id', $pertenencia);
                            })


                            ->when($clave, function ($query, $clave) {
                                return $query->where('consultas.palabras_clave','like', '%'.$clave.'%');
                            })

                            ->when($autor, function ($query, $autor) {
                                return $query->where('consultas.autor', 'like', '%'.$autor.'%');
                            })

                            ->when($titulo, function ($query, $titulo) {
                                return $query->where('consultas.titulo', 'like', '%'.$titulo.'%');
                            })

                            ->groupBy('niveles.id')
                            ->groupBy('niveles.nombre')
                            ->get();

        $totalTema = DB::table('consultas')
                            ->select(
                                    'temas.id', 
                                    'temas.nombre', 
                                    DB::raw('count(temas.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                            ->when($ejercicio, function ($query, $ejercicio) {
                                return $query->where('ejercicios.id', $ejercicio);
                            })
                            
                            ->when($pais, function ($query, $pais) {
                                return $query->where('paises.id', $pais);
                            })

                            ->when($nivel, function ($query, $nivel) {
                                return $query->where('niveles.id', $nivel);
                            })

                            ->when($tema, function ($query, $tema) {
                                return $query->where('temas.id', $tema);
                            })

                            ->when($procedencia, function ($query, $procedencia) {
                                return $query->where('institucion_procedencia.id', $procedencia);
                            })

                            ->when($pertenencia, function ($query, $pertenencia) {
                                return $query->where('institucion_pertenencia.id', $pertenencia);
                            })


                            ->when($clave, function ($query, $clave) {
                                return $query->where('consultas.palabras_clave','like', '%'.$clave.'%');
                            })

                            ->when($autor, function ($query, $autor) {
                                return $query->where('consultas.autor', 'like', '%'.$autor.'%');
                            })

                            ->when($titulo, function ($query, $titulo) {
                                return $query->where('consultas.titulo', 'like', '%'.$titulo.'%');
                            })

                            ->groupBy('temas.id')
                            ->groupBy('temas.nombre')
                            ->get();

        $totalPais = DB::table('consultas')
                            ->select(
                                    'paises.id', 
                                    'paises.nombre', 
                                    DB::raw('count(paises.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                            ->when($ejercicio, function ($query, $ejercicio) {
                                return $query->where('ejercicios.id', $ejercicio);
                            })
                            
                            ->when($pais, function ($query, $pais) {
                                return $query->where('paises.id', $pais);
                            })

                            ->when($nivel, function ($query, $nivel) {
                                return $query->where('niveles.id', $nivel);
                            })

                            ->when($tema, function ($query, $tema) {
                                return $query->where('temas.id', $tema);
                            })

                            ->when($procedencia, function ($query, $procedencia) {
                                return $query->where('institucion_procedencia.id', $procedencia);
                            })

                            ->when($pertenencia, function ($query, $pertenencia) {
                                return $query->where('institucion_pertenencia.id', $pertenencia);
                            })


                            ->when($clave, function ($query, $clave) {
                                return $query->where('consultas.palabras_clave','like', '%'.$clave.'%');
                            })

                            ->when($autor, function ($query, $autor) {
                                return $query->where('consultas.autor', 'like', '%'.$autor.'%');
                            })

                            ->when($titulo, function ($query, $titulo) {
                                return $query->where('consultas.titulo', 'like', '%'.$titulo.'%');
                            })

                            ->groupBy('paises.id')
                            ->groupBy('paises.nombre')
                            ->get();

        $totalPertenencia = DB::table('consultas')
                            ->select(
                                    'institucion_pertenencia.id', 
                                    'institucion_pertenencia.nombre', 
                                    DB::raw('count(institucion_pertenencia.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                            ->when($ejercicio, function ($query, $ejercicio) {
                                return $query->where('ejercicios.id', $ejercicio);
                            })
                            
                            ->when($pais, function ($query, $pais) {
                                return $query->where('paises.id', $pais);
                            })

                            ->when($nivel, function ($query, $nivel) {
                                return $query->where('niveles.id', $nivel);
                            })

                            ->when($tema, function ($query, $tema) {
                                return $query->where('temas.id', $tema);
                            })

                            ->when($procedencia, function ($query, $procedencia) {
                                return $query->where('institucion_procedencia.id', $procedencia);
                            })

                            ->when($pertenencia, function ($query, $pertenencia) {
                                return $query->where('institucion_pertenencia.id', $pertenencia);
                            })


                            ->when($clave, function ($query, $clave) {
                                return $query->where('consultas.palabras_clave','like', '%'.$clave.'%');
                            })

                            ->when($autor, function ($query, $autor) {
                                return $query->where('consultas.autor', 'like', '%'.$autor.'%');
                            })

                            ->when($titulo, function ($query, $titulo) {
                                return $query->where('consultas.titulo', 'like', '%'.$titulo.'%');
                            })

                            ->groupBy('institucion_pertenencia.id')
                            ->groupBy('institucion_pertenencia.nombre')
                            ->get();

        $totalProcedencia = DB::table('consultas')
                            ->select(
                                    'institucion_procedencia.id', 
                                    'institucion_procedencia.nombre', 
                                    DB::raw('count(institucion_procedencia.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                            ->when($ejercicio, function ($query, $ejercicio) {
                                return $query->where('ejercicios.id', $ejercicio);
                            })
                            
                            ->when($pais, function ($query, $pais) {
                                return $query->where('paises.id', $pais);
                            })

                            ->when($nivel, function ($query, $nivel) {
                                return $query->where('niveles.id', $nivel);
                            })

                            ->when($tema, function ($query, $tema) {
                                return $query->where('temas.id', $tema);
                            })

                            ->when($procedencia, function ($query, $procedencia) {
                                return $query->where('institucion_procedencia.id', $procedencia);
                            })

                            ->when($pertenencia, function ($query, $pertenencia) {
                                return $query->where('institucion_pertenencia.id', $pertenencia);
                            })


                            ->when($clave, function ($query, $clave) {
                                return $query->where('consultas.palabras_clave','like', '%'.$clave.'%');
                            })

                            ->when($autor, function ($query, $autor) {
                                return $query->where('consultas.autor', 'like', '%'.$autor.'%');
                            })

                            ->when($titulo, function ($query, $titulo) {
                                return $query->where('consultas.titulo', 'like', '%'.$titulo.'%');
                            })

                            ->groupBy('institucion_procedencia.id')
                            ->groupBy('institucion_procedencia.nombre')
                            ->get();

        $consultas = DB::table('consultas')
                            ->select(
                                    'consultas.autor as autor', 
                                    'consultas.titulo as titulo',
                                    'consultas.sintesis as sintesis',
                                    'consultas.pdf as pdf',
                                    'consultas.palabras_clave as palabras_clave',
                                    'niveles.nombre as nivel',
                                    'temas.nombre as tema',
                                    'ejercicios.nombre as ejercicio',
                                    'paises.nombre as pais',
                                    'institucion_pertenencia.nombre as pertenencia',
                                    'institucion_procedencia.nombre as procedencia'
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                            ->when($ejercicio, function ($query, $ejercicio) {
                                return $query->where('ejercicios.id', $ejercicio);
                            })
                            
                            ->when($pais, function ($query, $pais) {
                                return $query->where('paises.id', $pais);
                            })

                            ->when($nivel, function ($query, $nivel) {
                                return $query->where('niveles.id', $nivel);
                            })

                            ->when($tema, function ($query, $tema) {
                                return $query->where('temas.id', $tema);
                            })

                            ->when($procedencia, function ($query, $procedencia) {
                                return $query->where('institucion_procedencia.id', $procedencia);
                            })

                            ->when($pertenencia, function ($query, $pertenencia) {
                                return $query->where('institucion_pertenencia.id', $pertenencia);
                            })


                            ->when($clave, function ($query, $clave) {
                                return $query->where('consultas.palabras_clave','like', '%'.$clave.'%');
                            })

                            ->when($autor, function ($query, $autor) {
                                return $query->where('consultas.autor', 'like', '%'.$autor.'%');
                            })

                            ->when($titulo, function ($query, $titulo) {
                                return $query->where('consultas.titulo', 'like', '%'.$titulo.'%');
                            })
                            ->paginate(10);

        return view('resultados')->with([
                                        'niveles' => $niveles,
                                        'actual' => $diaActual,                                         
                                        'ajustes' => $ajustes,
                                        'totalEjercicio' => $totalEjercicio,
                                        'totalNivel' => $totalNivel,
                                        'totalTema' => $totalTema,
                                        'totalPais' => $totalPais,
                                        'totalPertenencia' => $totalPertenencia,
                                        'totalProcedencia' => $totalProcedencia,                                    
                                        'consultas' => $consultas,    

                                        'request' => 0,
                                        'nivel' => $nivel,
                                        'ejercicio' => $ejercicio,
                                        'tema' => $tema,
                                        'pais' => $pais,
                                        'procedencia' => $procedencia,
                                        'pertenencia' => $pertenencia,
                                        'palabras' => $clave,
                                        'autor' => $autor,                                
                                        'titulo' => $titulo,                                
                                    ]);
    }

    public function general(Request $request){
        $this->validate($request, [
            'buscar'      => 'required'
        ]);

        $niveles = Nivel::where('estatus','1')->get();

        $diaActual = Carbon::now()->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');

        $ajustes = Ajuste::findOrFail(1);

                $totalEjercicio= DB::table('consultas')
                            ->select(
                                    'ejercicios.id', 
                                    'ejercicios.nombre', 
                                    DB::raw('count(ejercicios.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                             ->where(function ($query)  use ($request){
                                $query->orWhere('consultas.autor', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('consultas.titulo', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('consultas.sintesis', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('consultas.palabras_clave', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('temas.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('paises.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('institucion_pertenencia.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('institucion_procedencia.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('niveles.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('ejercicios.nombre', 'like', '%'.$request['buscar'].'%');
                            })

                            ->groupBy('ejercicios.id')
                            ->groupBy('ejercicios.nombre')
                            ->get();

        $totalNivel= DB::table('consultas')
                            ->select(
                                    'niveles.id', 
                                    'niveles.nombre', 
                                    DB::raw('count(niveles.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                             ->where(function ($query)  use ($request){
                                $query->orWhere('consultas.autor', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('consultas.titulo', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('consultas.sintesis', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('consultas.palabras_clave', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('temas.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('paises.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('institucion_pertenencia.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('institucion_procedencia.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('niveles.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('ejercicios.nombre', 'like', '%'.$request['buscar'].'%');
                            })

                            ->groupBy('niveles.id')
                            ->groupBy('niveles.nombre')
                            ->get();

        $totalTema = DB::table('consultas')
                            ->select(
                                    'temas.id', 
                                    'temas.nombre', 
                                    DB::raw('count(temas.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                             ->where(function ($query)  use ($request){
                                $query->orWhere('consultas.autor', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('consultas.titulo', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('consultas.sintesis', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('consultas.palabras_clave', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('temas.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('paises.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('institucion_pertenencia.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('institucion_procedencia.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('niveles.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('ejercicios.nombre', 'like', '%'.$request['buscar'].'%');
                            })

                            ->groupBy('temas.id')
                            ->groupBy('temas.nombre')
                            ->get();

        $totalPais = DB::table('consultas')
                            ->select(
                                    'paises.id', 
                                    'paises.nombre', 
                                    DB::raw('count(paises.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                             ->where(function ($query)  use ($request){
                                $query->orWhere('consultas.autor', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('consultas.titulo', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('consultas.sintesis', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('consultas.palabras_clave', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('temas.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('paises.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('institucion_pertenencia.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('institucion_procedencia.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('niveles.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('ejercicios.nombre', 'like', '%'.$request['buscar'].'%');
                            })

                            ->groupBy('paises.id')
                            ->groupBy('paises.nombre')
                            ->get();

        $totalPertenencia = DB::table('consultas')
                            ->select(
                                    'institucion_pertenencia.id', 
                                    'institucion_pertenencia.nombre', 
                                    DB::raw('count(institucion_pertenencia.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                             ->where(function ($query)  use ($request){
                                $query->orWhere('consultas.autor', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('consultas.titulo', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('consultas.sintesis', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('consultas.palabras_clave', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('temas.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('paises.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('institucion_pertenencia.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('institucion_procedencia.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('niveles.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('ejercicios.nombre', 'like', '%'.$request['buscar'].'%');
                            })

                            ->groupBy('institucion_pertenencia.id')
                            ->groupBy('institucion_pertenencia.nombre')
                            ->get();

        $totalProcedencia = DB::table('consultas')
                            ->select(
                                    'institucion_procedencia.id', 
                                    'institucion_procedencia.nombre', 
                                    DB::raw('count(institucion_procedencia.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                             ->where(function ($query)  use ($request){
                                $query->orWhere('consultas.autor', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('consultas.titulo', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('consultas.sintesis', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('consultas.palabras_clave', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('temas.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('paises.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('institucion_pertenencia.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('institucion_procedencia.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('niveles.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('ejercicios.nombre', 'like', '%'.$request['buscar'].'%');
                            })

                            ->groupBy('institucion_procedencia.id')
                            ->groupBy('institucion_procedencia.nombre')
                            ->get();

        $consultas = DB::table('consultas')
                            ->select(
                                    'consultas.autor as autor', 
                                    'consultas.titulo as titulo',
                                    'consultas.sintesis as sintesis',
                                    'consultas.pdf as pdf',
                                    'consultas.palabras_clave as palabras_clave',
                                    'niveles.nombre as nivel',
                                    'temas.nombre as tema',
                                    'ejercicios.nombre as ejercicio',
                                    'paises.nombre as pais',
                                    'institucion_pertenencia.nombre as pertenencia',
                                    'institucion_procedencia.nombre as procedencia'
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                             ->where(function ($query)  use ($request){
                                $query->orWhere('consultas.autor', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('consultas.titulo', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('consultas.sintesis', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('consultas.palabras_clave', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('temas.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('paises.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('institucion_pertenencia.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('institucion_procedencia.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('niveles.nombre', 'like', '%'.$request['buscar'].'%')        
                                ->orWhere('ejercicios.nombre', 'like', '%'.$request['buscar'].'%');
                            })
                            ->paginate(10);

        return view('resultados')->with([
                                        'niveles' => $niveles,
                                        'actual' => $diaActual,                                         
                                        'ajustes' => $ajustes,
                                        'totalEjercicio' => $totalEjercicio,
                                        'totalNivel' => $totalNivel,
                                        'totalTema' => $totalTema,
                                        'totalPais' => $totalPais,
                                        'totalPertenencia' => $totalPertenencia,
                                        'totalProcedencia' => $totalProcedencia,                                    
                                        'consultas' => $consultas,    

                                        'request' => $request['buscar'],
                                        'nivel' => 0,
                                        'ejercicio' => 0,
                                        'tema' => 0,
                                        'pais' => 0,
                                        'procedencia' => 0,
                                        'pertenencia' => 0,
                                        'palabras' => 0,
                                        'autor' => 0,                                
                                        'titulo' => 0,                                
                                    ]);
    }

    /******************************************************
        Búsqueda Filtros
    ******************************************************/
    public function filtros($buscar = 0, $nivel = 0, $ejercicio = 0, $tema = 0, $pais = 0, $pertenencia = 0, $procedencia = 0, $clave = 0, $autor = 0, $titulo = 0){
                 
        $niveles = Nivel::where('estatus','1')->get();

        $diaActual = Carbon::now()->locale('es')->isoFormat('dddd D \d\e MMMM \d\e\l Y');

        $ajustes = Ajuste::findOrFail(1);

                $totalEjercicio= DB::table('consultas')
                            ->select(
                                    'ejercicios.id', 
                                    'ejercicios.nombre', 
                                    DB::raw('count(ejercicios.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                             ->where(function ($query)  use ($buscar){
                                $query->orWhere('consultas.autor', 'like', '%'.$buscar.'%')        
                                ->orWhere('consultas.titulo', 'like', '%'.$buscar.'%')        
                                ->orWhere('consultas.sintesis', 'like', '%'.$buscar.'%')        
                                ->orWhere('consultas.palabras_clave', 'like', '%'.$buscar.'%')        
                                ->orWhere('temas.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('paises.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('institucion_pertenencia.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('institucion_procedencia.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('niveles.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('ejercicios.nombre', 'like', '%'.$buscar.'%');
                            })

                            ->when($ejercicio, function ($query, $ejercicio) {
                                return $query->where('ejercicios.id', $ejercicio);
                            })
                            
                            ->when($pais, function ($query, $pais) {
                                return $query->where('paises.id', $pais);
                            })

                            ->when($nivel, function ($query, $nivel) {
                                return $query->where('niveles.id', $nivel);
                            })

                            ->when($tema, function ($query, $tema) {
                                return $query->where('temas.id', $tema);
                            })

                            ->when($procedencia, function ($query, $procedencia) {
                                return $query->where('institucion_procedencia.id', $procedencia);
                            })

                            ->when($pertenencia, function ($query, $pertenencia) {
                                return $query->where('institucion_pertenencia.id', $pertenencia);
                            })


                            ->when($clave, function ($query, $clave) {
                                return $query->where('consultas.palabras_clave','like', '%'.$clave.'%');
                            })

                            ->when($autor, function ($query, $autor) {
                                return $query->where('consultas.autor', 'like', '%'.$autor.'%');
                            })

                            ->when($titulo, function ($query, $titulo) {
                                return $query->where('consultas.titulo', 'like', '%'.$titulo.'%');
                            })

                            ->groupBy('ejercicios.id')
                            ->groupBy('ejercicios.nombre')
                            ->get();

        $totalNivel= DB::table('consultas')
                            ->select(
                                    'niveles.id', 
                                    'niveles.nombre', 
                                    DB::raw('count(niveles.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                             ->where(function ($query)  use ($buscar){
                               $query->orWhere('consultas.autor', 'like', '%'.$buscar.'%')        
                                ->orWhere('consultas.titulo', 'like', '%'.$buscar.'%')        
                                ->orWhere('consultas.sintesis', 'like', '%'.$buscar.'%')        
                                ->orWhere('consultas.palabras_clave', 'like', '%'.$buscar.'%')        
                                ->orWhere('temas.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('paises.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('institucion_pertenencia.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('institucion_procedencia.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('niveles.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('ejercicios.nombre', 'like', '%'.$buscar.'%');
                            })

                            ->when($ejercicio, function ($query, $ejercicio) {
                                return $query->where('ejercicios.id', $ejercicio);
                            })
                            
                            ->when($pais, function ($query, $pais) {
                                return $query->where('paises.id', $pais);
                            })

                            ->when($nivel, function ($query, $nivel) {
                                return $query->where('niveles.id', $nivel);
                            })

                            ->when($tema, function ($query, $tema) {
                                return $query->where('temas.id', $tema);
                            })

                            ->when($procedencia, function ($query, $procedencia) {
                                return $query->where('institucion_procedencia.id', $procedencia);
                            })

                            ->when($pertenencia, function ($query, $pertenencia) {
                                return $query->where('institucion_pertenencia.id', $pertenencia);
                            })


                            ->when($clave, function ($query, $clave) {
                                return $query->where('consultas.palabras_clave','like', '%'.$clave.'%');
                            })

                            ->when($autor, function ($query, $autor) {
                                return $query->where('consultas.autor', 'like', '%'.$autor.'%');
                            })

                            ->when($titulo, function ($query, $titulo) {
                                return $query->where('consultas.titulo', 'like', '%'.$titulo.'%');
                            })

                            ->groupBy('niveles.id')
                            ->groupBy('niveles.nombre')
                            ->get();

        $totalTema = DB::table('consultas')
                            ->select(
                                    'temas.id', 
                                    'temas.nombre', 
                                    DB::raw('count(temas.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                             ->where(function ($query)  use ($buscar){
                               $query->orWhere('consultas.autor', 'like', '%'.$buscar.'%')        
                                ->orWhere('consultas.titulo', 'like', '%'.$buscar.'%')        
                                ->orWhere('consultas.sintesis', 'like', '%'.$buscar.'%')        
                                ->orWhere('consultas.palabras_clave', 'like', '%'.$buscar.'%')        
                                ->orWhere('temas.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('paises.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('institucion_pertenencia.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('institucion_procedencia.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('niveles.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('ejercicios.nombre', 'like', '%'.$buscar.'%');
                            })

                            ->when($ejercicio, function ($query, $ejercicio) {
                                return $query->where('ejercicios.id', $ejercicio);
                            })
                            
                            ->when($pais, function ($query, $pais) {
                                return $query->where('paises.id', $pais);
                            })

                            ->when($nivel, function ($query, $nivel) {
                                return $query->where('niveles.id', $nivel);
                            })

                            ->when($tema, function ($query, $tema) {
                                return $query->where('temas.id', $tema);
                            })

                            ->when($procedencia, function ($query, $procedencia) {
                                return $query->where('institucion_procedencia.id', $procedencia);
                            })

                            ->when($pertenencia, function ($query, $pertenencia) {
                                return $query->where('institucion_pertenencia.id', $pertenencia);
                            })


                            ->when($clave, function ($query, $clave) {
                                return $query->where('consultas.palabras_clave','like', '%'.$clave.'%');
                            })

                            ->when($autor, function ($query, $autor) {
                                return $query->where('consultas.autor', 'like', '%'.$autor.'%');
                            })

                            ->when($titulo, function ($query, $titulo) {
                                return $query->where('consultas.titulo', 'like', '%'.$titulo.'%');
                            })

                            ->groupBy('temas.id')
                            ->groupBy('temas.nombre')
                            ->get();

        $totalPais = DB::table('consultas')
                            ->select(
                                    'paises.id', 
                                    'paises.nombre', 
                                    DB::raw('count(paises.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                             ->where(function ($query)  use ($buscar){
                               $query->orWhere('consultas.autor', 'like', '%'.$buscar.'%')        
                                ->orWhere('consultas.titulo', 'like', '%'.$buscar.'%')        
                                ->orWhere('consultas.sintesis', 'like', '%'.$buscar.'%')        
                                ->orWhere('consultas.palabras_clave', 'like', '%'.$buscar.'%')        
                                ->orWhere('temas.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('paises.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('institucion_pertenencia.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('institucion_procedencia.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('niveles.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('ejercicios.nombre', 'like', '%'.$buscar.'%');
                            })

                            ->when($ejercicio, function ($query, $ejercicio) {
                                return $query->where('ejercicios.id', $ejercicio);
                            })
                            
                            ->when($pais, function ($query, $pais) {
                                return $query->where('paises.id', $pais);
                            })

                            ->when($nivel, function ($query, $nivel) {
                                return $query->where('niveles.id', $nivel);
                            })

                            ->when($tema, function ($query, $tema) {
                                return $query->where('temas.id', $tema);
                            })

                            ->when($procedencia, function ($query, $procedencia) {
                                return $query->where('institucion_procedencia.id', $procedencia);
                            })

                            ->when($pertenencia, function ($query, $pertenencia) {
                                return $query->where('institucion_pertenencia.id', $pertenencia);
                            })


                            ->when($clave, function ($query, $clave) {
                                return $query->where('consultas.palabras_clave','like', '%'.$clave.'%');
                            })

                            ->when($autor, function ($query, $autor) {
                                return $query->where('consultas.autor', 'like', '%'.$autor.'%');
                            })

                            ->when($titulo, function ($query, $titulo) {
                                return $query->where('consultas.titulo', 'like', '%'.$titulo.'%');
                            })

                            ->groupBy('paises.id')
                            ->groupBy('paises.nombre')
                            ->get();

        $totalPertenencia = DB::table('consultas')
                            ->select(
                                    'institucion_pertenencia.id', 
                                    'institucion_pertenencia.nombre', 
                                    DB::raw('count(institucion_pertenencia.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                             ->where(function ($query)  use ($buscar){
                               $query->orWhere('consultas.autor', 'like', '%'.$buscar.'%')        
                                ->orWhere('consultas.titulo', 'like', '%'.$buscar.'%')        
                                ->orWhere('consultas.sintesis', 'like', '%'.$buscar.'%')        
                                ->orWhere('consultas.palabras_clave', 'like', '%'.$buscar.'%')        
                                ->orWhere('temas.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('paises.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('institucion_pertenencia.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('institucion_procedencia.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('niveles.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('ejercicios.nombre', 'like', '%'.$buscar.'%');
                            })

                            ->when($ejercicio, function ($query, $ejercicio) {
                                return $query->where('ejercicios.id', $ejercicio);
                            })
                            
                            ->when($pais, function ($query, $pais) {
                                return $query->where('paises.id', $pais);
                            })

                            ->when($nivel, function ($query, $nivel) {
                                return $query->where('niveles.id', $nivel);
                            })

                            ->when($tema, function ($query, $tema) {
                                return $query->where('temas.id', $tema);
                            })

                            ->when($procedencia, function ($query, $procedencia) {
                                return $query->where('institucion_procedencia.id', $procedencia);
                            })

                            ->when($pertenencia, function ($query, $pertenencia) {
                                return $query->where('institucion_pertenencia.id', $pertenencia);
                            })


                            ->when($clave, function ($query, $clave) {
                                return $query->where('consultas.palabras_clave','like', '%'.$clave.'%');
                            })

                            ->when($autor, function ($query, $autor) {
                                return $query->where('consultas.autor', 'like', '%'.$autor.'%');
                            })

                            ->when($titulo, function ($query, $titulo) {
                                return $query->where('consultas.titulo', 'like', '%'.$titulo.'%');
                            })

                            ->groupBy('institucion_pertenencia.id')
                            ->groupBy('institucion_pertenencia.nombre')
                            ->get();

        $totalProcedencia = DB::table('consultas')
                            ->select(
                                    'institucion_procedencia.id', 
                                    'institucion_procedencia.nombre', 
                                    DB::raw('count(institucion_procedencia.id) as total')
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                             ->where(function ($query)  use ($buscar){
                               $query->orWhere('consultas.autor', 'like', '%'.$buscar.'%')        
                                ->orWhere('consultas.titulo', 'like', '%'.$buscar.'%')        
                                ->orWhere('consultas.sintesis', 'like', '%'.$buscar.'%')        
                                ->orWhere('consultas.palabras_clave', 'like', '%'.$buscar.'%')        
                                ->orWhere('temas.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('paises.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('institucion_pertenencia.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('institucion_procedencia.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('niveles.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('ejercicios.nombre', 'like', '%'.$buscar.'%');
                            })

                            ->when($ejercicio, function ($query, $ejercicio) {
                                return $query->where('ejercicios.id', $ejercicio);
                            })
                            
                            ->when($pais, function ($query, $pais) {
                                return $query->where('paises.id', $pais);
                            })

                            ->when($nivel, function ($query, $nivel) {
                                return $query->where('niveles.id', $nivel);
                            })

                            ->when($tema, function ($query, $tema) {
                                return $query->where('temas.id', $tema);
                            })

                            ->when($procedencia, function ($query, $procedencia) {
                                return $query->where('institucion_procedencia.id', $procedencia);
                            })

                            ->when($pertenencia, function ($query, $pertenencia) {
                                return $query->where('institucion_pertenencia.id', $pertenencia);
                            })


                            ->when($clave, function ($query, $clave) {
                                return $query->where('consultas.palabras_clave','like', '%'.$clave.'%');
                            })

                            ->when($autor, function ($query, $autor) {
                                return $query->where('consultas.autor', 'like', '%'.$autor.'%');
                            })

                            ->when($titulo, function ($query, $titulo) {
                                return $query->where('consultas.titulo', 'like', '%'.$titulo.'%');
                            })

                            ->groupBy('institucion_procedencia.id')
                            ->groupBy('institucion_procedencia.nombre')
                            ->get();

        $consultas = DB::table('consultas')
                            ->select(
                                    'consultas.autor as autor', 
                                    'consultas.titulo as titulo',
                                    'consultas.sintesis as sintesis',
                                    'consultas.pdf as pdf',
                                    'consultas.palabras_clave as palabras_clave',
                                    'niveles.nombre as nivel',
                                    'temas.nombre as tema',
                                    'ejercicios.nombre as ejercicio',
                                    'paises.nombre as pais',
                                    'institucion_pertenencia.nombre as pertenencia',
                                    'institucion_procedencia.nombre as procedencia'
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
                                    "ejercicios",
                                    'consultas.id_ejercicio',
                                    '=',
                                    'ejercicios.id')
                            ->Join(
                                    "temas",
                                    'consultas.id_tema',
                                    '=',
                                    'temas.id')
                            ->Join(
                                    "paises",
                                    'consultas.id_pais',
                                    '=',
                                    'paises.id')
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
                            ->where('temas.estatus','1')
                            ->where('consultas.estatus','1')
                            ->where('ejercicios.estatus','1')
                            ->where('niveles.estatus','1')
                            ->where('paises.estatus','1')
                            ->where('institucion_pertenencia.estatus','1')
                            ->where('institucion_procedencia.estatus','1')

                             ->where(function ($query)  use ($buscar){
                               $query->orWhere('consultas.autor', 'like', '%'.$buscar.'%')        
                                ->orWhere('consultas.titulo', 'like', '%'.$buscar.'%')        
                                ->orWhere('consultas.sintesis', 'like', '%'.$buscar.'%')        
                                ->orWhere('consultas.palabras_clave', 'like', '%'.$buscar.'%')        
                                ->orWhere('temas.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('paises.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('institucion_pertenencia.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('institucion_procedencia.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('niveles.nombre', 'like', '%'.$buscar.'%')        
                                ->orWhere('ejercicios.nombre', 'like', '%'.$buscar.'%');
                            })

                            ->when($ejercicio, function ($query, $ejercicio) {
                                return $query->where('ejercicios.id', $ejercicio);
                            })
                            
                            ->when($pais, function ($query, $pais) {
                                return $query->where('paises.id', $pais);
                            })

                            ->when($nivel, function ($query, $nivel) {
                                return $query->where('niveles.id', $nivel);
                            })

                            ->when($tema, function ($query, $tema) {
                                return $query->where('temas.id', $tema);
                            })

                            ->when($procedencia, function ($query, $procedencia) {
                                return $query->where('institucion_procedencia.id', $procedencia);
                            })

                            ->when($pertenencia, function ($query, $pertenencia) {
                                return $query->where('institucion_pertenencia.id', $pertenencia);
                            })


                            ->when($clave, function ($query, $clave) {
                                return $query->where('consultas.palabras_clave','like', '%'.$clave.'%');
                            })

                            ->when($autor, function ($query, $autor) {
                                return $query->where('consultas.autor', 'like', '%'.$autor.'%');
                            })

                            ->when($titulo, function ($query, $titulo) {
                                return $query->where('consultas.titulo', 'like', '%'.$titulo.'%');
                            })
                            ->paginate(10);

        return view('resultados')->with([
                                        'niveles' => $niveles,
                                        'actual' => $diaActual,                                         
                                        'ajustes' => $ajustes,
                                        'totalEjercicio' => $totalEjercicio,
                                        'totalNivel' => $totalNivel,
                                        'totalTema' => $totalTema,
                                        'totalPais' => $totalPais,
                                        'totalPertenencia' => $totalPertenencia,
                                        'totalProcedencia' => $totalProcedencia,                                    
                                        'consultas' => $consultas,    

                                        'request' => $buscar,
                                        'nivel' => $nivel,
                                        'ejercicio' => $ejercicio,
                                        'tema' => $tema,
                                        'pais' => $pais,
                                        'procedencia' => $procedencia,
                                        'pertenencia' => $pertenencia,
                                        'palabras' => $clave,
                                        'autor' => $autor,                                
                                        'titulo' => $titulo,                                
                                    ]);
    }

}
