<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QualificationsController extends Controller
{
    public function createQualification(Request $request){
        $this->validate($request,[
           'name'=>'required'
        ]);
        try{

        }catch(\Exception $exception){
            return response()->json(['error'])
        }
    }

    public function showQualification(){

    }

    public function updateQualification(){

    }
}
