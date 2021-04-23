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
    public $name = 'Create country';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Creat new country';

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
            Button::make('Save country')
                ->icon('control-play')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Save and add more')
                ->icon('control-forward')
                ->method('createOrUpdateAndAddMore')
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
            Layout::columns([
                Layout::rows([
                    Input::make('country.name')
                        ->title('Country name')
                        ->placeholder('Country name')
                        ->help('Like, Poland, or whatever.'),
                    Input::make('country.song_name')
                        ->title('Song name')
                        ->placeholder('Song name'),
                    Input::make('country.flag')
                        ->title('Flag')
                        ->placeholder('i.e. am, fr etc')
                        ->help("Links to https://www.worldometers.info/geography/flags-of-the-world/"),
                    Input::make('country.song_seq')
                        ->title('Sequence number')
                        ->placeholder('int'),
                    Input::make('country.votable')
                        ->title('Votable')
                        ->placeholder('bool')
                ]),
                Layout::rows([
                    Input::make('country.voter_name')
                        ->title('Voter name')
                        ->placeholder('Entry code'),
                    Input::make('country.code')
                        ->title('Entry code')
                        ->placeholder('Entry code'),
                    Input::make('country.voting_complete')
                        ->title('Voting complete')
                        ->placeholder('bool'),
                    Textarea::make('country.votes')
                        ->title('Votes')
                        ->lines(3)
                        ->placeholder('Votes')
                        ->help('Stringified JSON')
                ]),
            ]),

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

        Alert::info('Operation succesful.');

        return redirect()->route('platform.country.list');
    }

    public function createOrUpdateAndAddMore(Country $country, Request $request)
    {
        $country->fill($request->get('country'))->save();

        return redirect()->route('platform.country.edit');
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
