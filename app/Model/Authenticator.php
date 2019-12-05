<?php
namespace App\Model;
use RuntimeException;
use Illuminate\Hashing\HashManager;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\User;
use App\Stores;
use Validator;
use Keygen\Keygen;
class Authenticator
{
    /**
     * The hasher implementation.
     *
     * @var \Illuminate\Hashing\HashManager
     */
    protected $hasher;
    /**
     * Create a new repository instance.
     *
     * @param  \Illuminate\Hashing\HashManager  $hasher
     * @return void
     */
    public function __construct(HashManager $hasher)
    {
        $this->hasher = $hasher->driver();
    }
    /**
     * @param string $username
     * @param string $password
     * @param string $provider
     * @return Authenticatable|null
     */
    public function attempt(
        string $mobile,
        string $token,
        string $provider
    ): ?Authenticatable {
        if (! $model = config('auth.providers.'.$provider.'.model')) {
			return null;
          //  throw new RuntimeException('Unable to determine authentication model from configuration.');
        }
        /** @var Authenticatable $user */
        if (! $user = (new $model)->where('mobile', $mobile)->where('token', $token)->first()) {
            return null;
        }
     /**   if (! $this->hasher->check($password, $user->getAuthPassword())) {
            return null;
        }*/
        return $user;
    }


    public function create($request) {
        $validator = Validator::make($request->all(), [ 
            'mobile' => 'required', 
            'provider' => 'required', 
        ]);
		if ($validator->fails()) { 
                  //  return response()->json(['error'=>$validator->errors()], 401);   
                  return  response()->error($validator->errors());       
                }
                $key =Keygen::numeric(5)->generate();
               if($request->provider == 'users')
               {    
                    $user = User::where('mobile',$request->mobile)->first();  
                    if($user)
                    {
                    $user->token =  $key;
                    $user->save();
                    }else
                    {
                        $input = $request->all(); 
                        $input['token'] =$key; 
                        $user = User::create($input); 
                    }       
                }elseif($request->provider == 'stores')
                {

                    $shop = Stores::where('mobile',$request->mobile)->first();  
                    if($shop)
                    {
                    $shop->token =  $key;
                    $shop->save();
                    }else
                    {
                        $input = $request->all(); 
                        $input['token'] =$key; 
                        $shop = Stores::create($input); 
                    }       

                }else
                {
                    return  response()->error('provider is incorrect');     
                }
               

		       
				$success['key'] = 'true'; 
                $success['message'] =  'success';
                $success['token'] =  $key;
        return  response()->success('ok', $success);         
      //  return response()->json(['success'=>$success], 200); 
    }
}