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

    public function resetVoteData()
    {
        Country::query()->update([
            'voting_complete' => false,
            'votes' => null,
        ]);

        return redirect('the-secret-admin-page');
    }

    public function export()
    {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=eurovision-2020.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        );

        $countries = Country::all();

        $columns = [
            'ID',
            'Country',
            'Flag',
            'Player',
            'SongNum',
            'Reveal Order',
        ];

        for ($i = 1; $i <= $countries->where('votable', '=', 1)->count(); $i++) {
            $columns[] = "Pts to $i";
        }

        $callback = function () use ($countries, $columns) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, $columns);

            $i = 1;

            foreach ($countries as $country) {
                $row = [
                    $i,
                    $country->name,
                    $country->flag,
                    $country->voter_name,
                    $country->song_seq,
                    '',
                ];

                foreach ($country->pointsToCountries($countries->where('votable', '=', 1)) as $pointsToCountry) {
                    $row[] = $pointsToCountry;
                }

                fputcsv($file, $row);

                $i++;
            }            

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
