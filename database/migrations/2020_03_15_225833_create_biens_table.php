<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('biens', function (Blueprint $table) {
            $table->bigIncrements('bien_id');
            $table->string('details');
            $table->string('prix');
            $table->integer('etat');
            $table->string('adresse');
            $table->string('bailleur');
            $table->string('solde')->nullable();
            $table->integer('type');
            $table->boolean('louer')->default(false);
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
        Schema::dropIfExists('biens');
    }
}
