<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLieuxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lieuxes', function (Blueprint $table) {
            $table->bigIncrements('lieux_id');
            $table->string('biens');
            $table->string('etat');
            $table->string('murs');
            $table->string('sols');
            $table->string('ouverture');
            $table->string('circuit');
            $table->string('divers');
            $table->string('commentaire');
            $table->string('plafonds');
            $table->string('cuisine');
            $table->string('salledebain');

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
        Schema::dropIfExists('lieux');
    }
}
