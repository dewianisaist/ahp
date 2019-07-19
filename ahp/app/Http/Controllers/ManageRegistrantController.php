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

class ManageRegistrantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role_id = Auth::user()->roleId();
        
        if ($role_id == 1 || $role_id == 3 || $role_id == 4 || $role_id == 5 || $role_id == 6) {
            $data = User::select('users.identity_number', 'users.name AS name_registrant', 'registrants.id AS id_registrant', 'sub_vocationals.name AS name_sub_vocational', 'registrations.register_date')
                    ->join('registrants', 'registrants.user_id', '=', 'users.id')
                    ->join('registrations', 'registrations.registrant_id', '=', 'registrants.id')
                    ->join('sub_vocationals', 'sub_vocationals.id', '=', 'registrations.sub_vocational_id')
                    ->orderBy('name_registrant','ASC')
                    ->paginate(10);

            return view('manage_registrants.index',compact('data'))
                ->with('i', ($request->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('registrants.index');
        }
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
        
        if ($role_id == 1 || $role_id == 3 || $role_id == 4 || $role_id == 5 || $role_id == 6) {
            $user = Registrant::select('users.*', 'registrants.*')
                                ->join('users','registrants.user_id', '=', 'users.id') 
                                ->find($id);
            
            $educations = EducationalBackground::with('education')
                                                ->whereRegistrantId($id)
                                                ->orderBy('education_id','DESC')
                                                ->get();
            
            $courses = CourseExperience::with('course')
                                        ->whereRegistrantId($id)
                                        ->orderBy('course_id','DESC')
                                        ->get();

            return view('manage_registrants.show',compact('user', 'educations', 'courses'));
        } else {
            return redirect()->route('registrants.index');
        }
    }
}