<?php

namespace LaravelACL\Http\Controllers\Api\User;

use LaravelACL\Http\Controllers\Api\Controller;
use LaravelACL\Http\Requests\UserCreateRequest;
use LaravelACL\Http\Requests\UserUpdateRequest;
use LaravelACL\Repositories\UserRepository;
use Illuminate\Http\Request;


class UsersController extends Controller
{

    /**
     * @var UserRepository
     */
    protected $repository;


    public function __construct(UserRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }


    /**
     * Display a listing of the resource.
     *
     * @SWG\Get(
     *     tags={"users"},
     *     path="/users",
     *     description="Users List",
     *     @SWG\Parameter(
     *          name="Authorization", in="header", type="string", description="Bearer __token__"
     *     ),
     *     @SWG\Parameter(
     *          name="with", in="query", type="string",  description="Add relationship"
     *     ),
     *     @SWG\Parameter(
     *          name="search", in="query", type="string",  description="Filter by value"
     *     ),
     *     @SWG\Parameter(
     *          name="searchFields", in="query", type="string",  description="Condition"
     *     ),
     *     @SWG\Parameter(
     *          name="searchJoin", in="query", type="string",  description="Filter by value"
     *     ),
     *     @SWG\Parameter(
     *          name="filter", in="query", type="string",  description="Show only filtered"
     *     ),
     *     @SWG\Parameter(
     *          name="orderBy", in="query", type="string",  description="Order by column"
     *     ),
     *     @SWG\Parameter(
     *          name="sortedBy", in="query", type="string",  description="Asc or Desc"
     *     ),
     *     @SWG\Parameter(
     *          name="page", in="query", type="integer",  description="Page number"
     *     ),
     *     @SWG\Parameter(
     *          name="limit", in="query", type="integer",  description="Itens per page"
     *     ),
     *     @SWG\Response(response="200", description="Users collection")
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->has('limit') ?? $request->limit;

        return $this->repository->paginate($limit);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @SWG\Post(
     *     tags={"users"},
     *     path="/users",
     *     description="User create",
     *     @SWG\Parameter(
     *          name="Authorization", in="header", type="string", description="Bearer __token__"
     *     ),
     *     @SWG\Parameter(
     *          name="body", in="body", required=true,
     *       @SWG\Schema(
     *          @SWG\Property(
     *              property="name",
     *              type="string"
     *          ),
     *          @SWG\Property(
     *              property="username",
     *              type="string"
     *          ),
     *          @SWG\Property(
     *              property="email",
     *              type="string"
     *          ),
     *          @SWG\Property(
     *              property="password",
     *              type="string"
     *          ),
     *          @SWG\Property(
     *              property="password_confirmation",
     *              type="string"
     *          ),
     *          @SWG\Property(
     *               property="roles",
     *               type="array",
     *               @SWG\Items(
     *                  type="integer",
     *               ),
     *          ),
     *       )
     *     ),
     *     @SWG\Response(response="201", description="User created")
     * )
     * @param  UserCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $user = $this->repository->create($request->all());

        return response()->json($user, 201);
    }


    /**
     * Display the specified resource.
     *
     * @SWG\Get(
     *     tags={"users"},
     *     path="/users/{id}",
     *     description="User Details",
     *     @SWG\Parameter(
     *          name="Authorization", in="header", type="string", description="Bearer __token__"
     *     ),
     *     @SWG\Parameter(
     *          name="id", in="path", required=true, type="integer"
     *     ),
     *     @SWG\Parameter(
     *          name="with", in="query", type="string",  description="Add relationship"
     *     ),
     *     @SWG\Parameter(
     *          name="filter", in="query", type="string",  description="Show only filtered"
     *     ),
     *     @SWG\Response(response="200", description="User show")
     * )
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->repository->find($id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @SWG\Put(
     *     tags={"users"},
     *     path="/users/{id}",
     *     description="Update user",
     *     @SWG\Parameter(
     *          name="Authorization", in="header", type="string", description="Bearer __token__"
     *     ),
     *     @SWG\Parameter(
     *          name="id", in="path", required=true, type="integer"
     *     ),
     *     @SWG\Parameter(
     *          name="body", in="body", required=true,
     *      @SWG\Schema(
     *          @SWG\Property(property="name", type="string"),
     *          @SWG\Property(property="username", type="string"),
     *          @SWG\Property(property="email", type="string"),
     *          @SWG\Property(property="password", type="string"),
     *          @SWG\Property(property="password_confirmation", type="string"),
     *          @SWG\Property(
     *              property="roles",
     *              type="array",
     *              @SWG\Items(
     *                  type="integer",
     *               ),
     *          ),
     *       )
     *      ),
     *     @SWG\Response(response="200", description="User updated")
     * )
     * @param UserUpdateRequest $request
     * @param  string $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->repository->update($request->all(),$id);
        return response()->json($user, 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @SWG\Delete(
     *     tags={"users"},
     *     path="/users/{id}",
     *     description="Remove user",
     *     @SWG\Parameter(
     *          name="Authorization", in="header", type="string", description="Bearer __token__"
     *     ),
     *     @SWG\Parameter(
     *          name="id", in="path", required=true, type="integer"
     *     ),
     *     @SWG\Response(response="204", description="No content")
     * )
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
        return response()->json('', 204);;
    }
}
