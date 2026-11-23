<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
   
    public function store(Event $event)
    {
        $userId = Auth::id();

        // 1. Evita inscrição duplicada
        if ($event->isRegisteredByUser($userId)) {
            return back()->with('error', 'Você já está inscrito neste evento!');
        }

        // 2. Verifica se ainda há vagas
        if ($event->available_slots <= 0) {
            return back()->with('error', 'Infelizmente as vagas para este evento esgotaram!');
        }

        
        Registration::create([
            'user_id' => $userId,
            'event_id' => $event->id,
            'status' => 'CONFIRMED',
        ]);

        $event->decrement('available_slots');

        return back()->with('success', 'Inscrição realizada com sucesso! Vaga garantida. 🎉');
    }

    
    public function destroy(Event $event)
    {
        $userId = Auth::id();

        $registration = Registration::where('user_id', $userId)
            ->where('event_id', $event->id)
            ->first();

        if ($registration) {
            $registration->delete();
            $event->increment('available_slots'); // Devolve a vaga
            return back()->with('success', 'Sua inscrição foi cancelada.');
        }

        return back()->with('error', 'Inscrição não encontrada.');
    }

    
    public function myEvents()
    {
        $user = Auth::user();
        $events = $user->registeredEvents()->with(['category', 'organizer'])->get();

        return view('events.my-events', compact('events'));
    }
}