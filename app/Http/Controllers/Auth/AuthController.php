<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;


class AuthController extends Controller
{
    private $client;
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = request(['username', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'res.incorrect',
            ], 401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Access Token', ['storage']);
        // auth('api')->login($user);
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();
        $request->headers->set('Authorization', 'Bearer ' . $tokenResult->accessToken);
        Cookie::queue('token', $tokenResult->accessToken);
        return response()->json([
            'status' => 'success',
            'message' => 'res.loginsuccess',
            'data' => [
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
            ],

        ]);
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
        ]);
        $user = new User;
        $user->first_name = $request->fName;
        $user->last_name = $request->lName;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!',
        ], 201);
    }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'status' => 'success',
            'message' => 'res.logout.success',
        ]);
    }
    public function user(Request $request)
    {
        return $request->user();
    }
    public function client(Request $request)
    {
        $user = $request->user();
        $clients = $user->Clients;
        return response()->json([
            'status' => 'success',
            'clients' => $clients
        ]);
    }
    public function create(Request $request)
    {
        try{
            $user = $request->user();
            $name = $request->name;
            $redirect = $request->redirect;
            $provider = $request->provider;
            $personalAccess = $request->personalAccess;
            $password = $request->password;
            $clientRepo =  App::make(ClientRepository::class);
            $clientRepo->create($user->id, $name, $redirect, $provider, $personalAccess, $password);
            return response()->json([
                'status' => 'success',
                'message' => 'res.add.success',
            ]);
        }catch (\Exception $e) {
            Log::error('Message JWT parser :' . $e->getMessage() . '--line: ' . $e->getLine());
            return response()->json([
                'status' => 'error',
                'message' => 'res.add.fail'
            ]);
        }

    }
    public function checkToken()
    {
        try{
            $auth = $this->client->getClient();
            return response()->json([
                'status' => true,
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
            ],403);
        }
    }
}
