<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Permission;
use App\Http\Resources\PermissionResource;

class PermissionController extends Controller
{
     private $permission;
     private $paginate;

    public function __construct()
    {
        $this->middleware('auth:api');
        
        $this->permission = 'permission';
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

        return PermissionResource::collection(Permission::paginate($this->paginate));
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

        $permission = new Permission([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description
        ]);
        
        $permission->save();

        return new PermissionResource($permission);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        if ( ! hasPermission($this->permission.'-show') )
            return response()->json(['message' => 'not authorized'], 403);

        return  new PermissionResource($permission);
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
    public function update(Request $request, Permission $permission)
    {
        if ( ! hasPermission($this->permission.'-update') )
            return response()->json(['message' => 'not authorized'], 403);

        $permission->update($request->only(['name', 'display_name', 'description']));
    
        return new PermissionResource($permission);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        if ( ! hasPermission($this->permission.'-destroy') )
            return response()->json(['message' => 'not authorized'], 403);

        $permission->delete();
        
        return response()->json([
            'message' => 'permission deleted!'
        ], 204);
    }

}
