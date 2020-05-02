<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class VotingController extends Controller
{
    public function index()
    {
        \Log::warning(request()->all());
        $countries = \App\Country::all();

        return view('voting')->with('countries', $countries);
    }
}
