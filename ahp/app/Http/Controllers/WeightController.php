<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Criteria;
use App\Http\Models\Choice;
use App\Http\Models\PairwiseComparison;
use Auth;

class WeightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role_id = Auth::user()->roleId();

        if ($role_id == 3) {
            $i = 0;
            $criterias = Criteria::where('step', '=', '2')
                                    ->where('status', '=', '1')
                                    ->where('group_criteria', '=', null)
                                    ->whereNotIn('id', function($query){
                                        $query->select('criteria_id')
                                        ->from(with(new Choice)->getTable())
                                        ->where('suggestion', 1);
                                    })
                                    ->get();

            $criterias_group = array();
            $total_criterias = 0;

            foreach ($criterias as $criteria) {
                $criterias_group[$criteria->id]["group"] = $criteria;
                $criterias_group[$criteria->id]["data"] = array();

                $subcriterias = Criteria::where('step', '=', '2')
                                            ->where('status', '=', '1')
                                            ->where('group_criteria', '=', $criteria->id)
                                            ->whereNotIn('id', function($query){
                                                $query->select('criteria_id')
                                                ->from(with(new Choice)->getTable())
                                                ->where('suggestion', 1);
                                            })
                                            ->orderBy('id','DESC')
                                            ->get();
                
                if (count($subcriterias) == 0) {
                    $criteria->global_weight = $criteria->partial_weight;
                    $criteria->save();
                }

                foreach ($subcriterias as $subcriteria) {
                    $subcriteria->global_weight = number_format($criteria->partial_weight * $subcriteria->partial_weight, 3);
                    $subcriteria->save();
                    $criterias_group[$criteria->id]["data"][] = $subcriteria;
                }

            }

            return view('weights.index', compact('criterias_group', 'i'));
        } else {
            return redirect()->route('profile_users.show');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $role_id = Auth::user()->roleId();

        if ($role_id == 3) {
            $i = 0;
            $requestedId = null;

            if ($id > 0) {
                $requestedId = $id;
            }

            $criterias = Criteria::where('step', '=', '2')
                                    ->where('status', '=', '1')
                                    ->where('group_criteria', '=', $requestedId)
                                    ->whereNotIn('id', function($query){
                                        $query->select('criteria_id')
                                        ->from(with(new Choice)->getTable())
                                        ->where('suggestion', 1);
                                    })
                                    ->orderBy('id','DESC')
                                    ->get();

            $compares = array();
            foreach ($criterias as $criteria1) {
                foreach ($criterias as $criteria2) {
                    if (!array_key_exists($criteria1->id.":".$criteria2->id,$compares) && !array_key_exists($criteria2->id.":".$criteria1->id,$compares) && $criteria1->id != $criteria2->id){
                        $data = array();
                        $data[] = $criteria1;
                        $data[] = $criteria2;
                        $compares[$criteria1->id.":".$criteria2->id] = array();
                        $compares[$criteria1->id.":".$criteria2->id]['criteria'] = $data;
                        $pairwises = PairwiseComparison::where(function($q) use ($criteria1, $criteria2) {
                            $q->where(function($query) use ($criteria1, $criteria2) {
                                    $query->where('criteria1_id','=', $criteria1->id)
                                        ->where('criteria2_id', $criteria2->id);
                                })
                            ->orWhere(function($query) use ($criteria1, $criteria2) {
                                    $query->where('criteria1_id', $criteria2->id)
                                        ->where('criteria2_id', $criteria1->id);
                                });
                            })
                            ->get();

                        $value = 0;
                        $selected_criteria = $criteria1->id;

                        foreach ($pairwises as $pairwise) {
                            if ($pairwise->value > $value) {
                                $value = $pairwise->value;
                                $selected_criteria = $pairwise->criteria1_id;
                            }
                        }
                        

                        $compares[$criteria1->id.":".$criteria2->id]['value'] = $value;
                        $compares[$criteria1->id.":".$criteria2->id]['selected_criteria'] = $selected_criteria;
                        $compares[$criteria1->id.":".$criteria2->id]['pairwise'] = $pairwises;
                    }
                }
            }

            // return $compares;
            return view('weights.pairwise',compact('compares', 'id','i'));
        } else {
            return redirect()->route('profile_users.show');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $i = 0;
        $requestedId = null;

        if ($id > 0) {
            $requestedId = $id;
        }

        $input = $request->all();
        $criterias = Criteria::where('step', '=', '2')
                                ->where('status', '=', '1')
                                ->where('group_criteria', '=', $requestedId)
                                ->whereNotIn('id', function($query){
                                    $query->select('criteria_id')
                                    ->from(with(new Choice)->getTable())
                                    ->where('suggestion', 1);
                                })
                                ->orderBy('id','DESC')
                                ->get();

        $pairwises = array();
        $count = 0;
        foreach ($criterias as $criteria1) {
            foreach ($criterias as $criteria2) {
                $data = array();
                $data["criteriaid_1"] = $criteria1->id;
                $data["criteriaid_2"] = $criteria2->id;

                if ($criteria1->id == $criteria2->id) {
                    $data["value"] = 1;
                } elseif (array_key_exists($criteria1->id.":".$criteria2->id,$input["criteria_id"])) {
                    $selected_id = $input["criteria_id"][$criteria1->id.":".$criteria2->id];
                    if ($selected_id == $criteria1->id) {
                        $data["value"] = $input["value"][$criteria1->id.":".$criteria2->id];
                    } else {
                        $data["value"] = 1 / $input["value"][$criteria1->id.":".$criteria2->id];
                    }
                } elseif (array_key_exists($criteria2->id.":".$criteria1->id,$input["criteria_id"])) {
                    $selected_id = $input["criteria_id"][$criteria2->id.":".$criteria1->id];
                    if ($selected_id == $criteria1->id) {
                        $data["value"] = $input["value"][$criteria2->id.":".$criteria1->id];
                    } else {
                        $data["value"] = 1 / $input["value"][$criteria2->id.":".$criteria1->id];
                    }
                }
                $pairwises[] = $data;
            }
        }

        $base_table = array();
        foreach ($pairwises as $pairwise){
            if (!array_key_exists($pairwise["criteriaid_1"],$base_table)) {
                $base_table[$pairwise["criteriaid_1"]] = array();
            }
            $base_table[$pairwise["criteriaid_1"]][$pairwise["criteriaid_2"]] = $pairwise["value"];
        }
        // return $base_table;

        $normalized_table = array();
        $total_basecol_val = array();
        foreach ($base_table as $row=>$row_val) { 
            if (!array_key_exists($row,$normalized_table)) {
                $normalized_table[$row] = array();
            }
            foreach ($row_val as $col=>$col_val) {
                $total_row_val = 0;
                $total_basecol_val[$col] = 0;
                foreach ($base_table as $r=>$each_row) {
                    foreach ($each_row as $c=>$c_val) {
                        if ($c == $col) {
                            $total_row_val += $c_val;
                            $total_basecol_val[$col] += $c_val;
                            break;
                        }
                    }
                }
                $normalized_table[$row][$col] = $col_val / $total_row_val; 
            }
        }
        // return $normalized_table;

        $partial_weight = array();
        foreach ($normalized_table as $row=>$each_row) {
            // hitung total jumlah di baris
            $total_row_val = 0;
            foreach ($each_row as $col=>$c_val){
                $total_row_val += $c_val;
            }

            // hitung bobot partial
            $partial_weight[$row] = $total_row_val / count($each_row);
        }
        // return $partial_weight;
        
        $lamda_max = 0;
        foreach ($partial_weight as $r=>$value) {
            $criteria_factor = $value * $total_basecol_val[$r];
            $lamda_max += $criteria_factor;
        }
        // return $lamda_max;

        //hitung ci
        $ci = ($lamda_max - count($partial_weight))/(count($partial_weight) - 1);
        // return $ci;

        //random index
        if (count($partial_weight) == 3) {
            $ri = 0.58;
        } elseif (count($partial_weight) == 4) {
            $ri = 0.90;
        } elseif (count($partial_weight) == 5) {
            $ri = 1.12;
        } elseif (count($partial_weight) == 6) {
            $ri = 1.24;
        } elseif (count($partial_weight) == 7) {
            $ri = 1.32;
        } elseif (count($partial_weight) == 8) {
            $ri = 1.41;
        } elseif (count($partial_weight) == 9) {
            $ri = 1.45;
        } elseif (count($partial_weight) == 10) {
            $ri = 1.49;
        } elseif (count($partial_weight) == 11) {
            $ri = 1.51;
        } elseif (count($partial_weight) == 12) {
            $ri = 1.48;
        } elseif (count($partial_weight) == 13) {
            $ri = 1.56;
        } elseif (count($partial_weight) == 14) {
            $ri = 1.57;
        } elseif (count($partial_weight) == 15) {
            $ri = 1.59;
        } else {
            $ri = 0;
        }
        // return $ri;

        //hitung cr
        $cr = number_format($ci / $ri * 100, 2);
        // return $cr;

        if ($cr <= 10) {
            foreach ($partial_weight as $key=>$val_partial_weight) {
                $data_criteria["partial_weight"] = $val_partial_weight;
                Criteria::find($key)->update($data_criteria);
            }

            foreach ($pairwises as $pairwise) {
                $data_pairwise["criteria1_id"] = $pairwise["criteriaid_1"];
                $data_pairwise["criteria2_id"] = $pairwise["criteriaid_2"];
                $data_pairwise["value"] = $pairwise["value"];

                $check_pairwise = PairwiseComparison::where('criteria1_id', '=', $pairwise["criteriaid_1"])
                                                    ->where('criteria2_id', '=', $pairwise["criteriaid_2"])
                                                    ->first();

                if ($check_pairwise == null){
                    PairwiseComparison::create($data_pairwise);
                } else {
                    PairwiseComparison::where('criteria1_id', '=', $pairwise["criteriaid_1"])
                                        ->where('criteria2_id', '=', $pairwise["criteriaid_2"])
                                        ->update($data_pairwise);
                }
            }

            return redirect()->route('weights.index')
                            ->with('success','Penilaian bobot kriteria berhasil disimpan');
        } else {
            return redirect()->route('weights.pairwise', $id)
                            ->with('failed', 'Nilai Consistency Ratio (CR) = ' . $cr .'%. Nilai CR harus <= 10%. Silahkan reevaluasi penilaian perbandingan berpasangan kriteria.');
        }
    }
}
