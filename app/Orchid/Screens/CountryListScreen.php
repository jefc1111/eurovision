<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Country;
use App\Orchid\Layouts\CountryListLayout;
use Orchid\Screen\Actions\Link;

class CountryListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Country admin';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'All the data is here!';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'country'  => Country::find(1),
            'countries' => Country::orderBy('name')->paginate(),
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Create new')
                ->icon('pencil')
                ->route('platform.country.edit')
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            CountryListLayout::class
        ];
    }
}
