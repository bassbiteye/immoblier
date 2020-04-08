<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lieuxes extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lieux_id','etat', 'murs','sols', 'ouverture','circuit','divers'
    ];

      /**
     * Get the biens that owns the comment.
     */
    public function biens()
    {
        return $this->belongsTo('App\Biens', 'foreign_key');
    }
}
