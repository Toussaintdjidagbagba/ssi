<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articlepdf extends Model
{
    //
    protected $fillable = ['path', 'image', 'titre', 'prix', 'description'];
}
