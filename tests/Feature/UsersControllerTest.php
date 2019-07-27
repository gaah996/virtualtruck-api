<?php

namespace Tests\Feature;

use Hamcrest\Thingy;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersControllerTest extends TestCase
{

    public function testlogin()
    {
        $user = User::create( [
           'user_name'=>'Fabio Barbosa',
           'password'=>'123456',
           'email'=>'email@teste.com',
            'type'=> 2
        ]);
        $token = $user->createToken('Token')->accessToken;

        $response=$this->withHeaders(['Authorization'=>'Bearer ' . $token])->json('POST', 'api/user/register',[
            User::all()
        ]);
        $response->assertStatus(200);
        $response->assertJsonCount(0, 'users');

        $user->delete();
    }
}
