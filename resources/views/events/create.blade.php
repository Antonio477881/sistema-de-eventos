<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-slate-800 leading-tight">
                {{ __('Cadastrar Novo Evento') }}
            </h2>
            <a href="{{ route('events.index') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition flex items-center gap-1">
                ← Voltar para a Lista
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-8">

                <!-- Alerta de Erros de Validação -->
                @if ($errors->any())
                    <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-xl">
                        <div class="flex items-center gap-2 font-semibold mb-1">
                            <span>⚠️</span> Por favor, corrija os erros abaixo:
                        </div>
                        <ul class="list-disc list-inside text-sm space-y-1 text-rose-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('events.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Nome e Categoria -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nome do Evento</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Ex: Workshop de Laravel" required 
                                   class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-slate-800 placeholder-slate-400">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Categoria</label>
                            <select name="category_id" required class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-slate-800">
                                <option value="">Selecione uma categoria...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Descrição Detalhada</label>
                        <textarea name="description" rows="4" placeholder="Descreva as principais atrações, assuntos abordados ou avisos importantes..." required 
                                  class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-slate-800 placeholder-slate-400">{{ old('description') }}</textarea>
                    </div>

                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Localização ou Link</label>
                            <input type="text" name="location" value="{{ old('location') }}" placeholder="Ex: Auditório Principal ou Link do Zoom" required 
                                   class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-slate-800 placeholder-slate-400">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Capacidade Máxima de Vagas</label>
                            <input type="number" name="max_participants" value="{{ old('max_participants', 50) }}" min="1" required 
                                   class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-slate-800">
                        </div>
                    </div>

                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-slate-50 p-5 rounded-xl border border-slate-100">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">📅 Data do Evento</label>
                            <input type="date" name="event_date" value="{{ old('event_date') }}" required 
                                   class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-slate-800">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">⏰ Horário de Início</label>
                            <input type="time" name="start_time" value="{{ old('start_time') }}" required 
                                   class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-slate-800">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">🏁 Horário de Término</label>
                            <input type="time" name="end_time" value="{{ old('end_time') }}" required 
                                   class="w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-slate-800">
                        </div>
                    </div>

                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Status da Publicação</label>
                        <select name="status" required class="w-full md:w-1/3 rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-slate-800">
                            <option value="PUBLISHED" selected>🟢 Publicado</option>
                            <option value="DRAFT">🟡 Rascunho</option>
                        </select>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                        <a href="{{ route('events.index') }}" class="px-5 py-2.5 border border-slate-300 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                            Cancelar
                        </a>
                        <button type="submit" class="px-7 py-2.5 bg-indigo-600 text-white font-semibold text-sm rounded-xl hover:bg-indigo-700 shadow-md shadow-indigo-200 transition">
                            Cadastrar Evento
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>