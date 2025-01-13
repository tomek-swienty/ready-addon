<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(User $user)
    {
        // model as dependency injection
        $this->user = $user;
    }

    public function register(Request $request)
    {
       //return response()->json(['error' => 'asdasdsad'], 400);

        try {
            $validator = Validator::make($request->all(), [
                'name'      => 'required|string|max:255',
                'email'     => 'required|string|max:255|unique:users',
                'password'  => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            $user = $this->user::create([
                                            'name' => $request['name'],
                                            'email' => $request['email'],
                                            'password' => bcrypt($request['password']),
                                        ]);

            // login the user immediately and generate the token
            $token = auth()->login($user);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }


        // return the response as json
        return response()->json([
                                    'meta' => [
                                        'code' => 200,
                                        'status' => 'success',
                                        'message' => 'User created successfully!',
                                    ],
                                    'data' => [
                                        'user' => $user,
                                        'access_token' => [
                                            'token' => $token,
                                            'type' => 'Bearer',
                                            'expires_in' => auth()->factory()->getTTL() * 60,    // get token expires in seconds
                                        ],
                                    ],
                                ]);
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email'     => 'required|string',
            'password'  => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }


        // attempt a login (validate the credentials provided)
        $token = auth()->attempt([
                                     'email' => $request->email,
                                     'password' => $request->password,
                                 ]);

        // if token successfully generated then display success response
        // if attempt failed then "unauthenticated" will be returned automatically
        if ($token)
        {
            return response()->json([
                                        'meta' => [
                                            'code' => 200,
                                            'status' => 'success',
                                            'message' => 'Quote fetched successfully.',
                                        ],
                                        'data' => [
                                            'user' => auth()->user(),
                                            'access_token' => [
                                                'token' => $token,
                                                'type' => 'Bearer',
                                                'expires_in' => auth()->factory()->getTTL() * 60,
                                            ],
                                        ],
                                    ]);
        }
    }

    public function logout()
    {
        // get token
        $token = JWTAuth::getToken();

        // invalidate token
        $invalidate = JWTAuth::invalidate($token);

        if($invalidate) {
            return response()->json([
                                        'meta' => [
                                            'code' => 200,
                                            'status' => 'success',
                                            'message' => 'Successfully logged out',
                                        ],
                                        'data' => [],
                                    ]);
        }
    }
}
