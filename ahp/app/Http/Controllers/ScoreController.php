<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Score;
use App\Http\Models\Alternative;
use App\Http\Models\Criteria;
use Auth;
use Carbon;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Alternative::orderBy('name','ASC')->paginate(10);
        // return $data;

        return view('score.index',compact('data'))
                    ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for assessment the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assessment($id)
    {
        $i = 0;
        $j = 0;

        $data = Alternative::where('id', '=', $id)->first();
        // return $data;

        $date_birth = Carbon\Carbon::parse($data->date_birth);
        $age = Carbon\Carbon::createFromDate($date_birth->year, $date_birth->month, $date_birth->day)->age;
        // return $age;

        $criterias = Criteria::where('global_weight', '<>', null)
                                ->orderBy('name','ASC')
                                ->get();
        
        $return_data = array();
        // return $data->id;

        foreach ($criterias as $criteria) {
            $single_data = array();
            $single_data["criteria"] = $criteria;
            $score = Score::where('alternative_id', '=', $data->id)
                            ->where('criteria_id', '=', $criteria->id)
                            ->first();
            if ($score == null) {
                $single_data["value"] = null;
            } else {
                $single_data["value"] = $score;
            }
            $return_data[] = $single_data;
        }
        //  return $return_data;

        return view('score.assessment',compact('data', 'age', 'return_data', 'i', 'j'));
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

        $criterias = Criteria::where('global_weight', '<>', null)
                                ->orderBy('name','ASC')
                                ->lists('id');
        
        //  return $criterias;
        foreach ($criterias as $criteria) {
            $score = Score::where('alternative_id', '=', $id)
                            ->where('criteria_id', '=', $criteria)
                            ->first();
            
            if ($input[$criteria] != "") {
                $data["alternative_id"] = $id;
                $data["criteria_id"] = $criteria;
                $data["value"] = $input[$criteria];
                if ($score == null) {
                    Score::create($data);
                } else {
                    Score::where('alternative_id', '=', $id)
                            ->where('criteria_id', '=', $criteria)
                            ->update($data);
                }
            } else {
                Score::where('alternative_id', '=', $id)
                        ->where('criteria_id', '=', $criteria)
                        ->delete();
            }
        }

        return redirect()->route('score.index')
                         ->with('success','Penilaian berhasil disimpan');
    }

    /**
     * Count all assessment of the resource
     * 
     * @return \Illuminate\Http\Response
     */
    public function count()
    {
        $alternatives = Alternative::orderBy('id','DESC')->get();

        $alternativesId = array();
        foreach ($alternatives as $alternative) {
            $alternativesId[] = $alternative->id;
            $alternativesData[$alternative->id] = $alternative;
        }

        $tabel_alternative = array();
        $criterias = Criteria::where('global_weight', '<>', null)
                                ->orderBy('id','DESC')
                                ->get();

        $criteriasData = array();
        foreach ($criterias as $criteria) {
            $criteriasData[$criteria->id] = $criteria;
        }

        foreach ($alternatives as $alternative) {
            $tabel_alternative[$alternative->id] = array();
            foreach ($criterias as $criteria) {
                $score = Score::where('alternative_id', '=', $alternative->id)
                                ->where('criteria_id', '=', $criteria->id)
                                ->first();
                                                    
                // return $score;
                if ($score == null) {
                    return redirect()->route('score.index')
                                     ->with('failed','Hitung penilaian GAGAL! '. $alternative->name . ' belum dinilai. Silahkan lakukan penilaian');
                } 
                $tabel_alternative[$alternative->id][$criteria->id] = $score->value;
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
        $n = count($alternativesId);
        foreach($alternativesId as $alternativeId1) {
            $sum_row = 0;
            $sum_col = 0;
            foreach($tabel_index[$alternativeId1] as $value) {
                $sum_row += $value;
            }
            foreach($alternativesId as $alternativeId2) {
                $sum_col += $tabel_index[$alternativeId2][$alternativeId1];
            }
            $tabel_leaving[$alternativeId1] = number_format((1 / ($n-1)) * $sum_row, 5);
            $tabel_entering[$alternativeId1] = number_format((1 / ($n-1)) * $sum_col, 5);
        }
        // return $tabel_entering;
        // return $tabel_leaving;

        $isComparable = true;
        $condition =array();
        foreach($alternativesId as $alternativeIdA) {
            foreach($alternativesId as $alternativeIdB) {
                if ($alternativeIdA < $alternativeIdB) {
                    $condition[$alternativeIdA.",".$alternativeIdB] = array();
                    $condition[$alternativeIdA.",".$alternativeIdB]["A Ii B"] = false; 
                    $condition[$alternativeIdA.",".$alternativeIdB]["A S+ B"] = false;
                    $condition[$alternativeIdA.",".$alternativeIdB]["A S- B"] = false;
                    $condition[$alternativeIdA.",".$alternativeIdB]["A Pi B"] = false;
                    $condition[$alternativeIdA.",".$alternativeIdB]["A R B"] = true;
                    $condition1 = ($tabel_leaving[$alternativeIdA] == $tabel_leaving[$alternativeIdB]) && ($tabel_entering[$alternativeIdA] == $tabel_entering[$alternativeIdB]);
                    $condition2a = ($tabel_leaving[$alternativeIdA] > $tabel_leaving[$alternativeIdB]) || ($tabel_leaving[$alternativeIdA] == $tabel_leaving[$alternativeIdB]);
                    $condition2b = ($tabel_entering[$alternativeIdA] < $tabel_entering[$alternativeIdB]) || ($tabel_entering[$alternativeIdA] == $tabel_entering[$alternativeIdB]);
                    if ($condition1) {
                        $condition[$alternativeIdA.",".$alternativeIdB]["A Ii B"] = true;
                    }
                    if ($condition2a) {
                        $condition[$alternativeIdA.",".$alternativeIdB]["A S+ B"] = true;
                    }
                    if ($condition2b) {
                        $condition[$alternativeIdA.",".$alternativeIdB]["A S- B"] = true;
                    }
                    if ($condition2a == $condition2b) {
                        $condition[$alternativeIdA.",".$alternativeIdB]["A Pi B"] = true;
                    }
                    if ($condition[$alternativeIdA.",".$alternativeIdB]["A Pi B"] || $condition[$alternativeIdA.",".$alternativeIdB]["A Ii B"]) {
                        $condition[$alternativeIdA.",".$alternativeIdB]["A R B"] = false;
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

        $sortedAlternative = array();
        $rank = 1;

        if ($isComparable) {
            arsort($tabel_leaving);
            foreach ($tabel_leaving as $key=>$value) {
                $sortedAlternative[] = $key;
                $alternative = $alternativesData[$key];
                $alternative->score_promethee = $value;
                $alternative->rank_promethee = $rank;
                $alternative->save();
                $rank ++;
            }
            // return $sortedAlternative;
        } else {
            $netflow = array();
            foreach ($tabel_leaving as $key=>$value) {
                $netflow[$key] = number_format($value - $tabel_entering[$key], 5);
            }
            
            arsort($netflow);
            foreach ($netflow as $key=>$value) {
                $sortedAlternative[] = $key;
                $alternative = $alternativesData[$key];
                $alternative->score_promethee = $value;
                $alternative->rank_promethee = $rank;
                $alternative->save();
                $rank ++;
            }
        }
        //  return $netflow;
        // return $sortedAlternative;

        return redirect()->route('score.index')
                         ->with('success','Hitung penilaian berhasil. Lihat hasil di menu "Hasil"');
    }
}
