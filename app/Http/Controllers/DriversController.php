<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\User;
use App\Person;
use App\Driver;
use App\Truck;
use Illuminate\Http\Request;
use function GuzzleHttp\json_decode;

class DriversController extends Controller
{
    //get
    public function find($id) {
        $user = Auth::user();

        try {
            $driver = Driver::find($id);
            return response()->json([
                'message'=>'success', 
                'driver' => $driver
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message'=>'error', 
                'driver' => $th->getMessage()
            ], 400);
        }
    }

    //post
    public function register(Request $Request) {
        $this->validate($Request, [
            'user_name' => 'required|min:5',
            'password' => 'required|min:5',
            'type' => 'required',
            'email' => 'required|regex:/^.+@.+$/i',
            
            'driver.cnh' => 'required|size:11',

            'person.name' => 'required',
            'person.document' => 'required',
            'person.birthday' => 'required',

            'truck.plate' => 'required|size:8',
            'truck.brand' => 'required',
            'truck.model' => 'required',
            'truck.capacity' => 'required',
            'truck.limitkg' => 'required',
            'truck.year' => 'required|numeric'
        ]);
        $user = null;
        $person = null;
        $driver = null;
        $truck = null;
        try {
            DB::beginTransaction();
            $person = Person::create([
                'name' => $Request['person']['name'],
                'document' => $Request['person']['document'],
                'birthday' => $Request['person']['birthday']
            ]);
    
            $user = User::create([
                'user_name' => $Request['user_name'],
                'email' => $Request['email'],
                'password' => bcrypt($Request['password']),
                'type' => $Request['type'],
                'person_id' => $person->id,
                'status' => true
            ]);
    
            $driver = Driver::create([
                'cnh' => $Request['driver']['cnh'],
                'person_id' => $person->id
            ]);
    
            $truck = Truck::create([
                'plate' => $Request['truck']['plate'],
                'brand' => $Request['truck']['brand'],
                'model' => $Request['truck']['model'],
                'capacity' => $Request['truck']['capacity'],
                'limitkg' => $Request['truck']['limitkg'],
                'year' => $Request['truck']['year'],
                'driver_id' => $driver->id,
                'user_id' => $user->id
            ]);
            
            // Save changes to database
            DB::commit();

            return response()->json([
                'message' => 'success', 
                'created' => $truck
            ], 200);
        } catch (\Throwable $th) {
            // Restore database 
            DB::rollback();

            return response()->json([
                'message' => $th->getMessage(), 
                $user
            ], 400);
        }
    }
}
