<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Operations  extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'operation_id','caution','montantPaye','dateEntre','ref','louer','numero'
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

       /**
     * Get the paiements that owns the comment.
     */
    public function paiements()
    {
        return $this->belongsTo('App\Paiements', 'foreign_key');
    }
      /**
     * Get the divers that owns the comment.
     */
    public function divers()
    {
        return $this->belongsTo('App\Divers', 'foreign_key');
    }
}
