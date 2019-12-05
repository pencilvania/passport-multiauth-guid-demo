<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use App\Shops;
use Illuminate\Support\Facades\Auth; 
use Validator;

class Register extends Controller
{
   public function useregister(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
		if ($validator->fails()) { 
					return response()->json(['error'=>$validator->errors()], 401);            
				}
		$input = $request->all(); 
				$input['password'] = bcrypt($input['password']); 
				$user = User::create($input); 
				$success['token'] =  $user->createToken('MyApp')-> accessToken; 
				$success['name'] =  $user->name;
		return response()->json(['success'=>$success], 200); 
			}


 public function shopregister(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
		if ($validator->fails()) { 
					return response()->json(['error'=>$validator->errors()], 401);            
				}
		$input = $request->all(); 
				$input['password'] = bcrypt($input['password']); 
				$shop = Shops::create($input); 
				$success['token'] =  $shop->createToken('MyApp')-> accessToken; 
				$success['name'] =  $shop->name;
		return response()->json(['success'=>$success],200); 
			}
}
