<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSonebsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('sonebs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('IdUser')->nullable();
            $table->string('NomUser')->nullable();
            $table->string('EmailUser')->nullable();
            $table->string('TelUser')->nullable();
            $table->string('CodePersoUser')->nullable();
            $table->string('Nom')->nullable();
            $table->string('Prenom')->nullable();
            $table->string('WhatsApp')->nullable();
            $table->string('Police')->nullable();
            $table->string('Presentation')->nullable();
            $table->double('Montant')->nullable();
            $table->double('MontantPayer')->nullable();
            $table->double('FraisSSI')->nullable();
            $table->double('solderestant')->nullable();
            $table->string('modereglement')->nullable();
            $table->string('libelle')->nullable();
            $table->string('reglementnum')->nullable();
            $table->string('daterecu')->nullable();
            $table->string('RefRecu')->nullable();
            $table->string('periode')->nullable();
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
        Schema::dropIfExists('sonebs');
    }
}
