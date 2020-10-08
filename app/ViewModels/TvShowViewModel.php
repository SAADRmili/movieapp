<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;

class TvShowViewModel extends ViewModel
{
    public function __construct($tv)
    {
        //
        $this->tv = $tv;
    }
    public function tv()
    {
        # code...
        return collect($this->tv)->merge([
            'poster_path' =>'https://image.tmdb.org/t/p/w500/'.$this->tv['poster_path'],
            'vote_average'=>$this->tv['vote_average'] * 10 .'%',
            'release_date'=> Carbon::parse( $this->tv['first_air_date'])->format('M d, Y'),
            'genres'=>collect($this->tv['genres'])->pluck('name')->flatten()->implode(', '),
            'crew'=>collect($this->tv['credits']['crew'])->take(2),
            'cast'=>collect($this->tv['credits']['cast'])->take(5),
            'images'=>collect($this->tv['images']['backdrops'])->take(9),
        ])->only([
            'poster_path', 'id', 'genres', 'name', 'vote_average', 'overview', 'first_air_date', 'credits' ,
            'videos', 'images', 'crew', 'cast','created_by'
        ]);
    }
}
