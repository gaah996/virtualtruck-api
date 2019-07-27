<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    protected $fillable = [
        'plate', 'brand', 'model','capacity','limitkg','driver_id','year'
    ];
    public function driver(){
        return $this->belongsTo(Driver::class);
    }
}
