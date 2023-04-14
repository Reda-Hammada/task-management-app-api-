<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravolt\Avatar\Avatar;
use App\Models\User;
use App\Models\Board;


class Usercontroller extends Controller
{
    /**
     * Create new user 
     *  @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */

  
        
    
    public function Register(Request $request)
    {
        $fields = $request->validate(

            [ 'name'=>'string|required',
              'email'=>'string|required|unique:users,email',
              'password'=>'string|required|',
            ]
            );
         // create Image based on user's intials
     

        // $avatar = new Avatar();
        //  $image = $avatar->create($fields['name'])->toBase64();
         
        $image_path = 'user.png';

       
       
        $user = User::create([

            'name'=>$fields['name'],
            'email'=>$fields['email'],
            'password'=>bcrypt($fields['password']),
            'image_path'=>$image_path,
            
        ]);

        $fetchUser = [
            
             'name'=>$fields['name'],
             'email'=>$fields['email'],
             'image_path'=>$image_path,

        ];
        
     if($fields):
        
        if($user):
                
            $token = $user->createToken('myapptoken')->plainTextToken;

            return response()->json([
            'status'=>201,
            'user'=>$fetchUser,
            'message'=>'Your Account has been created successfuly, 
                        you will be directed to your dashboard shortly',
            'token'=>$token
            ]);
            
        endif;
        
    endif;
    
    }

    /**
     * log in user 
     *  @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */

    public function login(Request $request)
    {
        // retrieve login inputs from the request and validate them
       
            $fields = $request->validate([
                'email'=>'string|required',
                'password'=>'string|required',
             ]);
        // Get the logged User with email
        $User = User::where('email', $fields['email'])->first();

        //check  if user exists 
        if($User):
            // check if the password inserted is the same one in the database
            $isPassTrue = Hash::check($fields['password'], $User->password);
            if($isPassTrue):

                // create access token if the password is right 

                $token = $User->createToken('myapptoken')->plainTextToken;

                return response()->json([
                    'status'=>200,
                    'user'=>$User,
                    'message'=>'Your are being logged in ',
                    'token'=>$token]);
                    
                else:
                    return response()->json([
                        'status'=>401,
                        'message'=>'email or password invalid'
                    ]);
                

        

            endif;
            
        else: 
            return response()->json([
                'status'=>401,
                'message'=>'email or password invalid'
            ]);
        
       
        endif;
        
        
    }


    /**
     * update user info 
     *  @param int $userId
     *  @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */

    public function updateUserInfo(Request $request,$userId){
         
        $fields = $request->validate([
            
                 'userfullname'=>'|string',
                 'email'=>'string|email',
                 'password'=>'srting',
                 'image'=>'',
        ]);

        $User = User::findOrFail($userId);

        // user full name

        if(isset($fields['userfullname'])):
            
           $User->name = $fields['userfullname'];
           $User->save();
           
        //    return response([
        //     'msg' => 'full name has been updated to ' . $User->name,
        //      'status'=> 200,
        //         ]);
           
        endif;

        // user email 

        if(isset($fields['email'])):
            
            $User->email =  $fields['email'];
            $User->save();
            return response([
                'msg' => 'email has been updated to ' . $User->email,
                 'status'=> 200,
                    ]);

        endif;


        // user password

        if(isset($fields['newpass'])):
             
            $User->password = bcrypt($fields['newpass']);
            $User->save();
            
          
        endif;
        
        // user profile picture

        if(isset($fields['userImage'])):



        endif;
  
        
    }

    /**
     * log out user 
     *  @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */

    public function Logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return [

            'message' =>'logged out',
        ];    

    }

}