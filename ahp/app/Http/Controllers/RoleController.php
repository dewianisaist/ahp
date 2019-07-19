<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Role;
use App\Http\Models\Permission;
use DB;
use Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role_id = Auth::user()->roleId();
        
        if ($role_id == 1) {
            $roles = Role::orderBy('id','DESC')->paginate(10);

            return view('roles.index',compact('roles'))
                ->with('i', ($request->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('profile_users.show');
        } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role_id = Auth::user()->roleId();
        
        if ($role_id == 1) {
            $permission = Permission::get();

            return view('roles.create',compact('permission'));
        } else {
            return redirect()->route('profile_users.show');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'display_name' => 'required',
            'description' => 'required',
            'permission' => 'required',
        ]);

        $role = new Role();
        $role->name = $request->input('name');
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');
        $role->save();

        foreach ($request->input('permission') as $key => $value) {
            $role->attachPermission($value);
        }

        return redirect()->route('roles.index')
                        ->with('success','Role berhasil dibuat');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role_id = Auth::user()->roleId();
        
        if ($role_id == 1) {
            $role = Role::find($id);
            $rolePermissions = Permission::join("permission_role","permission_role.permission_id","=","permissions.id")
                                            ->where("permission_role.role_id",$id)
                                            ->get();

            return view('roles.show',compact('role','rolePermissions'));
        } else {
            return redirect()->route('profile_users.show');
        } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role_id = Auth::user()->roleId();
        
        if ($role_id == 1) {
            $role = Role::find($id);
            $permission = Permission::get();
            $rolePermissions = DB::table("permission_role")
                                    ->where("permission_role.role_id",$id)
                                    ->lists('permission_role.permission_id','permission_role.permission_id');

            return view('roles.edit',compact('role','permission','rolePermissions'));
        } else {
            return redirect()->route('profile_users.show');
        } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'display_name' => 'required',
            'description' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');
        $role->save();

        DB::table("permission_role")->where("permission_role.role_id",$id)->delete();

        foreach ($request->input('permission') as $key => $value) {
            $role->attachPermission($value);
        }

        return redirect()->route('roles.index')
                        ->with('success','Role berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("role_user")->join('roles','roles.id','=','role_user.role_id')
                              ->where('role_user.role_id', '=', $id)
                              ->delete();
                              
        Role::where('id',$id)->delete();
        
        return redirect()->route('roles.index')
                        ->with('success','Role berhasil dihapus');
    }
}
