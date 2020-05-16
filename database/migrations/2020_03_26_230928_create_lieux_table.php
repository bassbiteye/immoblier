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
            $table->string('etat')->nullable();
            $table->string('murs')->nullable();
            $table->string('sols')->nullable();
            $table->string('ouverture')->nullable();
            $table->string('circuit')->nullable();
            $table->string('divers')->nullable();
            $table->string('commentaire')->nullable();
            $table->string('plafonds')->nullable();
            $table->string('cuisine')->nullable();
            $table->string('salledebain')->nullable();
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
