<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie; // Import the Movie model

class MovieController extends Controller
{
    public function index()
    {
        // Fetch all movies from the database
        $movies = Movie::all();

        // Return the movies as a JSON response
        return response()->json($movies);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'poster' => 'required|image'
        ]);

        $path = $request->file('poster')->storeAs('posters', $request->file('poster')->getClientOriginalName(), "public");
        $movie = new Movie([
            'title' => $request->title,
            'description' => $request->description,
            'poster' => $path
        ]);
        $movie->save();

        return response()->json(['message' => 'Movie created successfully', 'movie' => $movie]);
    }
}
