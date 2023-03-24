<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retraitmoov extends Model
{
    //
	protected $fillable = ['montant', 'reff', 'numero', 'intitule', 'id_user', 'statut', 'datevalider'];
}
