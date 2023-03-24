<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemadminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('systemadmins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codeparrainadmin')->nullable();
            $table->double('compteavoirrecu')->nullable();
            $table->double('compteavoirsortant')->nullable();
            $table->integer('pourcentagefilleulespece')->nullable();
            $table->integer('pourcentagefilleulvirtuel')->nullable();
            $table->unsignedBigInteger('id_AdminPrincipal')->nullable();
            $table->string('Admin')->nullable();
            $table->string('Monnaie');
            $table->foreign('id_AdminPrincipal')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('systemadmins');
    }
}
