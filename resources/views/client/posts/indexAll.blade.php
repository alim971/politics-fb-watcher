<x-app-layout>
    <livewire:politics-navigation />
    <x-slot name="head">
        <livewire:head
        />
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Meno
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Článok
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
                                    @forelse($posts as $post)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <a href="{{ route('indexOne', ['politician' => $post->politician()]) }}">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 hover:zoom-12-origin rounded-full shadow" src="{{ $post->politician()->image }}" alt="{{ $post->politician()->fullName() }}">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900 hover:zoom-12">
                                                            {{ $post->politician()->fullName() }}
                                                            <i class="fa fa-external-link"></i>
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            <a href="https://www.facebook.com/{{ $post->politician()->nick }}" target="_blank" class="text-gray-500 hover:text-gray-900">
                                                                https://www.facebook.com/{{ $post->politician()->nick }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </a>

                                            </div>
                                        </td>
                                        <td class="px-6 py-4 ">
                                            <div class="flex items-center hover:zoom-11">
                                                @if($post->photo != null)
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <a href="{{ route('showPost', ['politician' => $post->politician(), 'post' => $post]) }}">
                                                            <img class="h-10 w-10 rounded-full shadow" src="data:image/png;base64,{{ base64_encode($post->photo) }}" alt="Photo from FB post">
                                                        </a>
                                                    </div>
                                                @elseif($post->img != null)
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <a href="{{ route('showPost', ['politician' => $post->politician(), 'post' => $post]) }}">
                                                        <img class="h-10 w-10 rounded-full shadow" src="{{ $post->img }}" alt="Photo from FB post">
                                                    </a>
                                                </div>
                                                @endif
                                                <a href="{{ route('showPost', ['politician' => $post->politician(), 'post' => $post]) }}">
                                                    <div {{ $post->img == null && $post->photo == null ? 'style=margin-left:3.5rem;' : 'class=ml-4'}} >
                                                        <div class="text-sm text-gray-900 ">
                                                            {{ $post->firstWords(15) }}
                                                        </div>
                                                    </div>
                                                </a>

                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span title="{{ $post->date->isoFormat('LLLL') }}" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 shadow">
                                              {{ $post->date->diffForHumans() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <livewire:new-post-notification
                                                :isNew="$post->isNew"
                                                :route="route('showPost', ['politician' => $post->politician(), 'post' => $post])"
                                            />
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap col-span-4">
                                                Zatiaľ neboli publikované žiadne príspevky
                                            </td>
                                        </tr>
                                    @endforelse
                                    @if($posts->hasPages())
                                        <tr>
                                            <td class="text-center" colspan="4">{{ $posts->onEachSide(2)->links() }}</td>
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
