<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Criteria;
use App\Http\Models\Choice;
use Auth;

class CriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $criterias = Criteria::select('*')
                                ->where('description','<>','null')
                                ->where('step','=','1')
                                ->where('status','=','1')
                                ->whereNotIn('id', function($query){
                                    $query->select('criteria_id')
                                    ->from(with(new Choice)->getTable())
                                    ->where('suggestion', 1);
                                })->orderBy('id','DESC')->paginate(10);
    
        return view('criterias.index',compact('criterias'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('criterias.create');
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
            'description' => 'required',
            'citation' => 'required',
           ]);
    
        $input = $request->all();
        $input['step'] = '1';
        $input['status'] = '1';
        Criteria::create($input);

        return redirect()->route('criterias.index')
                         ->with('success','Kriteria berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $criteria = Criteria::find($id);
        
        return view('criterias.show',compact('criteria'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $criteria = Criteria::find($id);

        return view('criterias.edit',compact('criteria'));
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
            'description' => 'required',
            'citation' => 'required',
        ]);
 
        Criteria::find($id)->update($request->all());
 
        return redirect()->route('criterias.index')
                         ->with('success','Kriteria berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $choice = Choice::where('criteria_id', '=', $id)->first();

        if ($choice == null) {
            Criteria::find($id)->delete();

            return redirect()->route('criterias.index')
                             ->with('success','Kriteria berhasil dihapus');
        } else {
            return redirect()->route('criterias.index')
                             ->with('failed','Kriteria tidak bisa dihapus karena sudah ada penilaian kesesuaian kriteria oleh tim penilai');
        }
    }
}
