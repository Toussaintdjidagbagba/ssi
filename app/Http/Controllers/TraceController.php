<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trace;

class TraceController extends Controller
{
    //
    public function getlist() 
    {
        $list = Trace::orderBy('codeTrace', "DESC")->paginate(100);            
        return view('traces.listtrace', compact('list'));
    }

    public static function setTrace($contenu , $user)
    {
        $add = new Trace();
        $add->action = $user;
        $add->contenu = $contenu;
        $add->save();
        return 0;
    }
}
