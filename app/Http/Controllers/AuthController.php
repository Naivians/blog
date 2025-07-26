<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function index()
    {
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }
    function dashboard()
    {

        return view('dashboard');
    }

    function register()
    {
        return view('auth.register');
    }

    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => "required|string",
            'email' => "required|email|unique:users,email",
            'password' => "required|string|min:6|confirmed"
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        $randomImg = 'https://randomuser.me/api/portraits/men/' . rand(1, 99) . '.jpg';
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'img' => $randomImg
        ]);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => "Failed to store user"
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "Register Successfully"
        ]);
    }

    function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => "required|email",
            'password' => "required|string"
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect email or password.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "dito",
            'redirect' => route('dashboard')
        ]);
    }

    function logout(Request $request){
        Auth::logout();
        return redirect()->route('login');
    }
}
