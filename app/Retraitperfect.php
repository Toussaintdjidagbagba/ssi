<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retraitperfect extends Model
{
    //
	protected $fillable = ['montant', 'reff', 'intituler', 'lien', 'id_user', 'statut', 'datevalider'];
}
