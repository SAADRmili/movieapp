<?php

namespace App\ViewModels;

use Carbon\Carbon;
use phpDocumentor\Reflection\Types\This;
use Spatie\ViewModels\ViewModel;

class MoviesViewModel extends ViewModel
{
    public function __construct($popularMovies,$genres,$nowPlayingMovies)
    {
        //
        $this->popularMovies=$popularMovies;
        $this->genres=$genres;
        $this->nowPlayingMovies=$nowPlayingMovies;
    }

    public function popularMovies()
    {
            return $this->formatMovies($this->popularMovies);
    }

    private function formatMovies($movies)
    {
        // @foreach ($movie['genre_ids'] as $genre)
        //                                 {{ $genres->get($genre) }}@if(!$loop->last),
        //                                 @endif
        //                         @endforeach



        return collect($movies)->map(function($movie){
            $genresFormatted = collect($movie['genre_ids'])->mapWithKeys(function($value){
                return [$value => $this->genres()->get($value)];
            })->implode(', ');
            return collect( $movie)->merge([
                'poster_path' =>'https://image.tmdb.org/t/p/w500/'.$movie['poster_path'],
                'vote_average'=>$movie['vote_average'] * 10 .'%',
                'release_date'=> Carbon::parse( $movie['release_date'])->format('M d, Y'),
                'genres'=>$genresFormatted,
            ])->only([
                'poster_path', 'id', 'genre_ids', 'title', 'vote_average', 'overview', 'release_date', 'genres',
            ]);
        });
    }
    public function genres()
    {
       return collect($this->genres)->mapWithKeys(function($genre){
            return [$genre['id']=>$genre['name']];
      });

    }
    public function nowPlayingMovies()
    {
        return $this->formatMovies($this->nowPlayingMovies);

    }
}
