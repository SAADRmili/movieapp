<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;

class TvViewModel extends ViewModel
{
    public function __construct( $popularTv,$genres,$nowPlayingTv)
    {
        //
        $this->popularTv=$popularTv;
        $this->genres=$genres;
        $this->nowPlayingTv=$nowPlayingTv;
    }
    public function popularTv()
    {
            return $this->formatTv($this->popularTv);
    }

    private function formatTv($tvs)
    {
        // @foreach ($movie['genre_ids'] as $genre)
        //                                 {{ $genres->get($genre) }}@if(!$loop->last),
        //                                 @endif
        //                         @endforeach


        return collect($tvs)->map(function($tv){
            $genresFormatted = collect($tv['genre_ids'])->mapWithKeys(function($value){
                return [$value => $this->genres()->get($value)];
            })->implode(', ');
            return collect( $tv)->merge([
                'poster_path' =>'https://image.tmdb.org/t/p/w500/'.$tv['poster_path'],
                'vote_average'=>$tv['vote_average'] * 10 .'%',
                'first_air_date'=> Carbon::parse( $tv['first_air_date'])->format('M d, Y'),
                'genres'=>$genresFormatted,
            ])->only([
                'poster_path', 'id', 'genre_ids', 'name', 'vote_average', 'overview', 'first_air_date', 'genres',
            ]);
        });
    }
    public function genres()
    {
       return collect($this->genres)->mapWithKeys(function($genre){
            return [$genre['id']=>$genre['name']];
      });

    }
    public function nowPlayingTv()
    {
        return $this->formatTv($this->nowPlayingTv);

    }
}
