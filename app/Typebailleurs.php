<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Typebailleurs extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'typebailleurs_id','libelle'
    ];
       /**
     * Get the bailleurs that owns the comment.
     */
    public function bailleur()
    {
        return $this->belongsTo('App\User', 'foreign_key');
    }


    
}
