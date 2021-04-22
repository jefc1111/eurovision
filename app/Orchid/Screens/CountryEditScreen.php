<?php

namespace App\Orchid\Screens;

use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use App\Country;

class CountryEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'CountryEditScreen';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'CountryEditScreen';

     /**
     * @var bool
     */
    public $exists = false
    ;
    /**
     * Query data.
     *
     * @param Cpountry $country
     *
     * @return array
     */
    public function query(Country $country): array
    {
        $this->exists = $country->exists;

        if($this->exists){
            $this->name = 'Edit country';
        }

        return [
            'country' => $country
        ];
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Create country')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->exists),
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('country.name')
                    ->title('Name')
                    ->placeholder('Country name')
                    ->help('Like, Poland, or whatever.'),

                TextArea::make('country.song_name')
                    ->title('Song name')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('Song name'),
                /*
                Relation::make('post.author')
                    ->title('Author')
                    ->fromModel(User::class, 'name'),
                
                Quill::make('post.body')
                    ->title('Main text'),
                */
            ])
        ];
    }

    /**
     * @param Country $country
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Country $country, Request $request)
    {
        $country->fill($request->get('country'))->save();

        Alert::info('You have successfully created a country.');

        return redirect()->route('platform.country.list');
    }

    /**
     * @param Country $country
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Country $country)
    {
        $country->delete();

        Alert::info('You have successfully deleted the country.');

        return redirect()->route('platform.country.list');
    }
}
