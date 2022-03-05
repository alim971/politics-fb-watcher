<x-slot name="header">
    <div class="flex justify-between">
        <div class="flex">
            <!-- Navigation Links -->
            @foreach($politicians as $politician)
                <div class="hidden space-x-8 sm:-my-px sm:ml-6 sm:flex" style="min-height: 50px">
                    <x-jet-nav-link href="{{ route($route, $politician) }}" :active="request()->fullUrlIs(route($route, $politician))">
                        {{ $politician->fullName() }}
                        @if($politician->new)
                        <div class="notification shadow">
                            <div class="notification-text">{{ $politician->new }}</div>
                        </div>
                        @endif
                    </x-jet-nav-link>
                </div>
            @endforeach
        </div>
    </div>
    <div class="sm:hidden flex justify-between">
        <div class="flex">
            <!-- Navigation Links -->
            @foreach($politicians as $politician)
                @if ($loop->index < 3)
                    <div class="space-x-8 sm:-my-px py-2 sm:ml-6 sm:flex">
                        <x-jet-responsive-nav-link href="{{ route($route, $politician) }}" :active="request()->fullUrlIs(route($route, $politician))">
                            {{ $politician->fullName() }}
                            @if($politician->new)
                                <div class="notification-mobile shadow">
                                    <div class="notification-text">{{ $politician->new }}</div>
                                </div>
                            @endif
                        </x-jet-responsive-nav-link>
                    </div>
                @endif
            @endforeach
            @if($politicians->count() > 3)
                <div class="space-x-8 sm:-my-px py-2 sm:ml-6 sm:flex ml-3 relative">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        <span class=" border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 transition">More...</span>

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                        </x-slot>
                        <x-slot name="content">
                            {{--                            <!-- Account Management -->--}}
                            {{--                            <div class="block px-4 py-2 text-xs text-gray-400">--}}
                            {{--                                {{ __('Manage Account') }}--}}
                            {{--                            </div>--}}
                            @foreach($politicians as $politician)
                                @if ($loop->index >= 3)
                                    <x-jet-dropdown-link href="{{ route($route, $politician) }}">
                                        {{ $politician->fullName() }}
                                        @if($politician->new)
                                            <div class="notification-drop shadow">
                                                <div class="notification-text">{{ $politician->new }}</div>
                                            </div>
                                        @endif
                                    </x-jet-dropdown-link>
                                @endif
                            @endforeach
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            @endif
        </div>
    </div>
</x-slot>
