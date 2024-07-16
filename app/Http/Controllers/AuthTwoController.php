<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;

class AuthTwoController extends Controller
{
    public function loadRegisterForm(){
        return view('User.register');
    }
    public function registerUser(Request $request){
       $request->validate([
        'name' => 'required',
        'email' => 'required | email | unique:users',
        'username' => 'required',
        'password' => 'required | min:6 | max:30 | confirmed',
       ]);
       try {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect('/register/form')->with('success','You have successfully registered!');
       } catch (\Exception $e) {
        return redirect('/register/form')->with('error',$e->getMessage());

       }
     }
     public function loadLoginPage(){
        return view('User.login');
    }
    public function LoginUser(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:6|max:8',
        ]);
        
        try 
        {
            // login logic
            $userCredentials = $request->only('email','password');

            if(Auth::attempt($userCredentials))
            {
                if(auth()->user()->role == 0)
                {
                    return redirect('/user/home');
                }
                elseif(auth()->user()->role == 1)
                {
                    return redirect('/admin/home');
                }
                else
                {
                    return redirect('/')->with('error','Error to find your role');
                }
                
            }
            else
            {
                return redirect('/login/form')->with('error','Wrong User Credentials');
            }
        }
         catch (\Exception $e)
        {
            return redirect('/login/form')->with('error',$e->getMessage());
        }
    }
   /* public function loginUser(Request $request){
        $request->validate([
         'username' => 'required',
         'password' => 'required',
        ]);
        try {
            $userCredentials = $request->only('username', 'password');
            if (Auth::attempt($userCredentials)) {
                return redirect('/home');
            }else{
                return redirect('/login/form')->with('error','wrong user credentials');
            }
        } catch (\Exception $e) {
            return redirect('/login/form')->with('error',$e->getMessage());
    
           }

        }*/
        public function loadHomePage(){
            return view('User.home-page');
        }
    
        public function logoutUser(Request $request){
            $request->session()->flush();
            Auth::logout();
            return redirect('/login/form');
        }
        public function loadForgotPage(){
            return view('User.forgot-page');
        }
        public function forgot(Request $request){
          
            // check if email exist
            $user = User::where('email',$request->email)->get();
            foreach ($user as $value) {
                # code...
            }
    
            if(count($user) > 0){
                $token = Str::random(40);
                $domain = URL::to('/');
                $url = $domain.'/reset/password?token='.$token;
    
                $data['url'] = $url;
                $data['email'] = $request->email;
                $data['title'] = 'Password Reset';
                $data['body'] = 'Click the link below to reset your password!';
    
                Mail::send('forgotPasswordMail',['data' => $data], function($message) use ($data){
                    $message->to($data['email'])->subject($data['title']);
                });
    
    
                $passwordReset = new PasswordReset;
                $passwordReset->email = $request->email;
                $passwordReset->token = $token;
                $passwordReset->user_id = $value->id;
                $passwordReset->save();
    
                return back()->with('success','Please check your email inbox to reset your password...');
            }else{
                return redirect('/forgot/form')->with('error','email does not exist!');
            }
        
        }
    /*
        public function loadResetPassword(Request $request){
            $resetData = PasswordReset::where('token',$request->token)->get();
            if(isset($request->token) && count($resetData) > 0){
                $user = User::where('id',$resetData[0]['user_id'])->get();
                foreach ($user as $user_data) {
                    # code...
                }
                return view('reset-password',compact('user_data'));
            }else{
                return view('404');
            }
        }
    
        // perform password reset logic here
    
        public function ResetPassword(Request $request){
            $request->validate([
                'password' => 'required|min:6|max:8|confirmed'
            ]);
            try {
                $user = User::find($request->user_id);
                $user->password = Hash::make($request->password);
                $user->save();
    
                // delete reset token
                PasswordReset::where('email',$request->user_email)->delete();
    
                return redirect('/login/form')->with('success','Password Changed Successfully');
            } catch (\Exception $e) {
                return back()->with('error',$e->getMessage());
            }
        }
    }
}
*/

           public function fourOfour(){
            return view('User.404');

           }
        }