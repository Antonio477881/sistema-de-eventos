<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 leading-tight">
                    {{ __('Eventos Disponíveis') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Confira a lista de eventos, vagas restantes e garanta sua presença!</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('events.my') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-xl font-semibold text-sm transition">
                    🎟️ Minhas Inscrições
                </a>
                <a href="{{ route('events.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-md shadow-indigo-200 transition">
                    + Novo Evento
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Mensagens de Alerta -->
            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-300 text-emerald-800 px-5 py-4 rounded-xl shadow-sm flex items-center gap-3">
                    <span>✅</span> <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-rose-50 border border-rose-300 text-rose-800 px-5 py-4 rounded-xl shadow-sm flex items-center gap-3">
                    <span>⚠️</span> <span class="font-medium text-sm">{{ session('error') }}</span>
                </div>
            @endif

            @if($events->isEmpty())
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center">
                    <p class="text-slate-500 text-sm">Nenhum evento cadastrado no momento.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($events as $event)
                        @php
                            $isRegistered = $event->isRegisteredByUser(Auth::id());
                            $totalInscritos = $event->max_participants - $event->available_slots;
                        @endphp

                        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between overflow-hidden">
                            <div class="p-6">
                                <!-- Status e Categoria -->
                                <div class="flex justify-between items-center mb-4">
                                    <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full border border-indigo-100">
                                        {{ $event->category->name ?? 'Geral' }}
                                    </span>
                                    
                                    @if($event->available_slots > 0)
                                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            🟢 {{ $event->available_slots }} vaga(s) restante(s)
                                        </span>
                                    @else
                                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-rose-50 text-rose-700 border border-rose-200">
                                            🔴 Vagas Esgotadas
                                        </span>
                                    @endif
                                </div>

                                <h3 class="font-bold text-lg text-slate-900 mb-2">{{ $event->name }}</h3>
                                <p class="text-slate-600 text-sm mb-5 line-clamp-2 leading-relaxed">{{ $event->description }}</p>

                                <!-- Detalhes do Evento -->
                                <div class="space-y-2.5 text-xs text-slate-600 bg-slate-50 p-4 rounded-xl border border-slate-100">
                                    <div class="flex items-center gap-2">
                                        <span>📅</span>
                                        <span><strong>Data:</strong> {{ $event->start_date ? \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') : 'Data não informada' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span>⏰</span>
                                        <span><strong>Horário:</strong> {{ \Carbon\Carbon::parse($event->start_date)->format('H:i') }} às {{ \Carbon\Carbon::parse($event->end_date)->format('H:i') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span>📍</span>
                                        <span><strong>Local:</strong> {{ $event->location }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 pt-1 border-t border-slate-200/60">
                                        <span>👥</span>
                                        <span><strong>Inscritos:</strong> {{ $totalInscritos }} de {{ $event->max_participants }} vagas totais</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Botões de Inscrição / Exclusão -->
                            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 flex justify-between items-center">
                                @if($isRegistered)
                                    <form action="{{ route('events.cancel', $event) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-rose-100 hover:bg-rose-200 text-rose-700 text-xs font-bold px-4 py-2 rounded-xl transition flex items-center gap-1">
                                            ✓ Inscrito (Cancelar)
                                        </button>
                                    </form>
                                @elseif($event->available_slots > 0)
                                    <form action="{{ route('events.register', $event) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-5 py-2 rounded-xl shadow-sm transition">
                                            + Inscrever-se
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="bg-slate-200 text-slate-400 text-xs font-bold px-4 py-2 rounded-xl cursor-not-allowed">
                                        Sem Vagas
                                    </button>
                                @endif

                                @if(Auth::id() === $event->organizer_id)
                                    <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Excluir este evento?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-slate-400 hover:text-rose-600 transition">
                                            🗑️ Excluir
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>