<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EventController extends Controller
{
    
    public function index()
    {
        $events = Event::with(['category', 'organizer'])->latest()->get();
        return view('events.index', compact('events'));
    }

    
    public function create()
    {
        $categories = Category::all();
        return view('events.create', compact('categories'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'max_participants' => 'required|integer|min:1',
            'status' => 'required|in:DRAFT,PUBLISHED,CANCELLED,FINISHED',
        ]);

        
        $startDate = $request->event_date . ' ' . $request->start_time . ':00';
        $endDate = $request->event_date . ' ' . $request->end_time . ':00';

        Event::create([
            'organizer_id' => Auth::id(),
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'max_participants' => $request->max_participants,
            'available_slots' => $request->max_participants,
            'status' => $request->status,
        ]);

        return redirect()->route('events.index')->with('success', 'Evento criado com sucesso!');
    }

   
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Evento excluído com sucesso!');
    }
}