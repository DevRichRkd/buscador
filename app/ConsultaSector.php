<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultaSector extends Model{
    protected $table = 'consulta_sector';

     protected $fillable = [
        "id_consulta",
        "id_sector",
    ];
}
