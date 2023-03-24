<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retraitgram extends Model
{
    //
	protected $fillable = ['montant', 'reff', 'nom', 'prenom', 'adresse', 'ville', 'pays', 'motif', 'id_user', 'statut', 'datevalider'];
}
