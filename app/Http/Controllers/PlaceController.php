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
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: *');
        header('Access-Control-Allow-Headers: *');
        $places = Place::all();
        $now = time();
        foreach ($places as $place) {
            $place->events = $place->events()->orderBy('time_gather', 'DESC')->limit(1)->get();
            $place->days = 0;
            if (!empty($place->events[0])) {
                $theTime = strtotime($place->events[0]->time_gather);
                $place->date = date('m/d', $theTime);
                $place->days = ceil(($theTime - $now) / 86400);
            }
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