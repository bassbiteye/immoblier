<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paiements extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'paiement_id','montant','date','operations'
    ];
   
         /**
     * Get the operations for the blog post.
     */
    public function operations()
    {
        return $this->hasMany('App\Operations');
    }
}
