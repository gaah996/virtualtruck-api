<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = [
        'name', 'lastname', 'document', 'streetNumber','street','city','state','country','district','birthday'
    ];
    public function driver(){
        return $this->hasOne(Driver::class);
    }

    public function user(){
        return $this->hasOne(User::class);
    }
}
