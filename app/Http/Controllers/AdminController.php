<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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
            'Voting Complete'
        ];

        for ($i = 1; $i <= $countries->where('votable', '=', 1)->count(); $i++) {
            $columns[] = "Pts to $i";
        }

        function fputcsv_eol($handle, $array, $delimiter = ',', $enclosure = '"', $eol = "\r\n")
        {
            $return = fputcsv($handle, $array, $delimiter, $enclosure);
            if ($return !== false && "\n" != $eol && 0 === fseek($handle, -1, SEEK_CUR)) {
                fwrite($handle, $eol);
            }
            return $return;
        }

        $filepath = 'public/eurovision-2020-export-'.time().'.csv';

        $file = fopen(storage_path('app/'.$filepath), 'w');

        fputcsv_eol($file, $columns);

        $i = 1;

        foreach ($countries as $country) {
            $row = [
                $i,
                $country->name,
                $country->flag,
                $country->voter_name,
                $country->song_seq,
                '',
                $country->voting_complete
            ];

            foreach ($country->pointsToCountries($countries->where('votable', '=', 1)) as $pointsToCountry) {
                $row[] = $pointsToCountry;
            }

            fputcsv_eol($file, $row);

            $i++;
        }

        fclose($file);

        return Storage::download($filepath, 'dDDDDddd');
    }
}
