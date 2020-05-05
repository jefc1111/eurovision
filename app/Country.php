<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    public $timestamps = false;

    public function getFlagUrl()
    {
        return 'https://www.countryflags.io/' . $this->flag . '/flat/64.png';
    }

    public function hasVotes(): bool
    {
        return $this->votes && $this->votes != '';
    }

    public function getVotedCountries()
    {
        $res = collect([]);

        if ($this->hasVotes()) {
            $ids = json_decode($this->votes);

            for ($i = 0; $i < count($ids); $i++) {
                $country = Country::find($ids[$i]);

                $country->sortPos = $i;

                $res->push($country);
            }

            $res = $res->sortBy('sort_pos');
        }

        return $res;
    }

    public function pointsToCountries($votableCountries)
    {
        if ($this->votes) {
            $voted_ids = array_map(function ($id) {
                return intval($id);
            }, json_decode($this->votes));
        } else {
            $voted_ids = [];
        }

        $points = [12, 10, 8, 7, 6, 5, 4, 3, 2, 1]; 

        $res = [];

        foreach ($votableCountries->sortBy('song_seq') as $votableCountry) {
            $res[] = in_array($votableCountry->id, $voted_ids) 
              ? $points[array_search($votableCountry->id, $voted_ids)] 
              : 0;
        }

        return $res;
    }
}
