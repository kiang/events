<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Event;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Team::with(['events'])->paginate(15);
        return $data;
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        $events = Event::with(['team', 'place', 'links'])->where('team_id', '=', $team->id)->orderBy('time_gather', 'DESC')->paginate(15);
        return view('team', ['team' => $team, 'events' => $events]);
    }
}
