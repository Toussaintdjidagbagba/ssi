<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    //
    protected $fillable = ['path', 'image', 'date', 'lieu', 'heure', 'description', 'id_user'];
}
