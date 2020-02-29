<?php
namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;

class userControllers extends Controller
{

    public static function index(Request $request){
        if ($request->isJson()) {
            $user =  User::all();
            return response()->json($user,200);
        }else{
            return response()->json(['error'=>'Unauthorized'],401,[]);
        }
        
    }
}
