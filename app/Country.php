<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    public $timestamps = false;

    public function getFlagUrl()
    {
        \Log::debug($this);
        return 'https://www.countryflags.io/'.$this->flag.'/flat/64.png';
    }
}
