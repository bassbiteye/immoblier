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
        'details', 'prix', 'bailleur','type','etat','adresse','bien_id'
    ];
        /**
     * Get the Typebiens for the blog post.
     */
    public function type()
    {
        return $this->hasMany('App\Typebiens');
    }
     /**
     * Get the Typebiens for the blog post.
     */
    public function etat()
    {
        return $this->hasMany('App\Typeetats');
    }
       /**
     * Get the Bailleurs for the blog post.
     */
    public function bailleur()
    {
        return $this->hasMany('App\User');
    }
         /**
     * Get the equipements for the blog post.
     */
    public function equipements()
    {
        return $this->hasMany('App\Equipement');
    }
         /**
     * Get the Lieux for the blog post.
     */
    public function Lieux()
    {
        return $this->hasMany('App\Lieux');
    }
      /**
     * Get the operations that owns the comment.
     */
    public function operations()
    {
        return $this->belongsTo('App\Operations', 'foreign_key');
    }
}


