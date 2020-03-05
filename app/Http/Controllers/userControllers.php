<?php
namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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


	public static function createUser(Request $request){
		if ($request->isJson()) {
			$data = $request->json()->all();

			$exitsEmail = User::where('email',$data['email'])->first();
			$password = $data['password'];
			$confiPassword = $data['confiPassword'];

			if (strlen(trim($data['name'])) < 1  || strlen(trim($data['email'])) < 1 || strlen(trim($data['password'])) < 1 || strlen(trim($data['confiPassword'])) < 1) {
				return response()->json(['isEmpty'=>'You must complete all fields!'],400,);
			}

			if ($exitsEmail) {
				return response()->json(['error'=>'This email is associated with an account!'],400,[]);
			}

			if ($password===$confiPassword) {
				$user = User::create([
					'name' => $data['name'],
					'email' => $data['email'],
					'password' => Hash::make($data['password']),
					'api_token'=> Str::random(60),
					'activate' => 0
				]);
				return response()->json($user,201);
			}else{
				return response()->json(['error'=>'The password does not match!'],400,[]);
			}

		}else{
			return response()->json(['error'=>'Unauthorized'],401,[]);
		}
	}


	public static function getToken(Request $request)
	{
		if ($request->isJson()) {
			try {
				$data = $request->json()->all();
				$user = User::where('username',$data['username'])->first();
				if ($user && Hash::check($data['password'],$user->password)) {
					return response()->json($user,200);
				} else {
					return response()->json(['error' => 'No Contenet'],406);
				}
				
			} catch (ModelNotFoundException $e) {
				return response()->json(['error' => 'No Contenet'],406);
				
			}
		}else{
			return response()->json(['error'=>'Unauthorized'],401,[]);
		}
	}
}
