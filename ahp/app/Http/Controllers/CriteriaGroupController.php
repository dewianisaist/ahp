<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\User;
use App\Http\Models\Choice;
use App\Http\Models\Criteria;
use App\Http\Models\PairwiseComparison;
use Auth;
use DB;

class CriteriaGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role_id = Auth::user()->roleId();
        $user = User::find(Auth::user()->id);
        $data = Choice::where('user_id', '=', $user->id)->first();

        if ($role_id == 3 || $role_id == 4 || $role_id == 5 ||$role_id == 6) { 
            if ($user->id == 1) {
                $i = 0;
                $j = 0;

                $criterias_fix = Choice::select('choice.*', 'criterias.*')
                                        ->join('criterias','criterias.id','=','choice.criteria_id')
                                        ->where('choice.suggestion', '=', '0')
                                        ->where('criterias.step', '=', '2')
                                        ->where('criterias.status', '=', '1')
                                        ->where('criterias.group_criteria', '=', null)
                                        ->orderBy('criterias.id','DESC')
                                        ->get();
                
                $list_group = Criteria::where('group_criteria','=',null)
                                            ->where('description','=',null)
                                            ->lists('name','id')
                                            ->all();

                $criterias_group = array();
                foreach ($list_group as $key=>$name){
                    $criterias_group[$key]["name"] = $name;
                    $criterias_group[$key]["data"] = array();
                    $criterias = Choice::select('choice.*', 'criterias.*')
                                        ->join('criterias','criterias.id','=','choice.criteria_id')
                                        ->where('choice.suggestion', '=', '0')
                                        ->where('criterias.step', '=', '2')
                                        ->where('criterias.status', '=', '1')
                                        ->where('criterias.group_criteria', '=', $key)
                                        ->orderBy('criterias.id','DESC')
                                        ->get();

                    foreach ($criterias as $criteria){
                        $criterias_group[$key]["data"][] = $criteria;
                    }
                }

                return view('criteria_group.index',compact('criterias', 'criterias_fix', 'list_group', 'criterias_group', 'i', 'j'));
            }

            if ($data == null) {
                return redirect()->route('questionnaire.create')
                                ->with('failed','Maaf, silahkan isi kuesioner kriteria dahulu.');
            } else {
                $i = 0;
                $j = 0;

                $criterias_fix = Choice::select('choice.*', 'criterias.*')
                                        ->join('criterias','criterias.id','=','choice.criteria_id')
                                        ->where('choice.suggestion', '=', '0')
                                        ->where('criterias.step', '=', '2')
                                        ->where('criterias.status', '=', '1')
                                        ->where('criterias.group_criteria', '=', null)
                                        ->orderBy('criterias.id','DESC')
                                        ->get();
                
                $list_group = Criteria::where('group_criteria','=',null)
                                            ->where('description','=',null)
                                            ->lists('name','id')
                                            ->all();

                $criterias_group = array();
                foreach ($list_group as $key=>$name){
                    $criterias_group[$key]["name"] = $name;
                    $criterias_group[$key]["data"] = array();
                    $criterias = Choice::select('choice.*', 'criterias.*')
                                        ->join('criterias','criterias.id','=','choice.criteria_id')
                                        ->where('choice.suggestion', '=', '0')
                                        ->where('criterias.step', '=', '2')
                                        ->where('criterias.status', '=', '1')
                                        ->where('criterias.group_criteria', '=', $key)
                                        ->orderBy('criterias.id','DESC')
                                        ->get();

                    foreach ($criterias as $criteria){
                        $criterias_group[$key]["data"][] = $criteria;
                    }
                }

                // return $criterias_group;
                return view('criteria_group.index',compact('criterias', 'criterias_fix', 'list_group', 'criterias_group', 'i', 'j'));
            }
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
        $user = User::find(Auth::user()->id);
        $data = Choice::where('user_id', '=', $user->id)->first();

        if ($user->id == 1) {
            return view('criteria_group.create');
        }

        if ($data == null) {
            return redirect()->route('questionnaire.create')
                            ->with('failed','Maaf, silahkan isi kuesioner kriteria dahulu.');
        } else {
            return view('criteria_group.create');
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
        $input = $request->all();
        $input['step'] = '2';
        $input['status'] = '1';
        Criteria::create($input);

        return redirect()->route('criteriagroup.index')
                         ->with('success','Kelompok kriteria berhasil dibuat');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find(Auth::user()->id);
        $data = Choice::where('user_id', '=', $user->id)->first();

        if ($user->id == 1) {
            $criteria_group = Criteria::find($id);

            return view('criteria_group.edit',compact('criteria_group'));
        }

        if ($data == null) {
            return redirect()->route('questionnaire.create')
                            ->with('failed','Maaf, silahkan isi kuesioner kriteria dahulu.');
        } else {
            $criteria_group = Criteria::find($id);

            return view('criteria_group.edit',compact('criteria_group'));
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
        Criteria::find($id)->update($request->all());
 
        return redirect()->route('criteriagroup.index')
                         ->with('success','Kelompok kriteria berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pairwise = PairwiseComparison::where('criteria1_id', '=', $id)->first();

        if ($pairwise == null) {
            Criteria::where('group_criteria', '=', $id)->update(['group_criteria' => null]);
            Criteria::find($id)->delete();

            return redirect()->route('criteriagroup.index')
                            ->with('success','Kelompok kriteria berhasil dihapus');
        } else {
            return redirect()->route('criteriagroup.index')
                            ->with('failed','Kelompok kriteria tidak bisa dihapus karena sudah ada penilaian');
        }
    }

    /**
     * Add the specified criteria to group.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        
        Criteria::find($request['id'])->update($request->all());

        return redirect()->route('criteriagroup.index')
                        ->with('success','Kriteria berhasil dikelompokkan');
    }

    /**
     * Out the specified criteria from group.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function out(Request $request)
    {
        Criteria::find($request['id'])->update(['group_criteria' => null]);

        return redirect()->route('criteriagroup.index')
                        ->with('success','Kriteria berhasil dikeluarkan dari kelompok');
    }

}
