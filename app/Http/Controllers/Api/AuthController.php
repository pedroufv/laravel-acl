<?php

namespace Ancora\Http\Controllers\Api;

use Ancora\Entities\User;
use Ancora\Repositories\UserRepository;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

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
     *              @SWG\Property(property="email", type="string"),
     *              @SWG\Property(property="password", type="string"),
     *          )
     *     ),
     *     @SWG\Response(
     *          response="200", description="Token JWT"
     *     )
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {

            /** @var User $user */
            if (!$user = $this->repository->findByField('email', $credentials['email'])->first()) {
                return response()->json(['error' => 'e-mail not find'], 401);
            }

            if (!$token = \JWTAuth::attempt($credentials, $user->customClaims())) {
                return response()->json(['error' => 'Invalid credentiais'], 401);
            }

            \Auth::login($user);

        } catch (JWTException $ex) {
            return response()->json(['error' => 'Could not generate token'], 500);
        };

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
        try {
            \JWTAuth::invalidate();
            \Auth::logout();
        } catch (JWTException $ex) {
            return response()->json(['error' => 'Could not invalidate token'], 500);
        }
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
     */
    public function refreshToken(Request $request)
    {
        try {
            $bearerToken = \JWTAuth::setRequest($request)->getToken();
            $token = \JWTAuth::refresh($bearerToken);
        } catch (JWTException $exception) {
            return response()->json(['error' => 'Failed to update token'], 500);
        }
        return response()->json(compact('token'));
    }

    /**
     * Get authenticated user
     * @SWG\Get(
     *     tags={"auth"},
     *     path="/auth/user",
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
    public function user(Request $request)
    {
        $user = \JWTAuth::parseToken()->toUser();

        // needed for use criteria like 'with'
        $user = $this->repository->find($user->id);

        return response()->json($user);
    }
}
