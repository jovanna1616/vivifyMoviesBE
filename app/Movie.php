<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{

    protected $guarded = ['id'];
    protected $fillable = ['name', 'director', 'image_url', 'duration', 'release_date', 'genres'];
    protected $casts = ['genres' => 'array'];

    const STORE_RULES = [
            'name' => 'required',
            'director' => 'required',
            'image_url' => 'url',
            'duration' => 'required | numeric|min:1|max:500',
            'release_date' => 'required',
        ];


    static function getMovies() {
        if(isset($_GET['take']) && isset($_GET['skip'])) {
            $take = (integer)$_GET['take'];
            $skip = (integer)$_GET['skip'];
            $movies[] =  self::all();
            foreach ($movies[0] as $movie) {
                $allMovies[] = $movie;
            }
            // // izbacuje prvih 5 iz liste i krece od 6. u listi
            // $allMovies = array_slice($allMovies, $skip);
                        
            // $allMovies = array_slice($allMovies, 0, $take);
            
            // kraca verija
            $allMovies = array_slice((array_slice($allMovies, $skip)), 0, $take);
            // dd($allMovies);    
            return $allMovies;
        }
        // search by name
        if(isset($_GET['name'])) {
            $name = $_GET['name'];
            $movies[] =  self::all();
            foreach ($movies[0] as $movie) {
                if(strpos($movie['name'], $name) > -1) {
                    $searchedMovies[] = $movie;
                }
            }
            return $searchedMovies;
        }
        return self::all();
    }

    // mutator - niz u string kad bude stizao u bazu
    public function setGenresMutator($genres){
    	$this->attributes['genres'] = json_encode($genres);
    }

    // search by movie name
    static function search($term)
    {
        $movies = self::latest()->get();
        // $url = $request->path();
        $url = $request->fullUrl();
        dd($url);
        foreach ($movies as $movie) {
            return self::where($movie.name === $url)->paginator($skip,$take);
        }
    }
}
