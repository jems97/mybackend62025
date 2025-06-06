<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Events\UserSesion;

class AuthController extends Controller
{
    //
    public function signup(Request $request)
    {
        //Log::info('A validar...');
        //Validar si el usuario o el correo ya esta registrado en la bdd
        if(User::where('user_name', $request->user_name)->exists()){
            return response()->json(['msg' => 'Usuario ya registrado'], 409);
        }
        if(User::where('email', $request->email)->exists()){
            return response()->json(['msg' => 'Correo ya registrado'], 409);
        }
        $request->validate([
        'user_name' => 'required|unique:users',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed|min:8'
        ]);

        $user = new User();
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'status' => 'success',
            'msg' => 'Usuario registrado exitosamente'], 201);
    
    }

    public function login(Request $request)
    {
        $request->validate([
        'email' => 'required',
        'password' => 'required'
        ]);
        //verificar si el email esta registrado
        $user = User::where("email", "=", $request->email)->first();
        if(isset($user->id)){
            if(Hash::check($request->password, $user->password)){
                //token para acceso a listas de usuario
                $token = $user->createToken("auth_token")->plainTextToken;
                return response()->json([
                    "status" => "success",
                    "user" => $user,
                    "access_token" => $token
                ]);
            }else{
                return response()->json([
                "status" => "error",
                "msg" => "Contraseña incorrecta"
            ]);
            }
        }else{
            return response()->json([
                "status" => "error",
                "msg" => "Usuario no Registrado"
            ]);
        }
    
    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response()->json([
            "status" =>  "success",
            "msg" => "Cierre de Sesión",
        ]);
    }
}