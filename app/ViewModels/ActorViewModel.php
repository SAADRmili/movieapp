<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;

class ActorViewModel extends ViewModel
{
    public function __construct($actor,$social,$credits)
    {
        //
        $this->actor = $actor;
        $this->social = $social;
        $this->credits = $credits;
    }

    public function actor()
    {
        # code...
        return collect($this->actor)->merge([
            'birthday'=> Carbon::parse($this->actor['birthday'])->format('M d,Y'),
            'age'=>Carbon::parse($this->actor['birthday'])->age,
            'profile_path'=>$this->actor['profile_path']
                ?
                'https://image.tmdb.org/t/p/w300/'.$this->actor['profile_path'] : 'https://ui-avatars.com/api/?size=300&name='.$this->actor['name'],
            ]);
    }

    public function social()
    {
        return collect($this->social)->merge([
                'twitter'=>$this->social['twitter_id'] ? 'https://twitter.com/'.$this->social['twitter_id'] : null,
                'facebook'=>$this->social['facebook_id'] ? 'https://facebook.com/'.$this->social['facebook_id'] : null,
                'instagram'=>$this->social['instagram_id'] ? 'https://instagram.com/'.$this->social['instagram_id'] : null,

        ]);

    }

    public function knownForMovies()
    {
        # code...
        $castMovies = collect($this->credits)->get('cast');

        return collect($castMovies)->sortByDesc('popularity')->take(5)
        ->map(function($movie){
            if(isset($movie['title']))
            {
                $t = $movie['title'];
            }elseif(isset($movie['name'])){
                  $t = $movie['name'];
            }else
            {
                $t = 'Untitled';
            }

            return collect($movie)->merge([
                'poster_path' => $movie['poster_path'] ? 'https://image.tmdb.org/t/p/w185/'.$movie['poster_path'] : 'https://via.placeholder.com/185x278',
                'title'=> $t,
                'linkToPage'=>$movie['media_type' ]=== 'movie' ?route('movies.show',$movie['id']):route('tv.show',$movie['id'])
            ]);
        })
        ;
    }
    public function credits()
    {
        # code...
        $credits = collect($this->credits)->get('cast');

        return collect($credits)
        ->map(function($movie){

          if(isset($movie['release_date']))
          {
              $rd = $movie['release_date'];
          }elseif(isset($movie['first_air_date'])){
                $rd = $movie['first_air_date'];
          }else
          {
              $rd = '';
          }


          if(isset($movie['title']))
          {
              $t = $movie['title'];
          }elseif(isset($movie['name'])){
                $t = $movie['name'];
          }else
          {
              $t = 'Untitled';
          }


            return collect($movie)->merge([
                'release_date'=>$rd,
                'release_year'=>isset($rd) ? Carbon::parse($rd)->format('Y'):'Future',
                'title'=>$t,
                'character'=> isset($movie['character'])? $movie['character']:'',
            ]);
        })->sortByDesc('release_date');
    }
}
