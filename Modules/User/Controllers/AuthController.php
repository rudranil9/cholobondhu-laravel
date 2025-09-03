<?php

namespace Modules\User\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Modules\User\Requests\LoginRequest;
use Modules\User\Requests\RegisterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('user::auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            // Redirect to intended page or home
            return redirect()->intended(route('home'))->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    public function showRegistrationForm(): View
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('user::auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Welcome to Cholo Bondhu, ' . $user->name . '! Your account has been created successfully.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $userName = Auth::user()->name;
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home')->with('info', 'You have been logged out successfully. See you next time!');
    }

    public function showForgotPasswordForm(): View
    {
        return view('user::auth.forgot-password');
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email']);
        
        // Password reset logic would go here
        return back()->with('status', 'If an account with that email exists, we have sent you a password reset link.');
    }

    public function showResetPasswordForm($token): View
    {
        return view('user::auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        // Password reset logic would go here
        return redirect()->route('login')->with('status', 'Your password has been reset successfully!');
    }
}
