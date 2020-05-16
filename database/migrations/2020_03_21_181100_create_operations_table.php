<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->bigIncrements('operation_id');
            $table->integer('biens');
            $table->string('clients');
            $table->integer('caution');
            $table->integer('commission');
            $table->integer('taxes')->nullable();
            $table->integer('durée')->nullable();
            $table->string('dernierelevé')->nullable();
            $table->integer('montantPaye');
            $table->date('dateEntre');
            $table->string('piece')->nullable();
            $table->string('commentaire')->nullable();
            $table->string('ref');
            $table->string('statut')->default('louer');
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
        Schema::dropIfExists('operations');
    }
}
