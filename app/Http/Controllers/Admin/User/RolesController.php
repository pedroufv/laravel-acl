<?php

namespace Ancora\Http\Controllers\Admin\User;

use Ancora\Entities\Permission;
use Ancora\Entities\Role;
use Ancora\Http\Controllers\Controller;
use Ancora\Http\Requests\RoleCreateRequest;
use Ancora\Http\Requests\RoleUpdateRequest;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class RolesController.
 *
 * @package namespace Ancora\Http\Controllers;
 */
class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.roles.index');
    }

    public function data()
    {
        $roles = Role::select(['id', 'name', 'label']);

        return Datatables::of($roles)
            ->editColumn('name', function ($role){
                return '<a href="'.route('admin.roles.show', ['id' => $role->id]).'">'.$role->name.'</a>';
            })
            ->addColumn('action', function ($role) {
                return view('admin.partials.actions', ['id' => $role->id, 'table' => 'roles']);
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
        $permissionsGrouped = Permission::getGroupedAndChecked();

        return view('admin.roles.create', compact('employees', 'permissionsGrouped'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoleCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function store(RoleCreateRequest $request)
    {
        try {

            $role = Role::create($request->all());
            $role->permissions()->sync($request->permissions);

            return redirect()->route('admin.roles.show', ['id' => $role->id])->with(['type' => 'success', 'message' => __('messages.success.store')]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['type' => 'danger', 'message' => __('messages.danger.create')])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Role $role
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $permissionsGrouped = Permission::getGroupedAndChecked($role);

        return view('admin.roles.show', compact('role', 'permissionsGrouped'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Role $role
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissionsGrouped = Permission::getGroupedAndChecked($role);

        return view('admin.roles.edit', compact('role', 'permissionsGrouped'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RoleUpdateRequest $request
     * @param  Role $role
     *
     * @return Response
     *
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        try {

            $role->update($request->all());
            $role->permissions()->sync($request->permissions);

            return redirect()->route('admin.roles.show', ['id' => $role->id])->with(['type' => 'success', 'message' => __('messages.success.update')]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['type' => 'danger', 'message' => __('messages.danger.update')])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role $role
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        try {

            $role->delete();

            return redirect()->back()->with(['type' => 'success', 'message' => __('messages.success.destroy')]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['type' => 'danger', 'message' => __('messages.danger.destroy')])->withInput();
        }
    }
}
