<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Canal extends Model
{
    //
     protected $fillable = ['IdUser', 'NomUser', 'EmailUser', 'TelUser', 'CodePersoUser', 'Nom', 'Prenom', 'Numerocarte', 'Choisirformule', 
     'Dureenmois', 'Montant', 'MontantPayer', 'dateespire', 'RefRecu', 'modereglement', 
     'libelle', 'solderestant', 'reglementnum', 'daterecu', 'date', 'Statut'];
}
