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
        'details', 'prix', 'bailleur','type','etat','adresse'
    ];
        /**
     * Get the Typebiens for the blog post.
     */
    public function type()
    {
        return $this->hasMany('App\Typebiens');
    }
       /**
     * Get the Bailleurs for the blog post.
     */
    public function bailleur()
    {
        return $this->hasMany('App\Bailleurs');
    }
}


