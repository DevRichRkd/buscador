<?php

namespace App\Http\Controllers;


use Auth;
use Session;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller{

    private string $cadenaBuscada;
    public function __construct(){
        $this->middleware('auth');
        $this->cadenaBuscada = "loadcsv";
    }

  public function index(){
    # Validamos que el usuario logueado este activo. En caso el usuario no este activo se manda al home
    if (!Auth::guest()){
        if(Auth::user()->estatus != 1){
           return redirect('home');
        }
    }
    # Fin de validación usuario activo

    return view('/loadcsv/loadform');
  }
  
  public function uploadFile(Request $request){

    if ($request->input('submit') != null ){
      $file = $request->file('file');

      // File Details 
      $filename = $file->getClientOriginalName();
      $extension = $file->getClientOriginalExtension();
      $tempPath = $file->getRealPath();
      $fileSize = $file->getSize();
      $mimeType = $file->getMimeType();

      // Valid File Extensions
      $valid_extension = array("csv");

      // 2MB in Bytes
      $maxFileSize = 2097152; 

      // Check file extension
      if(in_array(strtolower($extension),$valid_extension)){
        
        // Check file size
        if($fileSize <= $maxFileSize){
          
          // File upload location
          $location = 'uploads';

          // Upload file
          $file->move($location,$filename);

          // Import CSV to Database
          $filepath = public_path($location."/".$filename);

          // Reading file
          $file = fopen($filepath,"r");

          $importData_arr = array();
          $importData = array();
          $i = 0;
          while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
             $num = count($filedata );
             
             for ($c=0; $c < $num; $c++) {
                $importData_arr[$i][] = $filedata [$c];
             }
             $i++;
          }
          fclose($file);
          // Insert to MySQL database
          unset ($importData_arr[0]);
          $errors = [];
          foreach($importData_arr as $key => $importData){
            //dd($importData);
            $idExpediente = '';
            $idAnio = '';
            $idEntidad = '';
            $idOrganismo = '';
            $idMateria = '';
            $idCriterio = '';
            $idEpoca = '';
            $idCriterioSeccion = '';
            
            if(empty($importData[0])){
              $mnsErr =  'La columna Tipo de Expediente no puede estar vacia, fila: '. ($key + 1);
              $errors[] = $mnsErr;
            continue;
            }else{
              $expediente = DB::table('expedientes')->where('nombre', $importData[0])->get();
              if($expediente->count() > 0){
                $idExpediente = $expediente->first()->id;
              }else{
                $mnsErr = 'Expediente no encontrado en la base de datos, fila: '. ($key + 1);
                $errors[] = $mnsErr;
                continue;
              }
            }

            if(empty($importData[1])){
              $errors[] = 'La columna Rubro no puede estar vacia, fila: '. ($key + 1);
              continue;
            }

            if(empty($importData[2])){
              $errors[] = 'La columna Palabras Clave no puede estar vacia, fila: '. ($key + 1);
              continue;
            }

            if(empty($importData[3])){
              $errors[] = 'La columna Clave de control estar vacia, fila: '. ($key + 1);
              continue;
            }

            if(empty($importData[4])){
              $errors[] = 'La columna de Año no puede estar vacia, fila: '. ($key + 1);
              continue;
            }else{
              $anio = DB::table('anios')->where('nombre', $importData[4])->get();
              if($anio->count() > 0){
                $idAnio = $anio->first()->id;
              }else{
                $errors[] = 'Año no encontrado en la base de datos, fila: '. ($key + 1);
                continue;
              }
            }

            if(empty($importData[5])){
              $errors[] = 'La columna Entidad no puede estar vacia, fila: '. ($key + 1);
              continue;
            }else{
              $entidad = DB::table('entidades')->where('nombre', $importData[5])->get();
              if($entidad->count() > 0){
                $idEntidad = $entidad->first()->id;
              }else{
                $errors[] = 'Entidad no encontrada en la base de datos, fila: '. ($key + 1);
                continue;
              }
            }
            
            if(empty($importData[6])){
              $errors[] = 'La columna Organismo no puede estar vacia, fila: '. ($key + 1);
              continue;
            }else{
              $organismo = DB::table('organismos')->where('nombre', $importData[6])->get();
              if($organismo->count() > 0){
                $idOrganismo = $organismo->first()->id;
              }else{
                $errors[] = 'Organismo no se encuentra en la base de datos, fila: '. ($key + 1);
                continue;
              }
            }
            
            if(empty($importData[7])){
              $errors[] = 'La columna Materia no puede estar vacia, fila: '. ($key + 1);
              continue;
            }else{
              $materia = DB::table('materias')->where('nombre', $importData[7])->get();
              if($materia->count() > 0){
                $idMateria = $materia->first()->id;
              }else{
                $errors[] = 'Materia no encontrada en la base de datos, fila: '. ($key + 1);
                continue;
              }
            }

            if(empty($importData[8])){
              $errors[] = 'La columna Vinculo electronico no puede estar vacio, fila: '. ($key + 1);
              continue;
            }

            if($idExpediente == '1'){
              if(empty($importData[9])){
                $errors[] = 'La columna Precedentes no puede estar vacia, fila: '. ($key + 1);
                continue;
              }

              if(empty($importData[10])){
                $errors[] = 'La columna Tipos de criterio no puede estar vacia, fila: '.($key + 1);
                continue;
              }else{
                $criterio = DB::table('criterios')->where('nombre', $importData[10])->get();
                if($criterio->count() > 0){
                  $idCriterio = $criterio->first()->id;
                }else{
                  $errors[] = 'Tipo de criterio no encontrado en la base de datos, fila: '. ($key + 1);
                  continue;
                }
              }
              
              if(empty($importData[11])){
                $errors[] = 'La columna Epoca no puede estar vacia, fila: '. ($key + 1);
                continue;
              }else{
                $epoca = DB::table('epocas')->where('nombre', $importData[11])->get();
                if($epoca->count() > 0){
                  $idEpoca = $epoca->first()->id;
                }else{
                  $errors[] = 'Epoca no encontrada en la base de datos, fila: '. ($key + 1);
                  continue;
                }
              }
              
              if(empty($importData[12])){
                $errors[] = 'La columna de Tipo de criterio no puede estar vacia, fila: '. ($key + 1);
                continue;
              }else{
                $criterio_seccion = DB::table('criterios_secciones')->where('nombre', $importData[12])->get();
                if($criterio_seccion->count() > 0){
                  $idCriterioSeccion = $criterio_seccion->first()->id;
                }else{
                  $errors[] = 'Tipo de criterio no encontrado en la base de datos, fila: '. ($key + 1);
                  continue;
                }
              }
            }
            
            if( $idExpediente == 2){
              if(empty($importData[13])){
                $errors[] = 'La columna Solicitud no puede estar vacia, fila: '. ($key + 1);
                continue;
              }

              if(empty($importData[14])){
                $errors[] = 'La columna Respuesta no puede estar vacia, fila: '. ($key + 1);
                continue;
              }

              if(empty($importData[15])){
                $errors[] = 'La columna Agravio no puede estar vacia, fila: '. ($key + 1);
                continue;
              }

              if(empty($importData[16])){
                $errors[] = 'La columna Relevancia de la resolucion no puede estar vacia, fila: '. ($key + 1);
                continue;
              }
            }

            $insertData = array(
              "id_expediente"=>$idExpediente,
              "rubro"=>$importData[1],
              "palabras_clave"=>$importData[2],
              "clave_de_control"=>$importData[3],
              "id_anio"=>$idAnio,
              "id_entidad"=>$idEntidad,
              "id_organismo"=>$idOrganismo,
              "id_materia"=>$idMateria,
              "vinculo"=>$importData[8],
              "presedentes"=>$importData[9],
              "id_criterio"=>$idCriterio,
              "id_epoca"=>$idEpoca,
              "id_criterio_seccion"=>$idCriterioSeccion,
              "solicitud"=>$importData[13],
              "respuesta"=>$importData[14],
              "agravio"=>$importData[15],
              "relevancia"=>$importData[16]
            );
            Page::insertData($insertData);
          }
          Session::flash('message','Lectura completa.');
        }else{
          Session::flash('message','Archivo demasiado grande. Debe pesar menos de 2MB.');
        }

      }else{
         Session::flash('message','Extension invalida.');
      }

    }
    // Redirect to index
    if($errors){
      Session::flash('message','Lectura completa.');
      return view('/loadcsv/loadform')->with([
        'errors' => $errors,
    ]);
    }else{
      return view('/loadcsv/loadform');
    }
  }
}