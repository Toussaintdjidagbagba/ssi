<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    //
    protected $fillable = ['libelle', 'code', 'user_action', 'statut'];

    public static function saveHistorique( $type, $libelle, $user ){
        $id = Historique::create([
            "libelle" => $libelle,
            "code" => $type,
            "user_action" => $user
        ]);
        return $id;
    }
}
