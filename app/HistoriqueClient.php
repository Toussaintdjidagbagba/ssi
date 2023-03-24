<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoriqueClient extends Model
{
    // 
    protected $fillable = ['libelle', 'user_action', 'statut'];

    public static function saveHistorique($libelle, $user ){
        $id = HistoriqueClient::create([
            "libelle" => $libelle,
            "user_action" => $user
        ]);
        return $id;
    }
}
