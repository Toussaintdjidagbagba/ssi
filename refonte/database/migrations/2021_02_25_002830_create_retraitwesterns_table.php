<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetraitwesternsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retraitwesterns', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->double('montant')->nullable();
			$table->string('nom')->nullable();
			$table->string('prenom')->nullable();
			$table->string('adresse')->nullable();
			$table->string('ville')->nullable();
			$table->string('pays')->nullable();
			$table->string('motif')->nullable();
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
        Schema::dropIfExists('retraitwesterns');
    }
}
