<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 leading-tight">
                    {{ __('Minhas Inscrições') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Estes são os eventos em que você garantiu sua vaga.</p>
            </div>
            <a href="{{ route('events.index') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">
                ← Ver Todos os Eventos
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-300 text-emerald-800 px-5 py-4 rounded-xl shadow-sm">
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif

            @if($events->isEmpty())
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center">
                    <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">
                        🎟️
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-1">Você não está inscrito em nenhum evento</h3>
                    <p class="text-slate-500 text-sm mb-6">Navegue pela lista de eventos disponíveis e garanta sua presença!</p>
                    <a href="{{ route('events.index') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl text-sm font-semibold shadow-md transition">
                        Explorar Eventos
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($events as $event)
                        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 flex flex-col justify-between">
                            <div>
                                <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full border border-indigo-100 inline-block mb-3">
                                    {{ $event->category->name ?? 'Geral' }}
                                </span>
                                <h3 class="font-bold text-lg text-slate-900 mb-2">{{ $event->name }}</h3>
                                <p class="text-slate-600 text-sm mb-4 line-clamp-2">{{ $event->description }}</p>

                                <div class="space-y-2 text-xs text-slate-600 bg-slate-50 p-4 rounded-xl border border-slate-100 mb-4">
                                    <p>📅 <strong>Data:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }}</p>
                                    <p>⏰ <strong>Horário:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('H:i') }} às {{ \Carbon\Carbon::parse($event->end_date)->format('H:i') }}</p>
                                    <p>📍 <strong>Local:</strong> {{ $event->location }}</p>
                                </div>
                            </div>

                            <form action="{{ route('events.cancel', $event) }}" method="POST" onsubmit="return confirm('Deseja cancelar sua inscrição neste evento?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold py-2.5 rounded-xl border border-rose-200 transition">
                                    Cancelar minha inscrição
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>