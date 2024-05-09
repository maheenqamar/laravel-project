<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginValidation;
use App\Http\Requests\Validation;
use App\Http\Requests\ForgetValidation;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function create()
    {
        return view('user.create');
    }

    public function login()
    {
        return view('user.login');
    }

    public function store(Validation $request)
    {
       User::create([
            'usernames' => $request->input('usernames'),
            'userFirstName' => $request->input('userFirstName'),
            'userLastName' => $request->input('userLastName'),
            'userPhone' => $request->input('userPhone'),
            'userEmail' => $request->input('userEmail'),
            'userPassword' => Hash::make($request->input('userPassword')),
            'gender' => $request->input('gender'),
        ]);
        return redirect()->route('login')->with('success', 'Registration successful!');
    }

    public function loggedin(LoginValidation $request)
    {
         // $user = new User();
         $userData = User::getUserByEmail($request->userEmail);
         if ($userData && Hash::check($request->userPassword, $userData->userPassword)) {
             Session::put('user_id', $userData->user_id);
             Session::put('usernames', $userData->usernames);
             return redirect()->route('welcome')->with('success', 'Login successful!');
         } else {
             return redirect()->route('login')->with('error', 'Email/Password incorrect');
         }
    }

    public function password()
    {
        return view('user.changepw');
    }

    public function resetpassword(Request $request)
    {
        $user_data = User::getUserById(session('user_id'));
        if (Hash::check($request->oldPassword, $user_data->userPassword)) {
            if ($request->newPassword === $request->confirmPassword) {
                $user_data->userPassword = Hash::make($request->newPassword);
                $user_data->save();
                return back()->with('success', 'Password Changed');
                
            } 
            else 
            {
                return back()->with('error', 'Old password is incorrect or new password and confirm password do not match.');
            }
        } 
        else 
        {
            return back()->with('error', 'Old password is incorrect or new password and confirm password do not match.');
        }
    }

    public function forgetpassword()
    {
        return view('user.forgetpw');
    }

    public function sendlink(ForgetValidation $request)
    {
        $user = User::getUserByEmail($request->userEmail);
        if(!empty($user))
        {
            $user->remember_token = Str::random(30);
            $user->save();
            Mail::to($user->userEmail)->send(new ForgotPasswordMail($user));
            return back()->with('success', 'Link sent successfully. Check your emails.');
        }
        else
        {
            return back()->with('error', 'Email does not exist.');
        }
    }

    public function resetscreen($remember_token)
    {
        $user = User::getUserByToken($remember_token);

        if (!empty($user)) {
            $data['user'] = $user;
            return view('user.reset', $data);
        } else {
            abort(404);
        }
    }

    public function pwreset($token, Request $request)
    {
        $user_data = User::getUserByToken($token);
        if ($request->userPassword === $request->cuserPassword) {
            $user_data->userPassword = Hash::make($request->userPassword);
            $user_data->remember_token = Str::random(30);
            $user_data->save();
            return redirect()->route('login')->with('success', 'Password changed successfully');
        } else {
            return back()->with('error', 'Password does not match');
        }
    }

    public function logout()
    {
        Session::forget('user_id');
        return redirect()->route('login')->with('success', 'Logout successfully!');
    }
}
