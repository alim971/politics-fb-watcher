<x-app-layout>
    <x-slot name="head">
        <livewire:head
        />
    </x-slot>
    <form action="{{ route('blog.update', ['blog' => $blog]) }}" method="post">
        @csrf
        @method('PUT')
        <x-slot name="header">
            <h2 class="pull-left font-semibold text-xl text-gray-800 leading-tight">
                Politici
            </h2>
            <div class="pull-right">
                <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="{{ url()->previous() }}"><i
                        class="fa fa-arrow-left"></i></a>
            </div>
            <div class="clearfix"></div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div class="mt-6 text-gray-500">
                            <div class="x_content">
                                <div class="form-group">
                                    <label for="title"
                                           class="control-label">Title</label>
                                    <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $blog->title)}}">
                                </div>
                                <livewire:select
                                    :politician-id="$blog->politician->id"
                                    :post-id="$blog->postId"
                                />
                                <div class="form-group">
                                    <label for="text"
                                           class="control-label">Text</label>
                                    <textarea name="text" class="form-control" id="text" value="{{ old('text', $blog->text)}}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</x-app-layout>

