<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        $countries = \App\Country::all();

        return view('admin')->with('countries', $countries);
    }

    public function highlight($id)
    {
        Country::where('highlight', true)->update(['highlight' => false]);

        Country::where('id', $id)->update(['highlight' => true]);

        return redirect('the-secret-admin-page');
    }

    public function removeHighlight()
    {
        Country::where('highlight', true)->update(['highlight' => false]);

        return redirect('the-secret-admin-page');
    }
}
