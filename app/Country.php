<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    public $timestamps = false;    

    public function getFlagUrl()
    {
        return 'https://www.countryflags.io/'.$this->flag.'/flat/64.png';
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
}
