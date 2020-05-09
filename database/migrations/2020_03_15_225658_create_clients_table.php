<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('client_id');
            $table->string('nom');
            $table->string('prenom');
            $table->string('tel')->unique();
            $table->string('sexe');
            $table->string('adresse');
            $table->string('profession')->nullable();
            $table->string('nationalite');
            $table->string('commentaire')->nullable();
            $table->string('entreprise')->nullable();
            $table->integer('solde')->nullable();
            $table->string('numero')->nullable()->unique();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
