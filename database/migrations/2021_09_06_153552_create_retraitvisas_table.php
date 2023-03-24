<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetraitvisasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retraitvisas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codeperso')->nullable();
            $table->double('mont')->nullable();
            $table->string('intitule')->nullable();
            $table->string('nom')->nullable();
            $table->string('idcarte')->nullable();
            $table->string('statut')->default("1");
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
        Schema::dropIfExists('retraitvisas');
    }
}
