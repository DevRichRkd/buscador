<?php

namespace App\Http\Controllers;

use Lang;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController{
    
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Obtenemos los permisos que tiene el usuario logueado
    public function obtenerPermisosPorRecurso($cadenaBuscada,$id_usuario){
    	//$this->permisos = $this->permisos($cadena_buscada, Auth::user()->id);
    	$permisos = $this->permisos($cadena_buscada, $id_usuario);
        $perm[] = $permisos;
        return $perm;
    }

    /*
     * Con esta función obtenemos los permiso que tiene asignado el usuario 
     * logueado
     */
    public function permisos($controlador,$id){
        $sql = DB::select('SELECT distinct
                                id_recursos,
                                R,
                                I,
                                U,
                                D,
                                SF,
                                DF
                            FROM
                                lista_control_accesos 
                                    left JOIN
                                recursos ON recursos.id = lista_control_accesos.id_recursos
                            where 
                                lista_control_accesos.id_users = '. $id .'
                                and recursos.nombre like ("'.$controlador.'%")'
                                );
         
        $permisos['R']  = '0';
        $permisos['I']  = '0';
        $permisos['U']  = '0';
        $permisos['D']  = '0';
        $permisos['SF'] = '0';
        $permisos['DF'] = '0';
        
        $R  = array();
        $I  = array();
        $U  = array();
        $D  = array();
        $SF = array();
        $DF = array();

        $dataR[]  = null;
        $dataI[]  = null;
        $dataU[]  = null;
        $dataD[]  = null;
        $dataSF[] = null;
        $dataDF[] = null;

        for ($i=0; $i < count($sql) ; $i++) { 
            $dataR[]  = $sql[$i]->R;
            $dataI[]  = $sql[$i]->I;
            $dataU[]  = $sql[$i]->U;
            $dataD[]  = $sql[$i]->D;
            $dataSF[] = $sql[$i]->SF;
            $dataDF[] = $sql[$i]->DF;
            
        }
        //Permisos de Lectura
        foreach ($dataR as $item) {
            if (!in_array($item, $R) and $item == 1){
                $permisos['R'] = $item;
            }
        }
        //Permisos para insertar
        foreach ($dataI as $item) {
            if (!in_array($item, $I) and $item == 1){
                $permisos['I'] = $item;
            }
        }
        //Permisos para actualizar
        foreach ($dataU as $item) {
            if (!in_array($item, $U) and $item == 1){
                $permisos['U'] = $item;
            }
        }
        //Permisos para Eliminar
        foreach ($dataD as $item) {
            if (!in_array($item, $D) and $item == 1){
                $permisos['D'] = $item;
            }         
        }
        //Permisos para Subir archivos
        foreach ($dataSF as $item) {
            if (!in_array($item, $SF) and $item == 1){
                $permisos['SF'] = $item;
            }         
        }
        //Permisos para descargar archivos
        foreach ($dataDF as $item) {
            if (!in_array($item, $DF) and $item == 1){
                $permisos['DF'] = $item;
            }         
        }

        return $permisos;
    }

    // Verificamos al borra algun elemento que no existan dependencias
    public function existenDependientes($columna,$id){
    	$tablas = DB::select('
                                SELECT TABLE_NAME,TABLE_SCHEMA
                                FROM INFORMATION_SCHEMA.COLUMNS 
                                WHERE COLUMN_NAME LIKE "%'.$columna.'%"
                                AND table_schema LIKE "%'.env('DB_DATABASE', 'forge').'%"
                            ');

        $existe = array();

        for ($i=0; $i < count($tablas); $i++) { 
            //echo $tablas[$i]->TABLE_NAME."<br>";

            $tabla = DB::table($tablas[$i]->TABLE_NAME)
                            ->where($columna,"=",$id)
                            ->count();

            //echo $tablas[$i]->TABLE_NAME.": ".$tabla."<br>";

            if($tabla >= 1){
                array_push($existe, $tablas[$i]->TABLE_NAME);
            } 
        }
        return $existe;
    }
}
