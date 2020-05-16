<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaiementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->bigIncrements('paiement_id');
            $table->integer('operations');
            $table->integer('commission');
            $table->integer('taxes')->nullable();
            $table->integer('montant');
            $table->string('date');
            $table->string('commentaire')->nullable();
            $table->string('ref');
            $table->string('statutPaiement')->default('payer');
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
        Schema::dropIfExists('paiements');
    }
}
