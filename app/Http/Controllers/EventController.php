<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Event::with(['team', 'place', 'links'])->paginate(15);
        return $data;
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load(['team', 'place', 'links']);
        return $event;
    }

    public function front() {
        $events = Event::with(['team', 'place', 'links'])->orderBy('time_gather', 'DESC')->paginate(15);
        return view('welcome', ['events' => $events]);
    }
}
