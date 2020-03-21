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
        'nomComplet', 'adresse', 'telephone','telephone'
    ];
        /**
     * Get the biens that owns the comment.
     */
    public function biens()
    {
        return $this->belongsTo('App\Biens', 'foreign_key');
    }
}
