<x-app-layout>
    <livewire:blog-politics-navigation />
    <x-slot name="head">
        <livewire:head
            :politician="$politician"
            :app="'Reakcie, ' . config('app.name', 'Laravel')"
        />
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center" style="overflow-wrap: anywhere">
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
                        <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                            <div>
                                {{ $politician->fullName() }}
                            </div>
                            <div class="text-sm text-gray-500">
                                <a href="https://www.facebook.com/{{ $politician->nick }}" target="_blank" class="text-gray-500 hover:text-gray-900">
                                    https://www.facebook.com/{{ $politician->nick }}
                                </a>
                            </div>
                        </div>
                        <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                            <button class="btn btn-blue">
                                <a href="{{ route('blogAll') }}" class="btn btn-primary"><i
                                        class="fa fa-arrow-left"></i></a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{--                    <div class="mt-8 text-2xl">--}}
            {{--                        Welcome to your Jetstream application!--}}

            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Reakcia
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Na
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Dátum
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Zobraziť</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($blogs as $blog)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center hover:zoom-11">
{{--                                            @if($blog->photo != null)--}}
{{--                                                <div class="flex-shrink-0 h-10 w-10">--}}
{{--                                                    <a href="{{ route('showblog', ['politician' => $blog->politician(), 'blog' => $blog]) }}">--}}
{{--                                                        <img class="h-10 w-10 rounded-full shadow" src="data:image/png;base64,{{ base64_encode($blog->photo) }}" alt="Photo from FB blog">--}}
{{--                                                    </a>--}}
{{--                                                </div>--}}
{{--                                            @elseif($blog->img != null)--}}
{{--                                                <div class="flex-shrink-0 h-10 w-10">--}}
{{--                                                    <a href="{{ route('showblog', ['politician' => $blog->politician(), 'blog' => $blog]) }}">--}}
{{--                                                        <img class="h-10 w-10 rounded-full shadow" src="{{ $blog->img }}" alt="Photo from FB blog">--}}
{{--                                                    </a>--}}
{{--                                                </div>--}}
{{--                                            @endif--}}
                                            <a href="{{ route('showBlog', ['blog' => $blog]) }}">
                                                <div class="ml-4" >
                                                    <div class="text-sm text-gray-900 ">
                                                        {!! $blog->title  !!}
                                                    </div>
                                                </div>
                                            </a>

                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center hover:zoom-11">
                                            <a href="{{ route('showPost', ['politician' => $blog->politician, 'post' => $blog->post()]) }}">
                                                <div {{ $blog->post()->img == null && $blog->post()->photo == null ? 'style=margin-left:3.5rem;' : 'class=ml-4'}} >
                                                    <div class="text-sm text-gray-900 ">
                                                        {!! $blog->post()->firstWords(15)  !!}
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                    <span title="{{ $blog->updated_at->isoFormat('LLLL') }}" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                      {{ $blog->updated_at->diffForHumans() }}
                                    </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <livewire:new-post-notification
                                            :isNew="$loop->index < $politician->newblogs"
                                            :route="route('showBlog', ['politician' => $blog->politician, 'blog' => $blog])"
                                        />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap" colspan="4">
                                        Zatiaľ neboli publikované žiadne príspevky
                                    </td>
                                </tr>
                            @endforelse
                            @if($blogs->hasPages())
                                <tr>
                                    <td class="text-center" colspan="4">{{ $blogs->onEachSide(2)->links() }}</td>
                                </tr>
                            @else
                                <tr>
                                    @php
                                        $date = \App\Models\LastUpdate::latest()->first()->created_at;
                                    @endphp
                                    <td class="text-right px-6 py-4" colspan="4" title="{{ $date->isoFormat('LLLL') }}">
                                        <p class="text-sm text-gray-700 leading-5">
                                            Naposledy kontrolované
                                            {{ $date->diffForHumans() }}
                                            .
                                        </p>
                                    </td>
                                </tr>
                            @endif
                            <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>


