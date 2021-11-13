<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Login;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.login');
    }

    public function valid(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:191|exists:users,email',
            'password' => 'required|exists:users,password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Login success',
            ]);
        }
    }
}
