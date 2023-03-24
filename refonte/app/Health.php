<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Health extends Model
{
    // 
    protected $fillable = ['IdUser', 'NomUser', 'EmailUser', 'TelUser', 'CodePersoUser', 'Nom', 'Prenom', 'Email', 'Tel', 'pseudo', 'pays', 'dateH', 'MontantPayer', 'RefRecu', 'modereglement', 'libelle', 'lien', 'pass', 'daterecu', 'date', 'Statut'];
}
