<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CorbeilleProvider extends ServiceProvider
{
    public static function restaurer($ref, $service){
        $table = CorbeilleProvider::tableService($service);
        
        return 1;
    }
    
    public function tableService($name){
        
    }
}
