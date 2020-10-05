<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $popularMovies = Http::withToken(config('services.tmdb.token'))
        ->get(env('URL_API').'/movie/popular')
        ->json()['results'];



        $nowPlayingMovies = Http::withToken(config('services.tmdb.token'))
        ->get(env('URL_API').'/movie/now_playing')
        ->json()['results'];

        // dd($nowPlayingMovies);

        $genresArray =Http::withToken(config('services.tmdb.token'))
        ->get(env('URL_API').'/genre/movie/list')
        ->json()['genres'];


        $genrs = collect($genresArray)->mapWithKeys(function($genre){
                return [$genre['id']=>$genre['name']];
        });

      //  dd($genrs);
        return  view('index',[
            'popularMovies'=>$popularMovies,
            'genres'=>$genrs,
            'nowPlayingMovies'=>$nowPlayingMovies

            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $movie = Http::withToken(config('services.tmdb.token'))
        ->get(env('URL_API').'/movie/'.$id.'?append_to_response=credits,images,videos')
        ->json();



       //dd($movie);
        return view("show",[
            "movie"=>$movie,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}