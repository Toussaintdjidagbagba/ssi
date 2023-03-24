<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sbeeconventiel extends Model
{
    // 
    protected $fillable = ['IdUser', 'NomUser', 'EmailUser', 'TelUser', 'CodePersoUser', 'Nom', 'Prenom', 'Email', 'WhatsApp', 'Police', 'Presentation', 'Montant', 'MontantPayer', 'FraisSSI', 'RefRecu', 'modereglement', 'libelle', 'solderestant', 'reglementnum', 'daterecu', 'periode', 'date', 'Statut'];
}
