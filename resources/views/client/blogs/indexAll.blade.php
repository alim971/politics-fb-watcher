<x-app-layout>
    <livewire:blog-politics-navigation />
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
                                            Reakcia
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Na
                                        </th>
{{--                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">--}}
{{--                                            Článok--}}
{{--                                        </th>--}}
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
                                        <td class="px-6 py-4 ">
                                            <div class="flex items-center hover:zoom-11">
                                                <a href="{{ route('showBlog', ['blog' => $blog]) }}">
                                                    <div  class="ml-4" >
                                                        <div class="text-sm text-gray-900 ">
                                                            {!! $blog->firstWords(15)  !!}
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($blog->politician)
                                            <div class="flex items-center">
                                                <a href="{{ route('blogOne', ['politician' => $blog->politician]) }}">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 hover:zoom-12-origin rounded-full shadow" src="{{ $blog->politician->image }}" alt="{{ $blog->politician->fullName() }}">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900 hover:zoom-12">
                                                            {{ $blog->politician->fullName() }}
                                                            <i class="fa fa-external-link"></i>
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            @if($blog->post())
                                                            <a href="{{ route('showPost', ['politician' => $blog->politician, 'post' => $blog->post()]) }}" class="text-gray-500 hover:text-gray-900">
                                                                {!! $blog->post()->firstWords(10)  !!}
                                                            </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span title="{{ $blog->updated_at->isoFormat('LLLL') }}" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 shadow">
                                              {{ $blog->updated_at->diffForHumans() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <livewire:new-post-notification
                                                :isNew="$blog->updated_at->gt(\Illuminate\Support\Facades\Session::get('update_time_blog', \Illuminate\Support\Carbon::now()->toCookieString()))"
                                                :route="route('showBlog', ['blog' => $blog])"
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
