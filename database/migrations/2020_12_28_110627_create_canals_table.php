<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCanalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('IdUser')->nullable();
            $table->string('NomUser')->nullable();
            $table->string('EmailUser')->nullable();
            $table->string('TelUser')->nullable();
            $table->string('CodePersoUser')->nullable();
            
            $table->string('Nom')->nullable();
            $table->string('Prenom')->nullable();
            $table->string('Numerocarte')->nullable();
            $table->string('Choisirformule')->nullable(); 
            $table->string('Dureenmois')->nullable();

            $table->double('Montant')->nullable();
            $table->double('MontantPayer')->nullable();
            $table->string('dateespire')->nullable();
            $table->double('solderestant')->nullable();
            $table->string('modereglement')->nullable();
            $table->string('libelle')->nullable();
            $table->string('reglementnum')->nullable();
            $table->string('daterecu')->nullable();
            $table->string('RefRecu')->nullable();
            $table->string('date')->nullable();
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
        Schema::dropIfExists('canals');
    }
}
