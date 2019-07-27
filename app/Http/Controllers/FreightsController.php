<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Freight;
use App\User;
use App\Type;
use Illuminate\Support\Facades\DB;
use App\Events\Send;

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
            'type_id' => 'required_if:type.description,""'
        ]);


        try {
            DB::beginTransaction();
            $Type = null;
            if ($Request->type['description'] != "")
                $Type = Type::create([
                    'description' => $Request->type['description'],
                    'status' => true,
                    'qualification_id' => 1
                ]);
            else if($Request->type_id)
                $Type = Type::find($Request->type_id);

            $Freight = Freight::create([
                'origin' => $Request->origin,
                'destin' => $Request->destin,
                'price' => str_replace(',', '.', $Request->price),
                'type_id' => $Type->id,
                'user_id' => $user->id,
                'status' => 1
            ]);

            // Broadcast
            broadcast(new Send($Freight));

            DB::commit();
            return response()->json([
                'message' => 'success',
                'created' => $Freight
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => $th->getMessage()
            ], 400);
        }
    }

    public function accept(Request $Request)
    {
        try {
            $user = Auth::user();
            $user->person;
            $user->person->driver;
            if (!$user->person->driver) {
                return response()->json([
                    'message' => 'the logged in user must be the driver type to perform a freight'
                ], 403);
            }

            $freight = Freight::find($Request->freight_id);
            $freight->user_id_driver = $user->person->driver->id;
            $freight->save();

            return response()->json([
                'message' => 'success',
                'freight' => $freight
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 400);
        }
    }
}
