<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use Keygen;
use App\Model\Authenticator;

class LoginController extends Controller
{
    
    private $authenticator;
    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    public function login(Request $request)
    {
     
      $value =  $this->authenticator->create($request);

      return $value;
     
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setToken(Request $request)
    {
        $credentials = array_values($request->only('mobile', 'token'));
        array_push($credentials,$request->provider);
        if (! $user = $this->authenticator->attempt(...$credentials)) {
			return response()->json(['error' => 'invalid_credentials'], 401);
            //throw new AuthenticationException();
        }
		
        $token = $user->createToken('My Token')->accessToken;
		
        return [
            'token_type' => 'Bearer',
            'access_token' => $token,
			
        ];
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
