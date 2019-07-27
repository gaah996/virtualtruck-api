<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'cnh', 'status', 'person_id'
    ];
    public function person(){
        return $this->belongsTo(Person::class);
    }

    public function truck(){
        return $this->belongsTo(Truck::class);
    }

    public function qualifications(){
        return $this->belongsToMany(Driver::class);
    }
}

