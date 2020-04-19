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
            $table->integer('taxes');
            $table->integer('durée');
            $table->integer('dernierelevé');
            $table->integer('montantPaye');
            $table->date('dateEntre');
            $table->integer('ref');
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
