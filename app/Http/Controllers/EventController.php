<?php

namespace App\Http\Controllers;

class EventController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $event = \App\Models\Event::where('slug', $slug)->firstOrFail();

        return view('events.show', compact('event'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = \App\Models\Event::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(5);

        return view('events.index', compact('events'));
    }
}
