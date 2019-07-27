<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Person;
use App\Truck;
use Laravel\Passport\Bridge\PersonalAccessGrant;
use DateInterval;

class UsersController extends Controller
{
    // post
    public function login(Request $Request) {
        $this->validate($Request, [
            'user_name' => 'required_if:email,""',
            'password' => 'required|min:5',
            'email' => 'required_if:user_name,""'
        ]);

        if(Auth::attempt($Request->all())){
            $user = Auth::user();

            $user = User::find($user->id);
            $user->person;
            
            if($user->type == 2) {
                $user->person->driver;
                $user->person->driver->truck = Truck::where('driver_id', $user->person->driver->id);
            }

            if($user->status == 0){
                return response()->json([
                    'message' => 'user disabled',
                    'user' => $user
                ], 200);
            }
                $user['token'] = $this->setUserToken($user)->accessToken;
            return response()->json([
                'message' => 'success',
                'user' => $user
            ], 200);
        } else {
            return response()->json([
                'message' => 'Couldn\'t find user'
            ], 404);
        }
    }

    // post
    public function register(Request $Request) {
        $this->validate($Request, [
            'user_name' => 'required|min:5',
            'password' => 'required|min:5',
            'type' => 'required',
            'email' => 'required|regex:/^.+@.+$/i',
            'person.name' => 'required',
            'person.document' => 'required',
            'person.birthday' => 'required'
        ]);

        $user = null;
        $person = null;
        /*
         * TRANSACTION
         *
         * Transaction is used to in case of any error when
         * registering the record in a table, terminate the
         * process and not register anything
         */
        DB::beginTransaction();
        try {

            $person = Person::create([
                'name' => $Request->person['name'],
                'document' => $Request->person['document'],
                'birthday' => $Request->person['birthday']
            ]);

            $user = User::create([
                'user_name' => $Request->user_name,
                'email' => $Request->email,
                'password' => bcrypt($Request->password),
                'type' => $Request->type,
                'person_id' => $person->id,
                'status' => true
            ]);

            $user->person;

            // Get Token
            $user['token'] = $this->setUserToken($user)->accessToken;

            // Save changes to database
            DB::commit();

            return response()->json([
                'message' => 'success',
                'created' => $user
            ], 200);

        } catch (\Throwable $th) {
            // Restore database
            DB::rollback();

            return response()->json([
                'message' => $th->getMessage(),
                'created' => $user
            ], 400);
        }
    }

    //get
    public function find($id) {
        try {
            $user = Auth::user();

            $user = User::find($id);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'user' => null
            ], 400);
        }

        return response()->json([
            'message' => 'success',
            'finded' => $user
        ], 200);
    }

    private function setUserToken(User $user){
        $authorizarionServer = app()->make(\League\OAuth2\Server\AuthorizationServer::class);
        $authorizarionServer->enableGrantType(
            new PersonalAccessGrant, new DateInterval('PT12H')
        );

        $token = $user->createToken('AccessToken');
        return $token;
    }
}
