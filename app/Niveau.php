<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    //
    protected $fillable = ['nombredefilleul', 'id_user', 'id_etape', 'PositionGauche', 'PositionDroite', 'id_equipe'];
}
