<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMtnmoovsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mtnmoovs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('IdUser')->nullable();
            $table->string('NomUser')->nullable();
            $table->string('EmailUser')->nullable();
            $table->string('CodePersoUser')->nullable();
            $table->string('Tel')->nullable();
            $table->double('MontantPayer')->nullable();
            $table->string('libelle')->nullable();
            $table->string('Statut')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mtnmoovs');
    }
}
