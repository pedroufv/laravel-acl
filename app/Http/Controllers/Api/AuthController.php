<?php

namespace LaravelACL\Http\Controllers\Api;

use LaravelACL\Repositories\UserRepository;

class AuthController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;


    public function __construct(UserRepository $repository)
    {
        $this->middleware('auth:api', ['except' => ['login']]);
        $this->repository = $repository;
    }

    /**
     * Request token JWT
     *
     * @SWG\Post(
     *     tags={"auth"},
     *     path="/login",
     *     @SWG\Parameter(
     *          name="body", in="body", required=true,
     *          @SWG\Schema(
     *              @SWG\Property(property="username", type="string"),
     *              @SWG\Property(property="password", type="string"),
     *          )
     *     ),
     *     @SWG\Response(
     *          response="200", description="Token JWT"
     *     )
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['username', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * To revoke token JWT
     *
     * @SWG\Post(
     *     tags={"auth"},
     *     path="/logout",
     *     @SWG\Parameter(
     *          name="Authorization", in="header", type="string", description="Bearer __token__"
     *     ),
     *     @SWG\Response(response="204", description="No content")
     * )
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh token JWT
     *
     * @SWG\Post(
     *     tags={"auth"},
     *     path="/refresh",
     *     @SWG\Parameter(
     *          name="Authorization", in="header", type="string", description="Bearer __token__"
     *     ),
     *     @SWG\Response(response="200", description="Token JWT")
     * )
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get authenticated user
     *
     * @SWG\Get(
     *     tags={"auth"},
     *     path="/me",
     *     @SWG\Parameter(
     *          name="Authorization", in="header", type="string", description="Bearer __token__"
     *     ),
     *     @SWG\Parameter(
     *          name="with", in="query", type="string",  description="Add relationship"
     *     ),
     *     @SWG\Parameter(
     *          name="filter", in="query", type="string",  description="Show only filtered"
     *     ),
     *     @SWG\Response(response="200", description="Get auth user")
     * )
     */
    public function me()
    {
        $user = $this->repository->find(auth()->id());

        return response()->json($user);
    }

    /**
     * Get the token array structure.
     *
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
