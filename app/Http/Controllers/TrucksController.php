<?php

namespace App\Http\Controllers;

use App\Truck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrucksController extends Controller
{
    public function updateTruck(Request $request, $idTruck){
        $user=Auth::user();
        $this->validate($request,[
            'plate'=>'required|size:8|string',
            'brand'=>'required|max:45|string',
            'model'=>'max:45|string|required',
            'capacity'=>'numeric|required',
            'limitkg'=>'numeric|required',
            'year'=>'numeric|required'
        ]);
        try{
            $trucks = Truck::findOrFail($idTruck);
            if($user->person->driver->id == $trucks->driver_id){
                try{
                    $trucks->update($request->only(['plate','brand','model','capacity','limitkg','year']));
                    $trucks = Truck::find($trucks->id);
                    return response()->json(['message' => 'success','trucks'=>$trucks], 200);
                }catch(\Exception $exception){
                    return response()->json(['error'=>'Couldn\'t update truck'], 500);
                }
            }else{
                return response()->json(['error' => 'Truck doesn\'t belong to user'], 403);
            }
        }catch(\Exception $exception){
            return response()->json(['error' => 'Couldn\'t find the truck'], 404);
        }
    }

    public function deleteTruck($idTruck){
        $user=Auth::user();
        try{
            $trucks = Truck::findOrFail($idTruck);
            try{
                $trucks->delete();
                return response()->json(['message' => 'Truck deleted whith sucess'], 200);
            }catch (\Exception $exception){
                return response()->json(['error' => 'Couldn\'t delete truck, try again', 'message' => $exception->getMessage()], 500);
            }
        }catch (\Exception $exception){
            return response()->json(['error','Couldn\'t find the truck'], 404);
        }
    }


}
