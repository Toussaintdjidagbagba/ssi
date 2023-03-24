<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParametreController extends Controller
{
    
    public function dash_user()
    {
        return view('admin.dash_utilisateur');
    }
}
