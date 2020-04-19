<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comptes extends Model
{
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'numero', 'solde','type'
    ];
        /**
     * Get the biens that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'foreign_key');
    }
         /**
     * Get the type that owns the comment.
     */
    public function typecompte()
    {
        return $this->belongsTo('App\Typecomptes', 'foreign_key');
    }
}
