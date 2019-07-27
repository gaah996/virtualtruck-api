<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Freight extends Model
{
    protected $fillable = [
        'origin', 'destin', 'price','status', 'user_id_driver','user_id','type_id','avaliation','distance','time'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function type(){
        return $this->belongsTo(Type::class);
    }
    public function driver(){
        return $this->belongsTo(User::class);
    }

}
