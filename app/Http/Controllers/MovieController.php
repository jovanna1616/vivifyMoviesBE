<?php

namespace App\Http\Controllers;
use App\Movie;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class MovieController extends Controller
{
	public function index()
    {
        $movies = Movie::getMovies();
        return $movies;
    }

    public function show($id)
    {
        $movie = Movie::find($id);
        return $movie;
    }

    public function store(Request $request)
    {
        $movie = new Movie();
        $rules = Movie::STORE_RULES;
        $request->validate($rules);

        $movie->name = $request->input('mark');
        $movie->director = $request->input('model');
        $movie->duration = $request->input('max_speed');
        $movie->image_url = $request->input('image_url');
        $movie->release_date = $request->input('is_automatic');
        
        // before save try to find if movie's name and release date already exist in db
        $existingMovie = Movie::where('name', '=', Input::get('name'))->first();
        if (!$existingMovie) {
            $movie->save();
            return $movie;
        }
        echo ('The movie is already in database.');



        
    }

    public function update(Request $request, $id) 
    {
        $movie = Movie::findOrFail($id);
        $rules = Movie::STORE_RULES;

        $movie->name = $request->input('name');
        $movie->director = $request->input('director');
        $movie->duration = $request->input('duration');
        $movie->image_url = $request->input('image_url');
        $movie->release_date = $request->input('release_date');

        $request->validate($rules);
        $movie->save();
        return $movie;
    }


    public function destroy($id)
    {
    	$movie = Movie::find($id);
    	$movie->delete();
        return $movie;
    }
}
