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
     * 
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
         
                  
         $avatar = new Avatar();
        
         $userName = mb_convert_encoding($fields['name'],'UTF-8', 'UTF-8');

         $image_path = $avatar->create($userName);
        $image_path->save(public_path('storage/avatars' . $userName. '.png'),100);
                  
            
        $user = User::create([

            'name'=>$fields['name'],
            'email'=>$fields['email'],
            'password'=>bcrypt($fields['password']),
            'image_path' =>$image_path,
            
        ]);
        // fetch user image 
        $image = $user->latest()->value('image_path');
        
        $fetchUser = [
            
             'name'=>$fields['name'],
             'email'=>$fields['email'],
             'image_path' => $image,

  
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
        
       try{
        
           
            $user = User::findOrFail($userId);
               

                $updatedFields = [];
 
                // user full name
                if ($request->filled('userfullname')) :

                    $request->validate([
                        'userfullname' => 'string',
                    ]);
                      
                    $user->name = $request->input('userfullname');
                    $user->save();

                   $updatedFields[] = 'userfullname';
                   
                endif;

                // user email
                if ($request->filled('email')):
                    
                    $request->validate([
                        'email' => 'string|email',
                    ]);
                    
                    $user->email = $request->input('email');
                    $user->save();

                    $updatedFields[] = 'email';

                endif;

                // user password
                if ($request->filled('newpass') && $request->filled('currentpassword')):

                    $request->validate([
                        'currentpassword'=>'string',
                        'newpass' => 'string',
                    ]);
                     
                    $isPassTrue = Hash::check($request['currentpassword'], $user->password);
                    
                    if($isPassTrue):

                        $user->password = bcrypt($request->input('newpass'));
                        $user->save();
    
                        $updatedFields[] = 'password';
                        
                    else:
                        $msg = 'Your current password is wrong';
                        return response([
                            'msg' => $msg,
                            'status'=>401,
                             
                        ]);

                    endif;
                    

                     
                 
                    

                endif;
                
                // keeping track of which fields have been updated to send it through the response to the client
                if(!empty($updatedFields)):

                     if(in_array('email',$updatedFields) && in_array('userfullname', $updatedFields) && in_array('password', $updatedFields)):
                            
                            $msg ='Your personal information has been successfully updated';

                            return response([
                                'msg' => $msg,
                                'status' => 200,
                            ]);
                            
                     endif;

                     if(in_array('userfullname', $updatedFields)):
                            $msg = 'Your full name has been successfully updated';

                            return response([
                                
                               'msg'=> $msg,
                               'status'=> 200,
                            ]);

                     endif;
                     
                     if(in_array('email', $updatedFields)):
                        
                        $msg = 'Your email has been successfully updated';

                        return response([
                            
                           'msg'=> $msg,
                           'status'=> 200,
                        ]);

                 endif;

                     if(in_array('password', $updatedFields)):
                        $msg = 'Your password has been successfully changed';

                        return response([
                            
                            'msg'=> $msg,
                            'status'=>200,
                            
                        ]);
                        
                     endif;
                     
                endif;
            
                
       } 
       catch (\Exception $e) {

            return response([
                
                'error' => $e->getMessage(),
                'status' => 500,
                
            ]);
    }
       
        
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