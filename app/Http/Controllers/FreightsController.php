<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FreightsController extends Controller
{
    //get
    public function findAllbyUser()
    {
        $user = Auth::user();
        try {
            $Freights = Freight::where('user_id', $user->id)->paginate(10)->get();
            return response()->json([
                'message' => 'success',
                $Freights
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                $Freights
            ], 400);
        }
    }

    //get
    public function findAllbyDriver()
    {
        $user = Auth::user();
        try {
            $Freights = Freight::where('user_id_driver', $user->id)->paginate(10)->get();
            return response()->json([
                'message' => 'success',
                $Freights
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'error',
                $Freights
            ], 400);
        }
    }

    //post
    public function register(Request $Request)
    {
        $user = Auth::user();
        
        $this->validate($Request, [
            'origin' => 'required',
            'destin' => 'required',
            'price' => 'required',
            'type_id' => 'required|numeric'
        ]);

        $Freight = Freight::create([
            'origin' => $Request->origin,
            'destin' => $Request->destin,
            'price' => $Request->price,
            'type_id' => $Request->type_id,
            'user_id' => $user->id
        ]);

        return response()->json([
            'message' => 'success',
            'created' => $Freight
        ], 200);
    }
}