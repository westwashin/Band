<?php

namespace App\Http\Controllers\Band;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Band;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BandController extends Controller
{


    public function table(){
        return view('bands.table',[
            'bands' => Band::latest()->paginate(16), 
        ]);
    }


    public function create()
    {
        return view('bands.create',[
            'genres' => Genre::get(),
        ]);
    }

    public function store()
    {
        request()->validate([
            'name'=>'required',
            'thumbnail'=>request('thumbnail')?'image|mimes:jpeg,png,gif':'',
            'genres'=>'required|array',
        ]);

        $band = Band::create([
            'name' => request('name'),
            'slug' => Str::slug(request('name')),
            'thumbnail' =>request()->file('thumbnail')->store('images/band'),
        ]);

        $band->genres()->sync(request('genres'));

        return back()->with('success','Band was created');
    }
}
