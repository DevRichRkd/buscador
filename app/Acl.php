<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acl extends Model
{
    protected $table = 'lista_control_accesos';

    protected $fillable = [
        "id_grupos",
        "id_users",
        "id_recursos",
        "R",
        "I",
        "U",
        "D",
        "SF",
        "DF",
    ];
}
