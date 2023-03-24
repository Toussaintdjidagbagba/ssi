<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /** 
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('sexe')->nullable();
            $table->string('tel')->nullable();
            $table->string('compteactive')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('type');
            $table->string('codeunique')->nullable();
            $table->string('otp')->nullable();
            $table->string('nomuser')->nullable();
            $table->string('codeperso')->unique()->nullable();
            $table->string('compteavoir')->nullable();
            $table->string('parrain');
            $table->string('parrainindirect')->nullable();
            $table->unsignedBigInteger('moyendepayement')->nullable();

            $table->foreign('moyendepayement')->references('id')->on('moyen_payements')->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            array(
                'nom' => 'Administrateur',
                'prenom' => 'Admin', 
                'sexe' => 'Masculin', 
                'tel' => '+22961310573',
                'compteactive' => 'oui', 
                'email' => 'sasdimin@admin.com', 
                'password' => bcrypt('12345678'), 
                'type' => 'admin', 
                'codeunique' => '0000001', 
                'otp' => '1111111', 
                'nomuser' => 'Admin', 
                'compteavoir' => '10', 
                'parrain' => '0000000'

            ));

        
        DB::table('users')->insert(
            array(
                'nom' => 'Client',
                'prenom' => 'client', 
                'sexe' => 'Masculin', 
                'tel' => '+22961310523', 
                'compteactive' => 'oui',
                'email' => 'sasdclient@client.com', 
                'password' => bcrypt('123456789'), 
                'type' => 'client', 
                'codeunique' => '0000002', 
                'otp' => '1211111',
                'nomuser' => 'Client', 
                'compteavoir' => '11', 
                'parrain' => '0000000'

            ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
