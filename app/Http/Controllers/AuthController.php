<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken($fields['email'].$fields['name'].'tst')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // On retourne l'utilisateur de la base de données
        $user = User::where('email', $fields['email'])->first();

        // On vérifie si le password et l'email sont correcte
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'le login et/ou le mot de passe est invalide'
            ], 401);
        }

        $token = $user->createToken($fields['email'].$fields['name'].'tst')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request) {
       // $request->user()->tokens()->delete(); // Supprime tous le jetons d'authentifications associé à cet utilsateur
        $request->user()->currentAccessToken()->delete(); //Supprime le jeton actuel

        return [
            'message' => 'Vous vous etes bien déconnecté'
        ];
    }
}