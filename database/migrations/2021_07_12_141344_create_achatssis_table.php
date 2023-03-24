<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAchatssisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achatssis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codeperso')->nullable();
            $table->double('montant')->nullable();
            $table->string('referencepaye')->nullable();
            $table->string('libellecompte')->nullable();
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
        Schema::dropIfExists('achatssis');
    }
}
