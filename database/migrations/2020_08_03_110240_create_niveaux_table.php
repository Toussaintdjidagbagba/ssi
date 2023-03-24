<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNiveauxTable extends Migration
{
    /**
     * Run the migrations. 
     *
     * @return void
     */
    public function up()
    {
        Schema::create('niveaux', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('nombredefilleul');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_etape');
            $table->foreign('id_etape')->references('id')->on('etapes')->onDelete('cascade');
            $table->string('PositionGauche');
            $table->string('PositionDroite');
            //$table->unsignedBigInteger('id_position');
            //$table->foreign('id_position')->references('id')->on('positions')->onDelete('cascade');
            $table->unsignedBigInteger('id_equipe');
            $table->foreign('id_equipe')->references('id')->on('equipes')->onDelete('cascade');
            
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
        Schema::dropIfExists('niveaux');
    }
}
