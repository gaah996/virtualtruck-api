<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = [
        'description','status','qualification_id'
    ];
        public function freight(){
            return $this->hasOne(Freight::class);
        }

        public function qualifications()
        {
            return $this->belongsToMany(Qualification::class);
        }
}
