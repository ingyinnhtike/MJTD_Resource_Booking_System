<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use JWTAuth;


class AuthController extends Controller {

    public $successStatus = 200;
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(Request $request){ 
        // $muTTL = 60 * 24 *30;
        // JWTAuth::factory()->setTTL($muTTL);
        if(JWTAuth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            // $user = Auth::user(); 
            // $success['token'] =  $user->createToken('MyApp')->accessToken;
            
            $user = Auth::user();
            $success['token'] = JWTAuth::fromUser($user);

            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email|unique:users', 
            'password' => 'required'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 
        // $input['password'] = bcrypt($input['password']); 
        $input['password'] = ($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this-> successStatus); 
    }

    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    }

    public function reset_password(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $user = $request->user();
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['success' => 'Updated Successfully.'], $this-> successStatus); 
    }
}