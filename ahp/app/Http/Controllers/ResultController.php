<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Alternative;
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
        $i = 0;
        $result = Alternative::orderBy('score_promethee','DESC')
                                ->orderBy('name','ASC')
                                ->get();

        return view('result.index',compact('result','i'));
    }
}
