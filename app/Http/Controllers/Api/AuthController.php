<?php

namespace LaravelACL\Http\Controllers\Api;

use Illuminate\Http\Request;
use LaravelACL\Entities\User;
use LaravelACL\Repositories\UserRepository;

class AuthController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;


    public function __construct(UserRepository $repository)
    {
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        /** @var User $user */
        if (!$user = $this->repository->findByField('username', $credentials['username'])->first()) {
            return response()->json(['error' => 'Username not found'], 401);
        }

        if (!$token = \JWTAuth::attempt($credentials, $user->customClaims())) {
            return response()->json(['error' => 'Invalid credentiais'], 401);
        }

        auth()->login($user);

        return response()->json(compact('token'));
    }

    /**
     * To revoke token JWT
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
        \JWTAuth::invalidate();
        auth()->logout();
        return response()->json([], 204);
    }

    /**
     * Refresh token JWT
     * @SWG\Post(
     *     tags={"auth"},
     *     path="/refresh_token",
     *     @SWG\Parameter(
     *          name="Authorization", in="header", type="string", description="Bearer __token__"
     *     ),
     *     @SWG\Response(response="200", description="Token JWT")
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken(Request $request)
    {
        $bearerToken = \JWTAuth::setRequest($request)->getToken();
        $token = \JWTAuth::refresh($bearerToken);
        return response()->json(compact('token'));
    }

    /**
     * Get authenticated user
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
        $user = \JWTAuth::parseToken()->toUser();

        // needed for use criteria like 'with'
        $user = $this->repository->find($user->id);

        return response()->json($user);
    }
}
