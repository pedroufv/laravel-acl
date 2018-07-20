<?php

namespace Ancora\Http\Controllers\User;

use Ancora\Entities\Role;
use Ancora\Entities\User;
use Ancora\Http\Controllers\Controller;
use Ancora\Http\Requests\UserCreateRequest;
use Ancora\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class UsersController.
 *
 * @package namespace Ancora\Http\Controllers;
 */
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
    }

    public function data()
    {
        $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at']);

        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                return '<a href="/admin/users/'.$user->id.'/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i>Edit</a>';
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();

        return view('users.create', compact('employees', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function store(UserCreateRequest $request)
    {
        try {

            $user = User::create($request->all());

            return redirect()->route('admin.users.show', ['id' => $user->id])->with(['type' => 'success', 'message' => __('messages.success.store')]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('admin.users.edit', [$user->id]);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest $request
     * @param  User $user
     *
     * @return Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $this->authorize('admin.users.edit', [$user->id]);

        try {

            $user->update($request->all());

            return redirect()->route('admin.users.show', ['id' => $user->id])->with(['type' => 'success', 'message' => __('messages.success.update')]);
        } catch (\Exception $e) {

            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user)
    {
        $this->authorize('admin.users.destroy', [$user->id]);

        try {

            $user->delete();

            return redirect()->back()->with(['type' => 'success', 'message' => __('messages.success.destroy')]);
        } catch (\Exception $e) {

            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }
}
