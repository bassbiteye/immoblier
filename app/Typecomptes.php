<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Typecomptes extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'typecomptes_id','libelle'
    ];
       /**
     * Get the biens that owns the comment.
     */
    public function comptes()
    {
        return $this->belongsTo('App\Comptes', 'foreign_key');
    }
}
