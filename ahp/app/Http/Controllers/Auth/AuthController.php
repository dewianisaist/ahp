<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Validator;
use App\Http\Models\User;
use App\Http\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/authrole';
    protected $username = 'identity_number';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    public function postLogin(Request $request)
	{
		$this->validate($request, [
            'identity_number' => 'required|numeric', 
            'password' => 'required',
		]);
 
		$credentials = $request->only('identity_number', 'password');
 
		if ($this->auth->attempt($credentials, $request->has('remember')))
		{
			return redirect()->intended($this->redirectPath());
		}
 
		return redirect($this->loginPath())
					->withInput($request->only('identity_number', 'remember'))
					->withErrors([
						'identity_number' => $this->getFailedLoginMessage(),
					]);
	}

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:100',
            'identity_number' => 'required|max:20|unique:users',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $create = User::create([
            'identity_number' => $data['identity_number'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $user = User::find($create->id);
        $role = Role::whereName('pendaftar')->firstOrFail();
        $user->roles()->attach($role->id);

        return $create;
    }

}
