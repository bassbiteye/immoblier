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
        'client_id','nom', 'prenom','tel', 'profession','sexe', 'nationalite','adresse','type'
    ];
     /**
     * Get the Typecliens for the blog post.
     */
    public function type()
    {
        return $this->hasMany('App\Typecliens');
    }
      /**
     * Get the operations that owns the comment.
     */
    public function operations()
    {
        return $this->belongsTo('App\Operations', 'foreign_key');
    }
}
