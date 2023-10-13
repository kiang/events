<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Event;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $places = Place::all();
        foreach($places AS $place) {
            $place->events = $place->events()->orderBy('time_gather', 'DESC')->limit(1)->get();
        }
        return $places;
    }

    /**
     * Display the specified resource.
     */
    public function show(Place $place)
    {
        $events = Event::with(['team', 'links'])->where('place_id', '=', $place->id)->orderBy('time_gather', 'DESC')->paginate(15);
        return view('place.show', ['place' => $place, 'events' => $events]);
    }
}
