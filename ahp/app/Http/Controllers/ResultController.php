<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\User;
use App\Http\Models\Selection;
use Auth;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role_id = Auth::user()->roleId();

        if ($role_id == 1 || $role_id == 3 || $role_id == 4 || $role_id == 5 ||$role_id == 6) {
            $i = 0;
            $result = Selection::select('selections.*', 'users.identity_number','users.name AS name_registrant', 'selection_schedules.date', 
                                            'selection_schedules.time', 'sub_vocationals.name AS name_sub_vocational')
                                        ->join('registrations', 'registrations.id', '=', 'selections.registration_id')
                                        ->join('registrants', 'registrants.id', '=', 'registrations.registrant_id')
                                        ->join('users', 'users.id', '=', 'registrants.user_id')
                                        ->join('selection_schedules', 'selection_schedules.id', '=', 'selections.selection_schedule_id')
                                        ->join('sub_vocationals', 'sub_vocationals.id', '=', 'selection_schedules.sub_vocational_id')
                                        ->where('selections.status', '=', 'Selesai')
                                        ->orderBy('selections.final_score','DESC')
                                        ->orderBy('users.name','ASC')
                                        ->get();

            return view('result.index',compact('result','i'));
        } else {
            return redirect()->route('profile_users.show');
        }
    }
}
