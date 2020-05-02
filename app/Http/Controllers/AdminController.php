<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        $countries = \App\Country::all();

        return view('admin')->with('countries', $countries);
    }
}
