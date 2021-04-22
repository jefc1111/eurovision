<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Country extends Model
{
    use AsSource;

    protected $table = 'countries';
    
    protected $guarded = ['id'];
    
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

            $res = $res->sortBy('sortPos');
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
              ? array_key_exists(array_search($votableCountry->id, $voted_ids), $points) ? $points[array_search($votableCountry->id, $voted_ids)] : 0 
              : 0;
        }

        return $res;
    }
}
