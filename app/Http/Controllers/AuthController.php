<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected UserRepository $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * Show registration form.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:customer,seller',
        ]);

        // Check if email already exists
        $existing = $this->userRepo->findByEmail($request->input('email'));
        if ($existing) {
            return back()->withErrors(['email' => 'This email is already registered.'])->withInput();
        }

        $userId = $this->userRepo->create(
            $request->input('name'),
            $request->input('email'),
            $request->input('password'),
            $request->input('role')
        );

        // Auto-login after registration
        $request->session()->put('user_id', $userId);
        $request->session()->put('user_name', $request->input('name'));
        $request->session()->put('role', $request->input('role'));

        if ($request->input('role') === 'seller') {
            return redirect('/seller/register-shop')->with('success', 'Account created! Please set up your shop.');
        }

        return redirect('/products')->with('success', 'Welcome to বেচাকেনা!');
    }

    /**
     * Show login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = $this->userRepo->findByEmail($request->input('email'));

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
        }

        // Store in session
        $request->session()->put('user_id', $user->user_id);
        $request->session()->put('user_name', $user->name);
        $request->session()->put('role', $user->role);

        // Redirect based on role
        return match ($user->role) {
            'admin'    => redirect('/admin/brands')->with('success', 'Welcome back, Admin!'),
            'seller'   => redirect('/seller/products')->with('success', 'Welcome back!'),
            default    => redirect('/products')->with('success', 'Welcome back!'),
        };
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect('/login')->with('success', 'You have been logged out.');
    }
}
