<nav x-data="{ open: false }" class="bg-gradient-to-r from-indigo-900 via-indigo-800 to-purple-900 border-b border-indigo-700/50 text-white shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-8">
                <!-- Logo / Nome da Aplicação -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('events.index') }}" class="font-black text-xl tracking-wider text-white flex items-center gap-2">
                        <span>🎟️</span>
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-purple-200 to-indigo-100">TechEventos</span>
                    </a>
                </div>

               
                <div class="hidden space-x-4 sm:-my-px sm:flex">
                    <a href="{{ route('dashboard') }}" 
                       class="px-3 py-2 rounded-md text-sm font-medium transition-all duration-150 {{ request()->routeIs('dashboard') ? 'bg-indigo-700/60 text-white shadow-inner font-semibold' : 'text-indigo-100 hover:bg-indigo-700/40 hover:text-white' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('events.index') }}" 
                       class="px-3 py-2 rounded-md text-sm font-medium transition-all duration-150 {{ request()->routeIs('events.*') ? 'bg-indigo-700/60 text-white shadow-inner font-semibold' : 'text-indigo-100 hover:bg-indigo-700/40 hover:text-white' }}">
                        🗓️ Eventos
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown (Usuário Logado) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-indigo-500/30 text-sm leading-4 font-medium rounded-full text-indigo-100 bg-indigo-800/40 hover:bg-indigo-700/60 hover:text-white focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-indigo-200" xmlns="[suspicious link removed]" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Meu Perfil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Sair') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger Menu (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-indigo-200 hover:text-white hover:bg-indigo-700 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-indigo-900 border-t border-indigo-700">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('events.index')" :active="request()->routeIs('events.*')" class="text-white">
                {{ __('Eventos') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-indigo-700">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-indigo-300">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-indigo-200">
                    {{ __('Meu Perfil') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-indigo-200">
                        {{ __('Sair') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
