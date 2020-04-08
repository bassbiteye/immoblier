<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipements extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'equipements_id','typeEquipement', 'nombreEquipement','etatEquipement', 'commentaireEquipement','bien'
    ];

      /**
     * Get the biens that owns the comment.
     */
    public function bien()
    {
        return $this->belongsTo('App\Biens', 'foreign_key');
    }
}
