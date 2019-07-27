<?php

namespace App\Http\Controllers;

use App\Qualification;
use http\Env\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class QualificationsController extends Controller
{
    public function createQualification(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'name' => 'required|string',
        ]);
        try {
            $qualifications = Qualification::create([
                'name' => $request['name']
            ]);
            return response()->json(['message' => 'Qualification created', 'qualification' => $qualifications], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'error', 'exception' => $exception->getMessage()], 500);
        }
    }

    public function showQualification()
    {
        $user = Auth::user();
        $qualifications = Qualification::all();
        try {
            return response()->json(['message' => 'success', 'qualifications' => $qualifications], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'error', 'Couldn\'t show qualifications, try again'], 400);
        }
    }
}

//    public function updateQualification(Request $request, $idqualification){
//        $user = Auth::user();
//        $this->validate($request,[
//            'name'=>'required|string',
//        ]);
//        try{
//            $qualifications = Qualification::findOrFail($idqualification);
//
//            if($user->id == $qualifications->driver_id){
//                try{
//                    $qualifications->update($request->only(['name']));
//                    $qualifications = Qualification::find($qualifications->id);
//                    return response()->json(['success'=>$qualifications],200);
//                }catch(\Exception $exception){
//                    return response()->json(['error'=>'Couldn\'t update qualifications'], 500);
//                }
//            }else{
//                return response()->json(['error'=>'Qualifications doesn\'t belong to user'],403);
//            }
//        }catch(\Exception $exception){
//            return response()->json(['error','Couldn\'t find book'], 404);
//        }
//    }
//
//    public function deleteQualification($idQualification){
//        $user=Auth::user();
//        try{
//            $qualifications = Qualification::findOrFail($idQualification);
//            if($user->id == $qualifications->driver_id){
//                try{
//                    $qualifications->delete();
//                }catch(\Exception $exception){
//                    return response()->json(['error'=>'Couldn\'t delete qualification'], 500);
//                }
//            }else{
//                return response()->json(['error'=>'Qualification doesn\'t belong to user'], 403);
//            }
//        }catch(\Exception $exception){
//            return response()->json(['error'=>'Qualification doesn\'t finded'], 404);
//        }
//    }
//}
