<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\ResultSelection;
use App\Http\Models\Selection;
use App\Http\Models\Criteria;
use App\Http\Models\Choice;
use App\Http\Models\EducationalBackground;
use App\Http\Models\CourseExperience;
use App\Http\Models\Upload;
use App\Http\Models\Registration;
use App\Http\Models\Subvocational;
use Auth;
use Carbon;

class ResultSelectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role_id = Auth::user()->roleId();

        if ($role_id == 3) {
            $data = Selection::select('selections.*', 'users.name AS name_registrant', 'selection_schedules.date', 
                                        'selection_schedules.time', 'sub_vocationals.name AS name_sub_vocational')
                                    ->join('registrations', 'registrations.id', '=', 'selections.registration_id')
                                    ->join('registrants', 'registrants.id', '=', 'registrations.registrant_id')
                                    ->join('users', 'users.id', '=', 'registrants.user_id')
                                    ->join('selection_schedules', 'selection_schedules.id', '=', 'selections.selection_schedule_id')
                                    ->join('sub_vocationals', 'sub_vocationals.id', '=', 'selection_schedules.sub_vocational_id')
                                    ->where(function($query){
                                        $query->whereNull('selections.status')
                                              ->orWhere('selections.status', '=', '');
                                    })
                                    ->orderBy('selections.id','DESC')
                                    ->paginate(10);
            // return $data;

            return view('result_selection.index',compact('data', 'result_selection'))
                        ->with('i', ($request->input('page', 1) - 1) * 10);
        } else {
            return redirect()->route('profile_users.show');
        }
    }

    /**
     * Show the form for assessment the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assessment($id)
    {
        $role_id = Auth::user()->roleId();

        if ($role_id == 3) {
            $i = 0;
            $j = 0;

            $data = Selection::select('selections.id AS ID_SELECTION', 'users.id AS ID_USER', 'registrants.id AS ID_REGISTRANT',
                                'users.*', 'registrants.*', 'selections.*')
                                ->join('registrations', 'registrations.id', '=', 'selections.registration_id')
                                ->join('registrants', 'registrants.id', '=', 'registrations.registrant_id')
                                ->join('users', 'users.id', '=', 'registrants.user_id')
                                ->where('selections.id', '=', $id)
                                ->first();
            // return $data;

            $date_birth = Carbon\Carbon::parse($data->date_birth);
            $age = Carbon\Carbon::createFromDate($date_birth->year, $date_birth->month, $date_birth->day)->age;
            // return $age;

            $check_result = ResultSelection::with('selection')
                                                ->where('selection_id', '=', $data->ID_SELECTION)
                                                ->first();
            // return $check_result;

            $educational_background = EducationalBackground::with('education')
                                                            ->where('registrant_id', '=', $data->ID_REGISTRANT)
                                                            ->orderBy('education_id','DESC')
                                                            ->get();
            // return $educational_background;

            $course_experience = CourseExperience::with('course')
                                                    ->where('registrant_id', '=', $data->ID_REGISTRANT)
                                                    ->get();
            // return $course_experience;

            $upload = Upload::where('registrant_id', '=', $data->ID_REGISTRANT)->first();
            // return $upload;

            $registration = Registration::select('registrations.id AS ID_REGISTRATION', 'selections.id AS ID_SELECTION', 
                                            'selection_schedules.id AS ID_SSCHEDULE', 'sub_vocationals.id AS ID_SUBVOC',
                                            'registrations.*', 'selections.*', 'selection_schedules.*', 'sub_vocationals.*')
                                            ->join('selections', 'selections.registration_id', '=', 'registrations.id')
                                            ->join('selection_schedules', 'selection_schedules.id', '=', 'selections.selection_schedule_id')
                                            ->join('sub_vocationals', 'sub_vocationals.id', '=', 'selection_schedules.sub_vocational_id')
                                            ->where('registrant_id', '=', $data->ID_REGISTRANT)
                                            ->orderBy('ID_SELECTION','DESC')
                                            ->get();
            // return $registration;

            $criterias = Criteria::where('step', '=', '2')
                                    ->where('status', '=', '1')
                                    ->where('description', '<>', null)
                                    ->whereNotIn('id', function($query){
                                        $query->select('criteria_id')
                                        ->from(with(new Choice)->getTable())
                                        ->where('suggestion', 1);
                                    })
                                    ->orderBy('id','DESC')->get();
            
            $return_data = array();
            // return $data->ID_SELECTION;

            foreach ($criterias as $criteria) {
                $single_data = array();
                $single_data["criteria"] = $criteria;
                $result_selection = ResultSelection::where('selection_id', '=', $data->ID_SELECTION)
                                                    ->where('criteria_id', '=', $criteria->id)
                                                    ->first();
                if ($result_selection == null) {
                    $single_data["value"] = null;
                } else {
                    $single_data["value"] = $result_selection;
                }
                $return_data[] = $single_data;
            }
            //  return $return_data;

            return view('result_selection.assessment',compact('data', 'age', 'check_result','educational_background','course_experience','upload','registration','return_data','i','j'));
        } else {
            return redirect()->route('profile_users.show');
        }
    }

    /**
     * Assess the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $input = $request->all();
        // return $input;

        $criterias = Criteria::where('step', '=', '2')
                                ->where('status', '=', '1')
                                ->where('description', '<>', null)
                                ->whereNotIn('id', function($query){
                                    $query->select('criteria_id')
                                    ->from(with(new Choice)->getTable())
                                    ->where('suggestion', 1);
                                })
                                ->orderBy('id','DESC')
                                ->lists('id');
        
        //  return $criterias;
        foreach ($criterias as $criteria) {
            $result_selection = ResultSelection::where('selection_id', '=', $id)
                                                ->where('criteria_id', '=', $criteria)
                                                ->first();
            
            if ($input[$criteria] != "") {
                $data["selection_id"] = $id;
                $data["criteria_id"] = $criteria;
                $data["value"] = $input[$criteria];
                if ($result_selection == null) {
                    ResultSelection::create($data);
                } else {
                    ResultSelection::where('selection_id', '=', $id)
                                    ->where('criteria_id', '=', $criteria)
                                    ->update($data);
                }
            } else {
                ResultSelection::where('selection_id', '=', $id)
                                ->where('criteria_id', '=', $criteria)
                                ->delete();
            }
        }

        return redirect()->route('result_selection.index')
                         ->with('success','Penilaian berhasil disimpan');
    }

    /**
     * Count all assessment of the resource
     * 
     * @return \Illuminate\Http\Response
     */
    public function count()
    {
        $selections = Selection::select('selections.*', 'users.name AS name_registrant', 'selection_schedules.date', 
                                        'selection_schedules.time', 'sub_vocationals.name AS name_sub_vocational')
                                    ->join('registrations', 'registrations.id', '=', 'selections.registration_id')
                                    ->join('registrants', 'registrants.id', '=', 'registrations.registrant_id')
                                    ->join('users', 'users.id', '=', 'registrants.user_id')
                                    ->join('selection_schedules', 'selection_schedules.id', '=', 'selections.selection_schedule_id')
                                    ->join('sub_vocationals', 'sub_vocationals.id', '=', 'selection_schedules.sub_vocational_id')
                                    ->where(function($query){
                                        $query->whereNull('selections.status')
                                              ->orWhere('selections.status', '=', '');
                                    })
                                    ->orderBy('selections.id','DESC')
                                    ->get();
        // return $selections;

        $selectionsId = array();
        foreach ($selections as $selection) {
            $selectionsId[] = $selection->id;
            $selectionsData[$selection->id] = $selection;
        }
        // return $selectionsData[$selection->id]->name_sub_vocational;

        $tabel_alternative = array();
        $criterias = Criteria::where('step', '=', '2')
                                    ->where('status', '=', '1')
                                    ->where('description', '<>', null)
                                    ->whereNotIn('id', function($query){
                                        $query->select('criteria_id')
                                        ->from(with(new Choice)->getTable())
                                        ->where('suggestion', 1);
                                    })
                                    ->orderBy('id','DESC')
                                    ->get();

        $criteriasData = array();
        foreach ($criterias as $criteria) {
            $criteriasData[$criteria->id] = $criteria;
        }

        foreach ($selections as $selection) {
            $tabel_alternative[$selection->id] = array();
            foreach ($criterias as $criteria) {
                $result_selection = ResultSelection::where('selection_id', '=', $selection->id)
                                                    ->where('criteria_id', '=', $criteria->id)
                                                    ->first();
                                                    
                // return $result_selection;
                if ($result_selection == null) {
                    return redirect()->route('result_selection.index')
                                     ->with('failed','Hitung penilaian GAGAL! '. $selection->name_registrant . ' belum dinilai. Silahkan lakukan penilaian');
                } 
                $tabel_alternative[$selection->id][$criteria->id] = $result_selection->value;
            }
        }

        // return $tabel_alternative;
        $tabel_selisih = array();
        foreach ($tabel_alternative as $key1=>$data_selisih1) {
            foreach ($tabel_alternative as $key2=>$data_selisih2) {
                if ($key1 != $key2) {
                    $tabel_selisih[$key1.",".$key2] = array();
                    foreach ($data_selisih1 as $criteria=>$value) {
                        $tabel_selisih[$key1.",".$key2][$criteria] = $value - $data_selisih2[$criteria];
                    }
                }
            }
        }
        // return $tabel_selisih;

        $tabel_derajat = array();
        // return $criteriasData;
        foreach ($tabel_selisih as $alternatives=>$crt_data) {
            $tabel_derajat[$alternatives] = array();
            foreach ($crt_data as $criteriaId=>$value) {
                $criteria = $criteriasData[$criteriaId];
                $type = $criteria->preference;
                
                switch ($type) {
                    case "1":
                        if ($value <= 0) {
                            $tabel_derajat[$alternatives][$criteriaId] = 0;
                        } else {
                            $tabel_derajat[$alternatives][$criteriaId] = 1;
                        }
                        break;
                    case "2":
                        $q = $criteria->parameter_q;

                        if ($value <= $q) {
                            $tabel_derajat[$alternatives][$criteriaId] = 0;
                        } else {
                            $tabel_derajat[$alternatives][$criteriaId] = 1;
                        }
                        break;
                    case "3":
                        $p = $criteria->parameter_p;
                        
                        if ($value <= 0) {
                            $tabel_derajat[$alternatives][$criteriaId] = 0;
                        } else if($value > $p) {
                            $tabel_derajat[$alternatives][$criteriaId] = 1;
                        } else {
                            $tabel_derajat[$alternatives][$criteriaId] = $value / $p;
                        }
                        break;
                    case "4":
                        $p = $criteria->parameter_p;
                        $q = $criteria->parameter_q;

                        if ($value <= $q) {
                            $tabel_derajat[$alternatives][$criteriaId] = 0;
                        } else if ($value > $p) {
                            $tabel_derajat[$alternatives][$criteriaId] = 1;
                        } else {
                            $tabel_derajat[$alternatives][$criteriaId] = 0.5;
                        }
                        break;
                    case "5":
                        $p = $criteria->parameter_p;
                        $q = $criteria->parameter_q;

                        if ($value <= $q) {
                            $tabel_derajat[$alternatives][$criteriaId] = 0;
                        } else if ($value > $p) {
                            $tabel_derajat[$alternatives][$criteriaId] = 1;
                        } else {
                            $tabel_derajat[$alternatives][$criteriaId] = ($value - $q)/($p - $q);
                        }
                        break;
                    case "6":
                        $e = 2.71828;
                        $s = $criteria->parameter_s;

                        if ($value <= 0) {
                            $tabel_derajat[$alternatives][$criteriaId] = 0;
                        } else {
                            $pow_d = pow($value, 2);
                            $pow_s = pow($s, 2);
                            $pow_val = -($pow_d / (2 * $pow_s));
                            $pow_e = pow($e, $pow_val);
                            $tabel_derajat[$alternatives][$criteriaId] = 1 - $pow_e;
                        }
                        break;
                    default:
                        $tabel_derajat[$alternatives][$criteriaId] = "-";
                        break;
                }
            }
        }
        // return $tabel_derajat;

        $tabel_index = array();
        foreach ($tabel_derajat as $alternatives=>$data_index) {
            $alternativesId = explode(",",$alternatives);
            $id1 = $alternativesId[0];
            $id2 = $alternativesId[1];
            $tabel_index[$id1][$id2] = 0;
            $tabel_index[$id1][$id1] = 0;
            $tabel_index[$id2][$id2] = 0;
            foreach ($data_index as $criteriaId=>$value) {
                $criteria = $criteriasData[$criteriaId];
                $bobot = $criteria->global_weight;
                $mlt = $bobot * $value;
                $tabel_index[$id1][$id2] += number_format($mlt,5);
            }
        }
        // return $tabel_index;

        $tabel_leaving = array();
        $tabel_entering = array();
        $n = count($selectionsId);
        foreach($selectionsId as $selectionId1) {
            $sum_row = 0;
            $sum_col = 0;
            foreach($tabel_index[$selectionId1] as $value) {
                $sum_row += $value;
            }
            foreach($selectionsId as $selectionId2) {
                $sum_col += $tabel_index[$selectionId2][$selectionId1];
            }
            $tabel_leaving[$selectionId1] = number_format((1 / ($n-1)) * $sum_row, 5);
            $tabel_entering[$selectionId1] = number_format((1 / ($n-1)) * $sum_col, 5);
        }
        // return $tabel_entering;
        // return $tabel_leaving;

        $isComparable = true;
        $condition =array();
        foreach($selectionsId as $selectionIdA) {
            foreach($selectionsId as $selectionIdB) {
                if ($selectionIdA < $selectionIdB) {
                    $condition[$selectionIdA.",".$selectionIdB] = array();
                    $condition[$selectionIdA.",".$selectionIdB]["A Ii B"] = false; 
                    $condition[$selectionIdA.",".$selectionIdB]["A S+ B"] = false;
                    $condition[$selectionIdA.",".$selectionIdB]["A S- B"] = false;
                    $condition[$selectionIdA.",".$selectionIdB]["A Pi B"] = false;
                    $condition[$selectionIdA.",".$selectionIdB]["A R B"] = true;
                    $condition1 = ($tabel_leaving[$selectionIdA] == $tabel_leaving[$selectionIdB]) && ($tabel_entering[$selectionIdA] == $tabel_entering[$selectionIdB]);
                    $condition2a = ($tabel_leaving[$selectionIdA] > $tabel_leaving[$selectionIdB]) || ($tabel_leaving[$selectionIdA] == $tabel_leaving[$selectionIdB]);
                    $condition2b = ($tabel_entering[$selectionIdA] < $tabel_entering[$selectionIdB]) || ($tabel_entering[$selectionIdA] == $tabel_entering[$selectionIdB]);
                    if ($condition1) {
                        $condition[$selectionIdA.",".$selectionIdB]["A Ii B"] = true;
                    }
                    if ($condition2a) {
                        $condition[$selectionIdA.",".$selectionIdB]["A S+ B"] = true;
                    }
                    if ($condition2b) {
                        $condition[$selectionIdA.",".$selectionIdB]["A S- B"] = true;
                    }
                    if ($condition2a == $condition2b) {
                        $condition[$selectionIdA.",".$selectionIdB]["A Pi B"] = true;
                    }
                    if ($condition[$selectionIdA.",".$selectionIdB]["A Pi B"] || $condition[$selectionIdA.",".$selectionIdB]["A Ii B"]) {
                        $condition[$selectionIdA.",".$selectionIdB]["A R B"] = false;
                    } else {
                        $isComparable = false;
                    }
                }
            }
        }
        // return $condition;

        // if($isComparable) {
        //     return "Comparable";
        // } else {
        //     return "Incomparable";
        // }

        $sortedSelection = array();
        $rank = 1;

        if ($isComparable) {
            arsort($tabel_leaving);
            foreach ($tabel_leaving as $key=>$value) {
                $sortedSelection[] = $key;
                $selection = $selectionsData[$key];
                $selection->final_score = $value;
                $selection->ranking = $rank;
                $selection->status = "Selesai";
                $selection->save();
                $rank ++;
            }
            // return $sortedSelection;
        } else {
            $netflow = array();
            foreach ($tabel_leaving as $key=>$value) {
                $netflow[$key] = number_format($value - $tabel_entering[$key], 5);
            }
            
            arsort($netflow);
            foreach ($netflow as $key=>$value) {
                $sortedSelection[] = $key;
                $selection = $selectionsData[$key];
                $selection->final_score = $value;
                $selection->ranking = $rank;
                $selection->status = "Selesai";
                $selection->save();
                $rank ++;
            }
        }
        //  return $netflow;
        // return $sortedSelection;

        return redirect()->route('result_selection.index')
                         ->with('success','Hitung penilaian berhasil. Lihat hasil di menu "Hasil"');
    }
}
