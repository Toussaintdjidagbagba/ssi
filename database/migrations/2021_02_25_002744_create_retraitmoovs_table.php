<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetraitmoovsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retraitmoovs', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->double('montant')->nullable();
			$table->string('intitule')->nullable();
			$table->string('numero')->nullable();
			$table->string('statut')->nullable();
			$table->string('datevalider')->nullable();
			$table->string('id_user')->nullable();
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
        Schema::dropIfExists('retraitmoovs');
    }
}
