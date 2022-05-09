<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Login
     * @OA\Post (
     *     path="/api/auth/login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "email":"user@user.com",
     *                     "password":"secret"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2FwaVwvYXV0aFwvbG9naW4iLCJpYXQiOjE2NTIwOTMzMzksImV4cCI6MTY1MjA5NjkzOSwibmJmIjoxNjUyMDkzMzM5LCJqdGkiOiI3aGplek52VmhYSXR3TDloIiwic3ViIjoyLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.NcdIoqlL8JRL_cDFaA40cvNEAZOAVAqUN23ZlchuVng"),
     *              @OA\Property(property="token_type", type="string", example="bearer"),
     *              @OA\Property(property="expires_in", type="string", example="3600"),
     *              @OA\Property(property="user", type="object",
     *    					@OA\Property(property="id", type="string", example="2"),
     *    					@OA\Property(property="type", type="string", example="user"),
     *    					@OA\Property(property="name", type="string", example="Test User"),
     *    					@OA\Property(property="email", type="string", example="user@user.com"),
     *    					@OA\Property(property="email_verified_at", type="string", example="2022-05-01T15:57:41.000000Z"),
     *    					@OA\Property(property="password_changed_at", type="string", example="null"),
     *    					@OA\Property(property="active", type="string", example="1"),
     *    					@OA\Property(property="timezone", type="string", example="null"),
     *    					@OA\Property(property="last_login_at", type="string", example="null"),
     *    					@OA\Property(property="last_login_ip", type="string", example="null"),
     *    					@OA\Property(property="to_be_logged_out", type="string", example="0"),
     *    					@OA\Property(property="provider", type="string", example="null"),
     *    					@OA\Property(property="provider_id", type="string", example="null"),
     *    					@OA\Property(property="created_at", type="string", example="2022-05-01T15:57:41.000000Z"),
     *    					@OA\Property(property="updated_at", type="string", example="2022-05-01T15:57:41.000000Z"),
     *    					@OA\Property(property="deleted_at", type="string", example="null")
     *    			)),
     *          )
     *      )
     * )
     */
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = auth('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Register User
     * @OA\Post (
     *     path="/api/auth/register",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "name":"Test User",
     *                     "email":"user@user.com",
     *                     "password":"secret"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="User successfully registered"),
     *              @OA\Property(property="user", type="object",
     *    					@OA\Property(property="name", type="string", example="Test User"),
     *    					@OA\Property(property="email", type="string", example="user@user.com"),
     *    					@OA\Property(property="created_at", type="string", example="2022-05-01T15:57:41.000000Z"),
     *    					@OA\Property(property="updated_at", type="string", example="2022-05-01T15:57:41.000000Z"),
     *    					@OA\Property(property="id", type="string", example="2"),
     *    			)),
     *          )
     *      )
     * )
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    /**
     * Logout
     * @OA\Post (
     *     path="/api/auth/logout",
     *     tags={"Auth"},
     *     security={{"bearer_token":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="User successfully signed out")
     *          )
     *      )
     * )
     */
    public function logout() {
        auth('api')->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth('api')->refresh());
    }

    /**
     * User Profile
     * @OA\Get (
     *     path="/api/auth/user-profile",
     *     tags={"Auth"},
     *     security={{"bearer_token":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="user", type="object",
     *    					@OA\Property(property="id", type="string", example="2"),
     *    					@OA\Property(property="type", type="string", example="user"),
     *    					@OA\Property(property="name", type="string", example="Test User"),
     *    					@OA\Property(property="email", type="string", example="user@user.com"),
     *    					@OA\Property(property="email_verified_at", type="string", example="2022-05-01T15:57:41.000000Z"),
     *    					@OA\Property(property="password_changed_at", type="string", example="null"),
     *    					@OA\Property(property="active", type="string", example="1"),
     *    					@OA\Property(property="timezone", type="string", example="null"),
     *    					@OA\Property(property="last_login_at", type="string", example="null"),
     *    					@OA\Property(property="last_login_ip", type="string", example="null"),
     *    					@OA\Property(property="to_be_logged_out", type="string", example="0"),
     *    					@OA\Property(property="provider", type="string", example="null"),
     *    					@OA\Property(property="provider_id", type="string", example="null"),
     *    					@OA\Property(property="created_at", type="string", example="2022-05-01T15:57:41.000000Z"),
     *    					@OA\Property(property="updated_at", type="string", example="2022-05-01T15:57:41.000000Z"),
     *    					@OA\Property(property="deleted_at", type="string", example="null")
     *    			)),
     *          )
     *      )
     * )
     */
    public function userProfile() {
        return response()->json(auth('api')->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ]);
    }

    public function changePassWord(Request $request) {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string|min:6',
            'new_password' => 'required|string|confirmed|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $userId = auth('api')->user()->id;

        $user = User::where('id', $userId)->update(
            ['password' => bcrypt($request->new_password)]
        );

        return response()->json([
            'message' => 'User successfully changed password',
            'user' => $user,
        ], 201);
    }
}
