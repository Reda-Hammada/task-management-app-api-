<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;



class Usercontroller extends Controller
{
    //

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
}
