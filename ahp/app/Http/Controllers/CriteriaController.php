<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Criteria;
use App\Http\Models\PairwiseComparison;
use Auth;
use DB;

class CriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $i = 0;
        $j = 0;

        $list_criteria = Criteria::where('group_criteria','=',null)
                                ->lists('name','id')
                                ->all();

        $criterias = array();
        foreach ($list_criteria as $key=>$name){
            $criterias[$key]["name"] = $name;
            $criterias[$key]["data"] = array();
            $subcriterias = Criteria::select('*')
                                    ->where('group_criteria', '=', $key)
                                    ->orderBy('id','DESC')
                                    ->get();

            foreach ($subcriterias as $subcriteria){
                $criterias[$key]["data"][] = $subcriteria;
            }
        }

        // return $criterias_group;
        return view('criteria.index',compact('subcriterias', 'list_criteria', 'criterias', 'i', 'j'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $criterias = Criteria::where('group_criteria', '=', null)
                            ->lists('name','id');
        
        return view('criteria.create', compact('criterias'));
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
        Criteria::create($input);

        return redirect()->route('criteria.index')
                         ->with('success','Kriteria/subkriteria berhasil dibuat');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $user = User::find(Auth::user()->id);
        // $data = Choice::where('user_id', '=', $user->id)->first();

        // if ($user->id == 1) {
        //     $criteria_group = Criteria::find($id);

        //     return view('criteria_group.edit',compact('criteria_group'));
        // }

        // if ($data == null) {
        //     return redirect()->route('questionnaire.create')
        //                     ->with('failed','Maaf, silahkan isi kuesioner kriteria dahulu.');
        // } else {
        //     $criteria_group = Criteria::find($id);

        //     return view('criteria_group.edit',compact('criteria_group'));
        // }
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
        // Criteria::find($id)->update($request->all());
 
        // return redirect()->route('criteriagroup.index')
        //                  ->with('success','Kelompok kriteria berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $pairwise = PairwiseComparison::where('criteria1_id', '=', $id)->first();

        // if ($pairwise == null) {
        //     Criteria::where('group_criteria', '=', $id)->update(['group_criteria' => null]);
        //     Criteria::find($id)->delete();

        //     return redirect()->route('criteriagroup.index')
        //                     ->with('success','Kelompok kriteria berhasil dihapus');
        // } else {
        //     return redirect()->route('criteriagroup.index')
        //                     ->with('failed','Kelompok kriteria tidak bisa dihapus karena sudah ada penilaian');
        // }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function subedit($id)
    {
        // $user = User::find(Auth::user()->id);
        // $data = Choice::where('user_id', '=', $user->id)->first();

        // if ($user->id == 1) {
        //     $criteria_group = Criteria::find($id);

        //     return view('criteria_group.edit',compact('criteria_group'));
        // }

        // if ($data == null) {
        //     return redirect()->route('questionnaire.create')
        //                     ->with('failed','Maaf, silahkan isi kuesioner kriteria dahulu.');
        // } else {
        //     $criteria_group = Criteria::find($id);

        //     return view('criteria_group.edit',compact('criteria_group'));
        // }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function subupdate(Request $request, $id)
    {
        // Criteria::find($id)->update($request->all());
 
        // return redirect()->route('criteriagroup.index')
        //                  ->with('success','Kelompok kriteria berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function subdestroy($id)
    {
        // $pairwise = PairwiseComparison::where('criteria1_id', '=', $id)->first();

        // if ($pairwise == null) {
        //     Criteria::where('group_criteria', '=', $id)->update(['group_criteria' => null]);
        //     Criteria::find($id)->delete();

        //     return redirect()->route('criteriagroup.index')
        //                     ->with('success','Kelompok kriteria berhasil dihapus');
        // } else {
        //     return redirect()->route('criteriagroup.index')
        //                     ->with('failed','Kelompok kriteria tidak bisa dihapus karena sudah ada penilaian');
        // }
    }

    /**
     * Add the specified criteria to group.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        
        // Criteria::find($request['id'])->update($request->all());

        // return redirect()->route('criteriagroup.index')
        //                 ->with('success','Kriteria berhasil dikelompokkan');
    }

    /**
     * Out the specified criteria from group.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function out(Request $request)
    {
        // Criteria::find($request['id'])->update(['group_criteria' => null]);

        // return redirect()->route('criteriagroup.index')
        //                 ->with('success','Kriteria berhasil dikeluarkan dari kelompok');
    }

}
