<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use App\Country;

class CountryListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'countries';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('name', 'Country name')->render(function (Country $country) {
                return Link::make($country->name)->route('platform.country.edit', $country);
            })->sort(),
            TD::make('flag', 'Flag')->render(function (Country $country) {
                return "<img src='{$country->getFlagUrl()}' width='40' class='bg-light' alt='{$country->flag}'> $country->flag";
            }),
            TD::make('code', 'Code'),
            TD::make('votable', 'Can be voted for'),
            TD::make('voter_name', 'Voter name'),
            TD::make('song_name', 'Song name'),
            TD::make('song_seq', 'Song sequence')->sort(),
            TD::make('votes', 'Votes'),
            TD::make('voting_complete', 'Voting complete')->sort(),
        ];
    }
}
