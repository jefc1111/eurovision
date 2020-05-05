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

        $countries = $votingCountry->hasVotes() ? $votingCountry->getVotedCountries() : Country::where('votable', '=', 1)->get()->shuffle();
        
        return view('voting')->with([
            'countries' => $countries->filter(function($c) use ($votingCountry) { return $c->id != $votingCountry->id;}),
            'votingCountry' => $votingCountry,
            'scores' => [12, 10, 8, 7, 6, 5, 4, 3, 2, 1]
        ]);
    }

    public function savePositionData($voterId)
    {
        $votingCountry = Country::findOrFail($voterId);

        $votingCountry->votes = json_encode(request()->get('positionData'));

        $votingCountry->save();

        return true;
    }

    public function poll()
    {
        return Country::all();
    }

    public function submitScores($voterId)
    {
        $votingCountry = Country::findOrFail($voterId);

        $votingCountry->voting_complete = 1;

        $votingCountry->save();

        return true;
    }
}
