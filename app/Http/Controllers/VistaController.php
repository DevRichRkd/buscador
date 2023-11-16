<?php

namespace App\Http\Controllers;

use App\Informacion;
use Auth;
use Illuminate\Support\Facades\DB;


class Vistacontroller extends Controller{
    
    public function index(){

    }

    public function getTipoExpedienteById($id){

        //$expedientes = Informacion::where('id_expediente',$id)->get();
        $expedientes =  DB::table('informacion')
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
                    ->leftJoin(
                        "expedientes",
                        'informacion.id_expediente',
                        '=',
                        'expedientes.id')
                    ->leftJoin(
                        "anios",
                        'informacion.id_anio',
                        '=',
                        'anios.id')
                    ->leftJoin(
                        "entidades",
                        'informacion.id_entidad',
                        '=',
                        'entidades.id')
                    ->leftJoin(
                        "organismos",
                        'informacion.id_organismo',
                        '=',
                        'organismos.id')
                    ->leftJoin(
                        "materias",
                        'informacion.id_materia',
                        '=',
                        'materias.id')
                    ->leftJoin(
                        "criterios",
                        'informacion.id_criterio',
                        '=',
                        'criterios.id')
                    ->leftJoin(
                        "epocas",
                        'informacion.id_epoca',
                        '=',
                        'epocas.id')
                    ->leftJoin(
                        "criterios_secciones",
                        'informacion.id_criterio_seccion',
                        '=',
                        'criterios_secciones.id')
                    ->where('id_expediente',$id)
                    ->orderBy('informacion.id', 'Desc')
                    ->paginate(10);

        $idEntidad = 0;
        $idAnio  = 0;
        $idTipo  = 0;
        $idEpoca  =  0;
        $idMateria  =  0;
        $idSeccion  =  0;

        $sqlEntidades = "SELECT e.id, e.nombre, COUNT(e.id) AS total FROM entidades AS e, informacion AS i WHERE e.id = i.id_entidad AND i.id_expediente = $id GROUP BY id";
        $totalEntidades = DB::select($sqlEntidades);

        $sqlAnios = "SELECT a.id, a.nombre, COUNT(a.id) AS total FROM anios AS a, informacion AS i WHERE a.id = i.id_anio AND i.id_expediente = $id GROUP BY id";
        $totalAnios = DB::select($sqlAnios);

        $sqlCriterios = "SELECT c.id, c.nombre, COUNT(c.id) AS total FROM criterios AS c, informacion AS i WHERE c.id = i.id_criterio AND i.id_expediente = $id GROUP BY id";
        $totalCriterios = DB::select($sqlCriterios);

        $sqlEpocas = "SELECT e.id, e.nombre, COUNT(e.id) AS total FROM epocas AS e, informacion AS i WHERE e.id = i.id_epoca AND i.id_expediente = $id GROUP BY id";
        $totalEpocas = DB::select($sqlEpocas);

        $sqlMaterias = "SELECT m.id, m.nombre, COUNT(m.id) AS total FROM materias AS m, informacion AS i WHERE m.id = i.id_materia AND i.id_expediente = $id GROUP BY id";
        $totalMaterias = DB::select($sqlMaterias);

        return view('expedientes')->with([
                                        'expedientes' => $expedientes,
                                        'totalEntidades'=> $totalEntidades,
                                        'totalAnios'=> $totalAnios,
                                        'totalCriterios'=> $totalCriterios,
                                        'totalEpocas'=> $totalEpocas,
                                        'totalMaterias'=> $totalMaterias,
                                        
                                        'request' => 0,
                                        'idExpediente'=> $id,
                                        'idEntidad'=> $idEntidad,
                                        'idAnio'=> $idAnio,
                                        'idTipo'=> $idTipo,
                                        'idEpoca'=> $idEpoca,
                                        'idMateria'=> $idMateria,
                                        'idSeccion'=> $idSeccion,
                                    ]);
    }

    public function filters($buscar = 0,$expediente = 0, $entidad = 0, $anio = 0, $tipo = 0, $epoca = 0, $materia = 0, $seccion = 0){

        //$expedientes = Informacion::where('id_expediente',$expediente)
        $expedientes =  DB::table('informacion')
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
                    ->leftJoin(
                        "expedientes",
                        'informacion.id_expediente',
                        '=',
                        'expedientes.id')
                    ->leftJoin(
                        "anios",
                        'informacion.id_anio',
                        '=',
                        'anios.id')
                    ->leftJoin(
                        "entidades",
                        'informacion.id_entidad',
                        '=',
                        'entidades.id')
                    ->leftJoin(
                        "organismos",
                        'informacion.id_organismo',
                        '=',
                        'organismos.id')
                    ->leftJoin(
                        "materias",
                        'informacion.id_materia',
                        '=',
                        'materias.id')
                    ->leftJoin(
                        "criterios",
                        'informacion.id_criterio',
                        '=',
                        'criterios.id')
                    ->leftJoin(
                        "epocas",
                        'informacion.id_epoca',
                        '=',
                        'epocas.id')
                    ->leftJoin(
                        "criterios_secciones",
                        'informacion.id_criterio_seccion',
                        '=',
                        'criterios_secciones.id')
                    ->when($entidad, function ($query, $entidad){
                        return $query->where('informacion.id_entidad', $entidad);
                    })
                    ->when($anio, function ($query, $anio){
                        return $query->where('informacion.id_anio', $anio);
                    })
                    ->when($tipo, function ($query, $tipo){
                        return $query->where('informacion.id_criterio', $tipo);
                    })
                    ->when($epoca, function ($query, $epoca){
                        return $query->where('informacion.id_epoca', $epoca);
                    })
                    ->when($materia, function ($query, $materia){
                        return $query->where('informacion.id_materia', $materia);
                    })
                    ->when($seccion, function ($query, $seccion){
                        return $query->where('informacion.id_criterio_seccion', $seccion);
                    })
                    ->where('informacion.id_expediente',$expediente)
                                ->orderBy('informacion.id', 'Desc')
                                ->paginate(10);

        

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
        if ($seccion > 0){
            $sqlEntidades .= " AND i.id_criterio_seccion = $seccion";
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
        if ($seccion > 0){
            $sqlAnios .= " AND i.id_criterio_seccion = $seccion";
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
        if ($seccion > 0){
            $sqlCriterios .= " AND i.id_criterio_seccion = $seccion";
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
        if ($seccion > 0){
            $sqlEpocas .= " AND i.id_criterio_seccion = $seccion";
        }
        $sqlEpocas .= " GROUP BY id";
        $totalEpocas = DB::select($sqlEpocas);

        $sqlMaterias = "SELECT m.id, m.nombre, COUNT(m.id) AS total FROM materias AS m, informacion AS i WHERE m.id = i.id_materia AND i.id_expediente = $expediente";
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
        if ($seccion > 0){
            $sqlMaterias .= " AND i.id_criterio_seccion = $seccion";
        }
        $sqlMaterias .= " GROUP BY id";
        $totalMaterias = DB::select($sqlMaterias);

        return view('expedientes')->with([
                                    'expedientes' => $expedientes,
                                    'totalEntidades'=> $totalEntidades,
                                    'totalAnios'=> $totalAnios,
                                    'totalCriterios'=> $totalCriterios,
                                    'totalEpocas'=> $totalEpocas,
                                    'totalMaterias'=> $totalMaterias,
                                    
                                    'request' => $buscar,
                                    'idExpediente'=> $expediente,
                                    'idEntidad'=> $entidad,
                                    'idAnio'=> $anio,
                                    'idTipo'=> $tipo,
                                    'idEpoca'=> $epoca,
                                    'idMateria'=> $materia,
                                    'idSeccion'=> $seccion,

        ]);
    }

    public function getExpedientesByClave($clave, $id)
    {
        # Validamos que el usuario logueado este activo. En caso el usuario no este activo se manda al home
        if (!Auth::guest()){
            if(Auth::user()->estatus != 1){
                return redirect('/home');
            }
        }
        # Fin de validación usuario activo
        $expedientes = Informacion::where('clave_de_control','like','%' .$clave.'%')
        ->when($id, function ($query, $id){
            return $query->where('id_expediente', $id);
        })
        ->get();
       
        return $expedientes;

    }

    public function getExpedienteById($id, $idInfo){

       /* $expedientes = Informacion::where('id_expediente',$id)
        ->when($idInfo, function ($query, $idInfo){
            return $query->where('id', $idInfo);
        })
        ->get();*/
        $expedientes =  DB::table('informacion')
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
                    ->leftJoin(
                        "expedientes",
                        'informacion.id_expediente',
                        '=',
                        'expedientes.id')
                    ->leftJoin(
                        "anios",
                        'informacion.id_anio',
                        '=',
                        'anios.id')
                    ->leftJoin(
                        "entidades",
                        'informacion.id_entidad',
                        '=',
                        'entidades.id')
                    ->leftJoin(
                        "organismos",
                        'informacion.id_organismo',
                        '=',
                        'organismos.id')
                    ->leftJoin(
                        "materias",
                        'informacion.id_materia',
                        '=',
                        'materias.id')
                    ->leftJoin(
                        "criterios",
                        'informacion.id_criterio',
                        '=',
                        'criterios.id')
                    ->leftJoin(
                        "epocas",
                        'informacion.id_epoca',
                        '=',
                        'epocas.id')
                    ->leftJoin(
                        "criterios_secciones",
                        'informacion.id_criterio_seccion',
                        '=',
                        'criterios_secciones.id')
                    ->where('id_expediente',$id)
                    ->when($idInfo, function ($query, $idInfo){
                        return $query->where('informacion.id', $idInfo);
                    })
                    ->orderBy('informacion.id', 'Desc')
                    ->paginate(25);
        
        $idEntidad = 0;
        $idAnio  = 0;
        $idTipo  = 0;
        $idEpoca  =  0;
        $idMateria  =  0;
        $idSeccion  =  0;

        $sqlEntidades = "SELECT e.id, e.nombre, COUNT(e.id) AS total FROM entidades AS e, informacion AS i WHERE e.id = i.id_entidad AND i.id_expediente = $id AND i.id = $idInfo GROUP BY id";
        $totalEntidades = DB::select($sqlEntidades);

        $sqlAnios = "SELECT a.id, a.nombre, COUNT(a.id) AS total FROM anios AS a, informacion AS i WHERE a.id = i.id_anio AND i.id_expediente = $id AND i.id = $idInfo GROUP BY id";
        $totalAnios = DB::select($sqlAnios);

        $sqlCriterios = "SELECT c.id, c.nombre, COUNT(c.id) AS total FROM criterios AS c, informacion AS i WHERE c.id = i.id_criterio AND i.id_expediente = $id AND i.id = $idInfo GROUP BY id";
        $totalCriterios = DB::select($sqlCriterios);

        $sqlEpocas = "SELECT e.id, e.nombre, COUNT(e.id) AS total FROM epocas AS e, informacion AS i WHERE e.id = i.id_epoca AND i.id_expediente = $id AND i.id = $idInfo GROUP BY id";
        $totalEpocas = DB::select($sqlEpocas);

        $sqlMaterias = "SELECT m.id, m.nombre, COUNT(m.id) AS total FROM materias AS m, informacion AS i WHERE m.id = i.id_materia AND i.id_expediente = $id AND i.id = $idInfo GROUP BY id";
        $totalMaterias = DB::select($sqlMaterias);

        return view('expedientes')->with([
                                        'expedientes' => $expedientes,
                                        'totalEntidades'=> $totalEntidades,
                                        'totalAnios'=> $totalAnios,
                                        'totalCriterios'=> $totalCriterios,
                                        'totalEpocas'=> $totalEpocas,
                                        'totalMaterias'=> $totalMaterias,
                                        
                                        'request' => 0,
                                        'idExpediente'=> $id,
                                        'idEntidad'=> $idEntidad,
                                        'idAnio'=> $idAnio,
                                        'idTipo'=> $idTipo,
                                        'idEpoca'=> $idEpoca,
                                        'idMateria'=> $idMateria,
                                        'idSeccion'=> $idSeccion,
                                    ]);
    }
}
