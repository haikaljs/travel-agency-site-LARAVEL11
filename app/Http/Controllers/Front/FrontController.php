<?php

namespace App\Http\Controllers\Front;

use Auth;
use Hash;
use App\Models\User;
use App\Mail\Websitemail;
use App\Models\WelcomeItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;


class FrontController extends Controller
{
    public function home(){
        $welcome_item = WelcomeItem::where('id', 1)->first();
        return view('front.home', compact('welcome_item'));
    }

    public function about(){
        $welcome_item = WelcomeItem::where('id', 1)->first();
        return view('front.about',compact('welcome_item'));
    }

    public function registration(){
        return view('front.registration');
    }

    public function registration_submit(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password'
        ]);

        $token = hash('sha256',time());


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->token = $token;
        $user->save();

        $verification_link = route('registration_verify_email', ['email' => $request->email, 'token' => $token]);

        $subject = 'User Account Verification';
        $message = 'Please click the following link to verify your email address:<br><a href=' . $verification_link.'">Verify Email<a/>';

        Mail::to($request->email)->send(new Websitemail($subject,$message));



        return redirect()->back()->with('success', 'Registration is successful, but you have to verify your email address to login. Please check your email.');
    }

    public function registration_verify($email, $token){

        $user = User::where('token',$token)->where('email',$email)->first();
        if(!$user) {
            return redirect()->route('login');
        }
        $user->token = '';
        $user->status = 1;
        $user->update();
    
        return redirect()->route('login')->with('success', 'Your email is verified. You can login now.');
    
    }


    public function login(){
        return view('front.login');
    }

    public function login_submit(Request $request){
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $check = $request->all();
        $data = [
            'email' => $check['email'],
            'password' => $check['password'],
            'status' => 1
        ];

        if (Auth::guard('web')->attempt($data)) {
            return redirect()->route('user_dashboard')->with('success','Login successfull!');
        } else {
            return redirect()->route('login')->with('error', 'The information you entered is incorrect! Please try again!')->withInput();
        }
    }

    public function forget_password(){
        return view('front.forget-password');
    }

    public function forget_password_submit(Request $request){
        $request->validate([
            'email' => ['required', 'email'],
        ]);
    
        $admin = User::where('email',$request->email)->first();
        if(!$admin) {
            return redirect()->back()->with('error','Email is not found');
        }
    
        $token = hash('sha256',time());
        $admin->token = $token;
        $admin->update();
    
        $reset_link = route('reset_password', ['token' => $token, 'email' => $request->email]);
        $subject = "Password Reset";
        $message = "To reset password, please click on the link below:<br>";
        $message .= "<a href='".$reset_link."'>Click Here</a>";
    
        Mail::to($request->email)->send(new Websitemail($subject,$message));
    
        return redirect()->back()->with('success','We have sent a password reset link to your email. Please check your email. If you do not find the email in your inbox, please check your spam folder.');
    }

    public function reset_password($token,$email)
    {
        $user = User::where('email',$email)->where('token',$token)->first();
        if(!$user) {
            return redirect()->route('login')->with('error','Token or email is not correct');
        }
        return view('front.reset-password', compact('token','email'));
    }


    public function reset_password_submit(Request $request, $token, $email)
    {
        $request->validate([
            'password' => ['required'],
            'confirm_password' => ['required','same:password'],
        ]);

        $user = User::where('email',$request->email)->where('token',$request->token)->first();
        $user->password = Hash::make($request->password);
        $user->token = "";
        $user->update();

        return redirect()->route('login')->with('success','Password reset is successful. You can login now.');
    }

    public function logout(){
        Auth::guard('web')->logout();
        return redirect()->route('login')->with('success', 'Logout is successful!');    
    }
}
