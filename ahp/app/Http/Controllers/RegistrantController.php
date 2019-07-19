<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Registrant;
use App\Http\Models\User;
use App\Http\Models\Upload;
use App\Http\Models\Education;
use App\Http\Models\EducationalBackground;
use App\Http\Models\Course;
use App\Http\Models\CourseExperience;
use Auth;
use Hash;

class RegistrantController extends Controller
{
    /**
     * Display the specified resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $role_id = Auth::user()->roleId();
        $user = User::with('registrant', 'registrant.upload')->find(Auth::user()->id);

        if ($role_id == 2) {
            if ($user->registrant == null) {
                return redirect()->route('registrants.edit')
                                ->with('failed','Silahkan lengkapi data diri Anda dahulu.');
            } else {
                return view('registrants.index',compact('user'));
            }
        } else {
            return redirect()->route('profile_users.show');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $role_id = Auth::user()->roleId();

        if ($role_id == 2) {
            $user = User::with('registrant', 'registrant.upload')->find(Auth::user()->id);
            return view('registrants.edit',compact('user'));
        } else {
            return redirect()->route('profile_users.show');
        }
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
             'address' => 'required',
             'phone_number' => 'required',
             'place_birth' => 'required',
             'date_birth' => 'required',
             'photo' => 'mimes:jpeg,png,jpg|max:2048',
             'ktp' => 'mimes:pdf,doc,docx|max:2048',
             'last_certificate' => 'mimes:pdf,doc,docx|max:2048',
        ]);
        
        $input = $request->all();

        $user = User::find(Auth::user()->id);
        
        if (!empty($input['password'])) { 
            $input['password'] = Hash::make($input['password']);
        } else {
            $input['password'] = $user->password;    
        }
 
        $user->update(['name' => $input['name'], 
                        'email' => $input['email'], 
                        'password' => $input['password']]);
        
        $registrant = Registrant::firstOrCreate(['user_id' => Auth::user()->id]);
        $registrant->address = $input['address'];
        $registrant->phone_number = $input['phone_number'];
        $registrant->gender = $input['gender'];
        $registrant->place_birth = $input['place_birth'];
        $registrant->date_birth = $input['date_birth'];
        $registrant->order_child = $input['order_child'];
        $registrant->amount_sibling = $input['amount_sibling'];
        $registrant->religion = $input['religion'];
        $registrant->biological_mother_name = $input['biological_mother_name'];
        $registrant->father_name = $input['father_name'];
        $registrant->parent_address = $input['parent_address'];
        $registrant->save();

        $upload = Upload::firstOrNew(['registrant_id' => $registrant->id]);
        $photoName = '';
        if ($request->hasFile('photo')) {
            $photo = $request->input('photo');
            $photoExtension = $request->file('photo')->getClientOriginalExtension();
            $photoName = 'photo_'.md5(Auth::user()->id).'.'.$photoExtension;
            $photoDestination = base_path() . '/public/uploads';
            $request->file('photo')->move($photoDestination, $photoName);
            $upload->photo = $photoName;
        } else {
            $upload->photo;
        }
        
        $ktpName = '';
        if ($request->hasFile('ktp')) {
            $ktp = $request->input('ktp');
            $ktpExtension = $request->file('ktp')->getClientOriginalExtension();
            $ktpName = 'ktp_'.md5(Auth::user()->id).'.'.$ktpExtension;
            $ktpDestination = base_path() . '/public/uploads';
            $request->file('ktp')->move($ktpDestination, $ktpName);
            $upload->ktp = $ktpName;
        } else {
            $upload->ktp;
        }

        $lastcertificateName = '';
        if ($request->hasFile('last_certificate')) {
            $last_certificate = $request->input('last_certificate');
            $lastcertificateExtension = $request->file('last_certificate')->getClientOriginalExtension();
            $lastcertificateName = 'lastcertificate_'.md5(Auth::user()->id).'.'.$lastcertificateExtension;
            $lastcertificateDestination = base_path() . '/public/uploads';
            $request->file('last_certificate')->move($lastcertificateDestination, $lastcertificateName);
            $upload->last_certificate = $lastcertificateName;
        } else {
            $upload->last_certificate;
        }
        $upload->save();
 
        return redirect()->route('registrants.index')
                        ->with('success','Data diri berhasil disimpan');
    }
}
