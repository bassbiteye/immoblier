<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bailleurs extends Model
{
  
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nomComplet', 'adresse', 'telephone','compte'
    ];
}
