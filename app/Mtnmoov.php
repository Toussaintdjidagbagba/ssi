<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mtnmoov extends Model
{
    // 
     protected $fillable = ['IdUser', 'NomUser', 'EmailUser', 'CodePersoUser', 'Tel', 'MontantPayer', 'libelle', 'type', 'Statut'];
}
