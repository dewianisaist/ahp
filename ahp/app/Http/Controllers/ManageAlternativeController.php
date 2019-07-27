<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Alternative;
use Auth;

class ManageAlternativeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Alternative::select('id', 'name', 'date_birth', 'last_education')
                            ->orderBy('name','ASC')
                            ->paginate(10);

        return view('manage_alternatives.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage_alternatives.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'date_birth' => 'required',
            'last_education' => 'required',
            'intensity_participation' => 'required',
            'course_experience' => 'required',
            'orientation_value' => 'required',
            'recommendation' => 'required',
            'knowledge_value' => 'required',
            'technical_value' => 'required',
            'honesty_value' => 'required',
            'attitude_value' => 'required',
            'motivation_value' => 'required',
            'mental_value' => 'required',
            'family_value' => 'required',
            'appearance_value' => 'required',
            'communication_value' => 'required',
            'confidence_value' => 'required',
            'commitment_value' => 'required',
            'economic_value' => 'required',
            'potential_value' => 'required',
            'seriousness_value' => 'required',
            'impression_value' => 'required'
           ]);
    
        $input = $request->all();
        Alternative::create($input);

        return redirect()->route('manage_alternatives.index')
                         ->with('success','Data Pendaftar berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $alternative = Alternative::find($id);
        
        return view('manage_alternatives.show',compact('alternative'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $alternative = Alternative::find($id);

        return view('manage_alternatives.edit',compact('alternative'));
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
        $this->validate($request, [
            'name' => 'required',
            'date_birth' => 'required',
            'last_education' => 'required',
            'intensity_participation' => 'required',
            'course_experience' => 'required',
            'orientation_value' => 'required',
            'recommendation' => 'required',
            'knowledge_value' => 'required',
            'technical_value' => 'required',
            'honesty_value' => 'required',
            'attitude_value' => 'required',
            'motivation_value' => 'required',
            'mental_value' => 'required',
            'family_value' => 'required',
            'appearance_value' => 'required',
            'communication_value' => 'required',
            'confidence_value' => 'required',
            'commitment_value' => 'required',
            'economic_value' => 'required',
            'potential_value' => 'required',
            'seriousness_value' => 'required',
            'impression_value' => 'required'
        ]);
 
        Alternative::find($id)->update($request->all());
 
        return redirect()->route('manage_alternatives.index')
                         ->with('success','Data Pendaftar berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Alternative::find($id)->delete();

        return redirect()->route('manage_alternatives.index')
                         ->with('success','Data Pendaftar berhasil dihapus');
    }
}