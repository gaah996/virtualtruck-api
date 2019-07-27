<?php

namespace App\Http\Controllers;

use App\Truck;
use Illuminate\Http\Request;

class TrucksControllers extends Controller
{
    public function updateTruck(Request $request){
        $user=Auth::user();
        $this->validate($request,[
            'plate'=>'required|max:8|string',
            'brand'=>'required|max:45|string',
            'model'=>'max:45|string',
            'capacity'=>'numeric',
            'limitkg'=>'numeric',
            'year'=>'string'
        ]);
        try{
            $truck = Truck::
        }
    }

}
