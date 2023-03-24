<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLongrichesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() 
    {
        Schema::create('longriches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('IdUser')->nullable();
            $table->string('NomUser')->nullable();
            $table->string('CodePersoUser')->nullable();
            $table->string('Nom')->nullable();
            $table->string('Prenom')->nullable();
            $table->string('EmailUser')->nullable();
            
            $table->string('Tel')->nullable();
            $table->double('MontantPayer')->nullable();
            $table->string('lien')->nullable();
            $table->string('pass')->nullable();
            
            $table->string('pseudo')->nullable();
            $table->string('pays')->nullable();
            $table->string('dateL')->nullable();
            
            $table->string('modereglement')->nullable();
            $table->string('libelle')->nullable();
            $table->string('reglementnum')->nullable();
            $table->string('daterecu')->nullable();
            $table->string('RefRecu')->nullable();
            $table->string('date')->nullable();
            $table->string('Email')->nullable();
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
        Schema::dropIfExists('longriches');
    }
}
