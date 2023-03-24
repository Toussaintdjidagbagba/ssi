<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retraittrust extends Model
{
    //
	protected $fillable = ['montant', 'reff', 'intituler', 'lien', 'id_user', 'statut', 'datevalider'];
}
