<x-app-layout>
    <livewire:politics-navigation />
    <x-slot name="head">
        <livewire:head
            :title="$politician->fullName() . ': ' . $title"
            :text="$text ? $text : $title"
            :img="$phoho ?? $img ?? $politician->image"
        />
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <br class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-2 sm:px-20 bg-white border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg aria-label="{{$politician->fullName()}}" class="pzggbiyp" data-visualcompletion="ignore-dynamic" role="img" style="height: 168px; width: 168px;">
                                <mask id="jsc_c_2">
                                    <circle cx="84" cy="84" fill="white" r="84"></circle>
                                </mask>
                                <g mask="url(#jsc_c_2)">
                                    <image x="0" y="0" height="100%" preserveAspectRatio="xMidYMid slice" width="100%"
                                        xlink:href="{{$politician->image}}" style="height: 168px; width: 168px;"
                                        alt="{{$politician->fullName()}}">
                                    </image>
                                </g>
                            </svg>
{{--                            <img src="" />--}}
                            <div class="ml-4 text-2xl text-gray-600 leading-7 font-semibold">
                                <div>
                                    {{$politician->fullName()}}
                                </div>
                                <div title="{{ $date->isoFormat('LLLL') }}" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $date->isoFormat('LLLL') }}
                                </div>
                            </div>
                        </div>
                        <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                            @if($id > $first)
                                <span class="text-sm text-gray-400">Predchádzajúci príspevok</span>
                                <a href="{{ route('oneHelper', ['politician' => $politician, 'post' => $id - 1, 'plus' => '0']) }}" class="btn btn-primary"><i
                                        class="fa fa-arrow-left"></i></a>
                            @endif
                            @if($id < $last)
                            <a href="{{ route('oneHelper', ['politician' => $politician, 'post' => $id + 1, 'plus' => '1']) }}" class="btn btn-primary"><i
                                    class="fa fa-arrow-right"></i></a>
                            <span class="text-sm text-gray-400">Ďalší príspevok</span>
                            @endif
                        </div>
                    </div>
                </div>

{{--                    <div class="mt-8 text-2xl">--}}
{{--                        Welcome to your Jetstream application!--}}
{{--                    </div>--}}

                <div class="bg-gray-200 bg-opacity-25">
                    <div class="p-6">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            <div class="ml-4 text-gray-600 leading-7 font-semibold"> {{ $title }} </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text- text-gray-500">
                                {!! $text !!}
                            </div>
                        </div>
                        @if($photo != null)
                            <div class="flex">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <div style="width: 100%; text-align: -webkit-center"><img alt="Photo from Fb post" src="data:image/png;base64,{{ base64_encode($photo) }}"></div>
                            </div>
                        @elseif($img != null)
                        <div class="flex">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <div style="width: 100%; text-align: -webkit-center"><img alt="Photo from Fb post" src="{{ $img }}"></div>
                        </div>
                        @endif
                        <div id="showBlocked" class="hidden">
                            <br/>
                            Na zobrazenie Facebook komentárov je nutné byť prihlásený na Facebooku v browseri.<br />
                            Ak chcete zanechať odkaz, ktorý sa dá zdieľať, prosím, prihláste sa na Facebook. <br />
                            Ďakujem.
                        </div>
                    </div>
                </div>
                <div class="fb-comments" data-href="{{ Request::url() }}" target="_top" data-width="100%" data-numposts="5"></div>
            </div>
        </div>
    </div>
</x-app-layout>


