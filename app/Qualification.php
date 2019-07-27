<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $fillable = [
        'name'
    ];
    public function types(){
        return $this->belongsToMany(Type::class);
    }

    public function drivers(){
        return $this->belongsToMany(Driver::class);
    }
}
