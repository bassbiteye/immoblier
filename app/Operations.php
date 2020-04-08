<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Operations extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'caution','montantPaye','dateEntre','ref','louer'
    ];
           /**
     * Get the biens for the blog post.
     */
    public function biens()
    {
        return $this->hasMany('App\Biens');
    }
         /**
     * Get the clients for the blog post.
     */
    public function clients()
    {
        return $this->hasMany('App\Clients');
    }
}
