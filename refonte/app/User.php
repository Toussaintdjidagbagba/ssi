<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    //
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom', 'prenom', 'sexe', 'tel', 'compteactive', 'email', 'password', 'type', 'codeunique', 'otp', 'nomuser', 'codeperso', 'compteavoir', 
        'parrain', 'parrainindirect', 'moyendepayement','Pack', 'Approbation'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
