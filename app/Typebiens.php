<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Typebiens extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','libelle'
    ];
       /**
     * Get the biens that owns the comment.
     */
    public function biens()
    {
        return $this->belongsTo('App\Biens', 'foreign_key');
    }
}
