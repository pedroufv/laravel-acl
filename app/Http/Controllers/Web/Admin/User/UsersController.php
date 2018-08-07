<?php

namespace LaravelACL\Http\Controllers\Web\Admin\User;

use LaravelACL\Entities\Role;
use LaravelACL\Entities\User;
use LaravelACL\Http\Controllers\Web\Controller;
use LaravelACL\Http\Requests\UserCreateRequest;
use LaravelACL\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class UsersController.
 *
 * @package namespace LaravelACL\Http\Controllers;
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
        return view('admin.users.index');
    }

    public function data()
    {
        $users = User::select(['id', 'name', 'username', 'email', 'created_at', 'updated_at', 'deleted_at']);

        if (request('withTrashed')) $users->withTrashed();

        if (request('onlyTrashed')) $users->onlyTrashed();

        return Datatables::of($users)
            ->editColumn('name', function ($user){
                return '<a href="'.route('admin.users.show', ['id' => $user]).'">'.$user->name.'</a>';
            })
            ->addColumn('action', function ($user) {
                return view('admin.partials.actions', ['entity' => $user, 'table' => 'users']);
            })
            ->rawColumns(['name', 'action'])
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

        return view('admin.users.create', compact('roles'));
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
            $user->roles()->sync($request->roles);

            return redirect()->route('admin.users.show', ['id' => $user->id])->with(['type' => 'success', 'message' => __('messages.success.store')]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['type' => 'danger', 'message' => __('messages.danger.create')])->withInput();
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
        return view('admin.users.show', ['entity' => $user, 'table' => 'users']);
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

        $roles = Role::getChecked($user);

        return view('admin.users.edit', compact('user', 'roles'));
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
            $user->roles()->sync($request->roles);

            return redirect()->route('admin.users.show', ['id' => $user->id])->with(['type' => 'success', 'message' => __('messages.success.update')]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['type' => 'danger', 'message' => __('messages.danger.update')])->withInput();
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

            $message = $user->trashed() ? 'messages.success.restore' : 'messages.success.destroy';
            $user->trashed() ? $user->restore() : $user->delete();

            return redirect()->back()->with(['type' => 'success', 'message' => __($message)]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['type' => 'danger', 'message' => __('messages.danger.destroy')])->withInput();
        }
    }
}
