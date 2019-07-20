<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\User;
use Hash;
use Auth;

class ProfileUserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $profile_user = User::find(Auth::user()->id);
        return view('profile_users.show',compact('profile_user'));
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $profile_user = User::find(Auth::user()->id);
        return view('profile_users.edit',compact('profile_user'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.Auth::user()->id,
            'password' => 'same:confirm-password',
        ]);

        $input = $request->all();

        if (!empty($input['password'])) { 
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input,array('password'));    
        }

        $profile_user = User::find(Auth::user()->id);
        
        $profile_user->update($input);

        return redirect()->route('profile_users.show')
                         ->with('success','Profil berhasil diedit');
    }
}
