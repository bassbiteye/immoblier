<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Divers extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'divers_id','fichier','commentaire','operations'
    ];
   
         /**
     * Get the operations for the blog post.
     */
    public function operations()
    {
        return $this->hasMany('App\Operations');
    }
}
