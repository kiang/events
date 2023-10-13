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
        $teams = Team::paginate(15);
        return view('team.index', ['teams' => $teams]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        $events = Event::with(['team', 'place', 'links'])->where('team_id', '=', $team->id)->orderBy('time_gather', 'DESC')->paginate(15);
        return view('team.show', ['team' => $team, 'events' => $events]);
    }
}
