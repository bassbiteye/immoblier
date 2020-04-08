<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Typeclients extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'typeclients_id','libelle'
    ];
       /**
     * Get the biens that owns the comment.
     */
    public function biens()
    {
        return $this->belongsTo('App\Clients', 'foreign_key');
    }
}
