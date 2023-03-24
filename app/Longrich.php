<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Longrich extends Model
{
    // 
    protected $fillable = ['IdUser', 'NomUser', 'EmailUser', 'TelUser', 'CodePersoUser', 'Nom', 'Prenom', 'Email', 'Tel', 'pseudo', 'pays', 'dateL', 'MontantPayer', 'RefRecu', 'modereglement', 'libelle', 'lien', 'pass', 'daterecu', 'date', 'Statut'];
}
