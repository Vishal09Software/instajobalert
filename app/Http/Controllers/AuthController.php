<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use Auth;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        Auth::login($user);
        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function loginCheck(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Check if account is inactive or suspended before login
            $user = User::where('email', $request->email)->first();
            if ($user) {
                if (isset($user->status) && (strtolower($user->status) == 'inactive' || strtolower($user->status) == 'suspend' || strtolower($user->status) == 'suspended')) {
                    return back()->withErrors([
                        'email' => 'Your account is ' . $user->status . '. Please contact support.',
                    ])->withInput($request->only('email', 'remember'));
                }
            }

            $credentials = $request->only('email', 'password');
            $remember = $request->has('remember');

            if (Auth::attempt($credentials, $remember)) {
                $request->session()->regenerate();
                return redirect('/')->with('success', 'Login successful.');
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput($request->only('email', 'remember'));
        }

        return view('auth.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'You have been logged out successfully.');
    }

    public function forget()
    {
        return view('auth.forget');
    }

    public function newPassword()
    {
        return view('auth.new');
    }

    public function otp()
    {
        return view('auth.otp');
    }


    public function dashboard()
    {
        return view('admin.dashboard.admin');
    }

}
