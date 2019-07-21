<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Criteria;
use App\Http\Models\Choice;
use Auth;

class PreferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $preferences = Criteria::where('step', '=', '2')
                                ->where('status', '=', '1')
                                ->where('description', '<>', null)
                                ->whereNotIn('id', function($query){
                                    $query->select('criteria_id')
                                    ->from(with(new Choice)->getTable())
                                    ->where('suggestion', 1);
                                })
                                ->orderBy('id','DESC')
                                ->paginate(10);
                                
        return view('preferences.index',compact('preferences'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $preference = Criteria::find($id);

        return view('preferences.edit',compact('preference'));
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
            'preference' => 'required',
            'max_min' => 'required',
        ]);

        $input = $request->all();
        
        if ($input['preference'] == 1) {
            $input['parameter_p'] = null;
            $input['parameter_q'] = null;
            $input['parameter_s'] = null;
        } elseif ($input['preference'] == 2) {
            $input['parameter_p'] = null;
            $input['parameter_s'] = null;
        } elseif ($input['preference'] == 3) {
            $input['parameter_q'] = null;
            $input['parameter_s'] = null;
        } elseif ($input['preference'] == 4 || $input['preference'] == 5) {
            $input['parameter_s'] = null;
        } else {
            $input['parameter_p'] = null;
            $input['parameter_q'] = null;
        }
 
        Criteria::find($id)->update($input);
 
        return redirect()->route('preferences.index')
                         ->with('success','Tipe preferensi berhasil disimpan');
    }
}
