<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\User;
use App\Http\Models\Role;
use App\Http\Models\Registrant;
use DB;
use Hash;
use Auth;

class UserController extends Controller
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
            $data = User::orderBy('id','DESC')->paginate(10);

            return view('users.index',compact('data'))
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
            $roles = Role::lists('display_name','id');

            return view('users.create',compact('roles'));
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
            'name' => 'required',
            'identity_number' => 'required|unique:users,identity_number',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }

        return redirect()->route('users.index')
                        ->with('success','User berhasil dibuat');
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
            $user = User::find($id);
            
            return view('users.show',compact('user'));
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
            $user = User::find($id);
            $roles = Role::lists('display_name','id');
            $userRole = $user->roles->lists('id','id')->toArray();

            return view('users.edit',compact('user','roles','userRole'));
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
            'name' => 'required',
            'identity_number' => 'required|unique:users,identity_number,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) { 
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input,array('password'));    
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('role_user')->where('user_id',$id)->delete();

        
        foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }

        return redirect()->route('users.index')
                        ->with('success','User berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $registrant = Registrant::where('user_id', '=', $id)->first();
        
        if ($registrant == null) {
            User::find($id)->delete();

            return redirect()->route('users.index')
                             ->with('success','User berhasil dihapus');
        } else {
            return redirect()->route('users.index')
                             ->with('failed','Pendaftar tidak bisa dihapus karena sudah memiliki detail data pendaftar');
        } 
    }
}