<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
        public function freight(){
            return $this->hasOne(Freight::class);
        }

        public function types()
        {
            return $this->belongsToMany(Type::class);
        }

}
