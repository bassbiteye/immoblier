<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom', 'prenom', 'adresse','tel', 'profession','cellulaire', 'nationalite','type'
    ];

}
