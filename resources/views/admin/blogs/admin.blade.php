<x-app-layout>
    <x-slot name="head">
        <livewire:head
        />
    </x-slot>
    <x-slot name="header">
        <h2 class="pull-left font-semibold text-xl text-gray-800 leading-tight">
            Politici
        </h2>
        <div class="pull-right">
            <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="{{ route('blog.create')}}"><i
                    class="fa fa-plus"></i></a>
        </div>
        <div class="clearfix"></div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

                    <div class="mt-6 text-gray-500">
                        <div class="x_content">

                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Text</th>
                                    <th>Politician</th>
                                    <th>Post</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($blogs as $blog)
                                    <tr>
                                        <td>{{ $blog->title }}</td>
                                        <td>{{ Str::words(15, $blog->text) }}</td>
                                        <td><svg aria-label="{{$blog->politician->nick}}" class="pzggbiyp" data-visualcompletion="ignore-dynamic" role="img" style="height: 168px; width: 168px;">
                                                <mask id="jsc_c_2">
                                                    <circle cx="84" cy="84" fill="white" r="84"></circle>
                                                </mask>
                                                <g mask="url(#jsc_c_2)">
                                                    <image x="0" y="0" height="100%" preserveAspectRatio="xMidYMid slice" width="100%"
                                                           xlink:href="{{$blog->politician->image}}" style="height: 168px; width: 168px;"
                                                           alt="{{$blog->politician->nick}}">
                                                    </image>
                                                </g>
                                            </svg></td>
                                        <td>
                                            <form action="{{ route('blog.destroy', ['blog' => $blog]) }}" class="inline" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('blog.edit',['blog' => $blog])}}"
                                                   class="btn btn-default"><i class="fa fa-pencil"></i></a>
                                                    {{--                                            <a href=""--}}
                                                    {{--                                               class="btn btn-warning"><i class="fa fa-times"></i></a>--}}
                                                    <button class="btn btn-danger deleteConfirm" type="submit"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="9">No blogs yet</td>
                                    </tr>
                                @endforelse
                                </tbody>
                                @if($blogs->hasPages())
                                    <tr>
                                        <td class="text-center" colspan="9">{{ $blogs->links() }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


