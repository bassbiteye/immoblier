<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Biens extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'details', 'prix', 'proprietaire','type'
    ];
}
