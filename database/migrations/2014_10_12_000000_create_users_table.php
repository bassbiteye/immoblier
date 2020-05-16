<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('adresse')->nullable();
            $table->string('telephone')->nullable();
            $table->string('password');
            $table->string('sexe')->nullable();
            $table->string('nombreBien')->nullable();
            $table->string('profession')->nullable();
            $table->string('nationalite')->nullable();
            $table->integer('solde')->nullable();
            $table->string('numero')->nullable()->unique();
            $table->string('bp')->nullable();
            $table->string('type')->default('admin');
            $table->string('photo')->default('profile.png');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
