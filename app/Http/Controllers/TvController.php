<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ViewModels\TvViewModel;
use App\ViewModels\TvShowViewModel;
use Illuminate\Support\Facades\Http;

class TvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $popularTv = Http::withToken(config('services.tmdb.token'))
        ->get(env('URL_API').'/tv/popular')
        ->json()['results'];



        $nowPlayingTv = Http::withToken(config('services.tmdb.token'))
        ->get(env('URL_API').'/tv/top_rated')
        ->json()['results'];

        // dd($nowPlayingMovies);

        $genres =Http::withToken(config('services.tmdb.token'))
        ->get(env('URL_API').'/genre/tv/list')
        ->json()['genres'];


        // $genres = collect($genresArray)->mapWithKeys(function($genre){
        //         return [$genre['id']=>$genre['name']];
        // });

      //  dd($genrs);
        // return  view('index',[
        //     'popularMovies'=>$popularMovies,
        //     'genres'=>$genrs,
        //     'nowPlayingMovies'=>$nowPlayingMovies

        //     ]);

        $viewModel = new TvViewModel(
            $popularTv,$genres,$nowPlayingTv
        );


        return view('tv.index',$viewModel);
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

        $tv = Http::withToken(config('services.tmdb.token'))
        ->get(env('URL_API').'/tv/'.$id.'?append_to_response=credits,images,videos')
        ->json();


        $viewModel = new TvShowViewModel(
           $tv
        );

    //    //dd($movie);
        return view("tv.show",$viewModel);
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
