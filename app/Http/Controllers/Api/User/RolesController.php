<?php

namespace LaravelACL\Http\Controllers\Api\User;

use LaravelACL\Http\Controllers\Api\Controller;
use LaravelACL\Repositories\RoleRepository;


class RolesController extends Controller
{

    /**
     * @var RoleRepository
     */
    protected $repository;


    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @SWG\Get(
     *     tags={"roles"},
     *     path="/roles",
     *     description="Roles List",
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
     *     @SWG\Response(response="200", description="Roles collection")
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->repository->all();
    }

    /**
     * Display the specified resource.
     *
     * @SWG\Get(
     *     tags={"roles"},
     *     path="/roles/{id}",
     *     description="Role Details",
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
     *     @SWG\Response(response="200", description="Role object")
     * )
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->repository->find($id);
    }
}
