<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;



class Usercontroller extends Controller
{
    // create a new user

    public function  Register(Request $request)
    {
        $fields = $request->validate([
             
             'name'=>'string|required',
             'email'=>'string|required|unique:users,email',
             'password'=>'string|required|confirmed',

        ]);

       
        $user = User::create([

            'name'=>$fields['name'],
            'email'=>$fields['email'],
            'password'=>bcrypt($fields['password']),
        ]);

        $token =  $user->createToken('myapptoken')->plainTextToken;


                return response(
                
                    ['message :' => 'user has been created',
                    [
                        'user' => $fields,
                         
                    ],
        
                    'token' => $token,
                ],201, ['Content-Type => application/json']);
       




    }

    // Login 


    public function login(Request $request)
    {
        // retrieve login inputs from the request and validate them

        $fields = $request->validate([
                'email' => 'string|required',
                'password'=>'string|required',
        ]);

        // Get the logged User with email
        $User = User::where('email', $fields['email'])->first();

        //check  if user exists 
        if($User):


            // check if the password inserted is the same one in the database
                
            if(Hash::check($fields['password'], $User->password)):

                // create access token if the password is right 

                $token = $User->createToken('myapptoken')->plainTextToken;

                return response([
                    'message' => 'You are logged in',

                    [
                        'user' => $User,
                        
                    ],

                    'token' => $token,
                ],200);

            
             endif;
        else:

            // if credentials are wrong response with wrong message
            return response([

                'message' => 'wrong credentials',
              ]);


        endif;

    }

    // Log out

    public function Logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return [

            'message' =>'logged out',
        ];    

    }

}