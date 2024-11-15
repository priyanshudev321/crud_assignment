<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    { 
        try{

            $input = $request->all();

            Log::info( "All Inputs of Login", $input );

            $validation = Validator::make($input,[
                'email' => "required",
                'password' => "required",
            ]);

            if($validation->fails()){

                Log::error($validation->errors()->first());
                throw new \Exception( $validation->errors()->first() );

            }

            $credentials = [
                'email' => $request->email ,
                'password' => $request->password ,
            ];

            $user = User::where('email', $request->email)->first();
         

            if ( $user && Auth::attempt($credentials)) {

                $token = $user->createToken('API Token')->accessToken ;
             
                return response([ 
                    'status' => true ,
                    'token' => $token , 
                    'data'=> $user, 
                    'message'=>'login successfully !'
                ],200);

            }else{
                return response([ 'status' => false ,'message'=>'Credentials Not valid !'],200);
            }

        }catch(\Exception $e){
            
            $err = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ];
 
             Log::error( " ERROR :: " , $err ) ;
 
             return response()->json([
                 'status' => false,
                 'message'=> $e->getMessage(),
                 'line' => $e->getLine()
             ],200);
        }
    }
}
