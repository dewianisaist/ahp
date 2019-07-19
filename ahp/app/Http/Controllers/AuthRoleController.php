<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\User;
use App\Http\Models\Role;
use Auth;

class AuthRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        return view('auth_role.index',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth = Auth::user();
        $input = $request->all();
        $role_id = $input['auth_role'];
        $auth->setRoleId($role_id);

        /**
         * role_id 1 is staf
         * role_id 2 is pendaftar
         * others (role_id 3, 4, 5, 6) are kepala, kasubag_tu, koor_instruktur, kajur
         */
        if ($role_id == 1) { 
            return redirect()->route('users.index');
        } 
        elseif ($role_id == 2) {
            return redirect()->route('registrants.index');
        }
        else {
            return redirect()->route('manage_registrants.index');
        }
    }
}
