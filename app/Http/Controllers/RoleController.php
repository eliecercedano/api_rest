<?php

namespace App\Http\Controllers;

use App\Models\Role;

use App\Http\Resources\RoleResource;
use App\Http\Resources\RoleCollection;

use Illuminate\Http\Request;

class RoleController extends Controller
{
     private $permission;
     private $paginate;

    public function __construct()
    {
        $this->middleware('auth:api');
        
        $this->permission = 'role';
        $this->paginate = 10;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( ! hasPermission($this->permission) )
            return response()->json(['message' => 'not authorized'], 403);

        return new RoleCollection(Role::with('permissions')->paginate($this->paginate));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( ! hasPermission($this->permission.'-store') )
            return response()->json(['message' => 'not authorized'], 403);

        $request->validate([
            'name' => 'required|string|max:255',
            'display_name' => 'required|string|max:255'
        ]);

        $role = new Role([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description
        ]);

        $role->save();

        if ($request->permissions)
            $role->syncPermissions($request->permissions);

        return new RoleResource($role);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        if ( ! hasPermission($this->permission.'-show') )
            return response()->json([
                'message' => 'not authorized'
            ], 403);

        return  new RoleResource($role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        if ( ! hasPermission($this->permission.'-update') )
            return response()->json(['message' => 'not authorized'], 403);

        $role->update($request->only(['name', 'display_name', 'description']));

        $permissions = $request->permissions ?? [];        
        $role->syncPermissions($request->permissions);
    
        return new RoleResource($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if ( ! hasPermission($this->permission.'-destroy') )
            return response()->json(['message' => 'not authorized'], 403);

        $role->delete();
        
        return response()->json([
            'message' => 'role deleted!'
        ], 204);
    }

}
