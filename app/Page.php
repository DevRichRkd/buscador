<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Page extends Model {

   public static function insertData($data){
      $value = DB::table('informacion')->where('clave_de_control', $data['clave_de_control'])->get();
      if($value->count() == 0){
         DB::table('informacion')->insert($data);
      }
   }

}
