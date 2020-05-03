<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Country;

class VotingController extends Controller
{
    public function index()
    {
        if (! request()->has('secret_code') || request()->get('secret_code') == '') {
            return redirect(url('login'))->with('error', 'Please enter a code');
        }

        $votingCountry = Country::where('code', '=', request()->get('secret_code'))->first();

        if (! $votingCountry) {
            return redirect(url('login'))->with('error', 'The code is not valid');
        }

        $countries = $votingCountry->hasVotes() ? $votingCountry->getVotedCountries() : Country::where('votable', '=', 1)->get();

        return view('voting')->with([
            'countries' => $countries->except([$votingCountry->id]),
            'votingCountry' => $votingCountry,
            'scores' => [12, 10, 8]
        ]);
    }

    public function savePositionData($voterId)
    {
        $votingCountry = Country::findOrFail($voterId);

        $votingCountry->votes = json_encode(request()->get('positionData'));

        $votingCountry->save();

        return true;
    }
}
