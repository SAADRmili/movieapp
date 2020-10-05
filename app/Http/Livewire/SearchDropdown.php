<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;


class SearchDropdown extends Component
{

    public $search ="";

    public function render()
    {
        $searchRes=[];
        if(strlen($this->search)>=2)
        {
            $searchRes =Http::withToken(config('services.tmdb.token'))
            ->get(env('URL_API').'/search/movie?query='.$this->search)
            ->json()['results'];


        }
        //dump($searchRes);
        return view('livewire.search-dropdown',[
            'searchRes'=>collect($searchRes)->take(7)
        ]);
    }
}
