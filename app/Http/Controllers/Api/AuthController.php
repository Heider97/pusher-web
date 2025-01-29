<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Pusher\Pusher;

class AuthController extends Controller
{
    // Inicio de sesión
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(['message' => 'Credenciales incorrectas']);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user]);
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Cierre de sesión exitoso']);
    }


    public function pusher(Request $request)
    {
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options')
        );

        if ($request->has(['socket_id', 'channel_name'])) {

            if(str_contains($request->input('channel_name'), 'private-')){
                return $pusher->authorizeChannel(
                    $request->input('channel_name'),
                    $request->input('socket_id'),
                );
            } else if (str_contains($request->input('channel_name'), 'presence-')) {
                return $pusher->authorizePresenceChannel(
                    $request->input('channel_name'),
                    $request->input('socket_id'),
                    $request->user()->id,
                    [
                        'id' => $request->user()->id,
                        'name' => $request->user()->name,
                    ]
                );
            } else {
                return response()->json(['message' => 'Canal no autorizado'], 403);
            }
        }

        return response()->json(['message' => 'Faltan datos'], 400);
    }

    public function subscribed(Request $request)
    {
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options')
        );

        if ($request->has(['user_id', 'channel_name'])) {

            if(str_contains($request->input('channel_name'), 'private-')){
                return $pusher->authorizeChannel(
                    $request->input('channel_name'),
                    $request->input('socket_id'),
                );
            } else if (str_contains($request->input('channel_name'), 'presence-')) {
                return $pusher->authorizePresenceChannel(
                    $request->input('channel_name'),
                    $request->input('socket_id'),
                    $request->user()->id,
                    [
                        'id' => $request->user()->id,
                        'name' => $request->user()->name,
                    ]
                );
            } else {
                return response()->json(['message' => 'Canal no autorizado'], 403);
            }
        }

        return response()->json(['message' => 'Faltan datos'], 400);
    }
}
