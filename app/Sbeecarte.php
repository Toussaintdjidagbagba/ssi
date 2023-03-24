<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sbeecarte extends Model
{
    // 
    protected $fillable = ['IdUser', 'NomUser', 'EmailUser', 'TelUser', 'CodePersoUser', 'Nom', 'Prenom', 'Email', 'WhatsApp', 'Police', 'Montant', 'MontantPayer', 'FraisSSI', 'RefRecu', 'modereglement', 'libelle', 'solderestant', 'reglementnum', 'daterecu', 'CodeSTS', 'Kwh', 'Entretien', 'date', 'Statut'];
}
