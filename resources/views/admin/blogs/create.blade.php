<x-app-layout>
    <x-slot name="head">
        <livewire:head
        />
    </x-slot>
    <form action="{{ route('blog.store') }}" method="post">
        @csrf
        <x-slot name="header">
            <h2 class="pull-left font-semibold text-xl text-gray-800 leading-tight">
                Politici
            </h2>
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
                                    <input type="text" name="title" class="form-control" id="title" value="{{ old('title')}}">
                                </div>
                                <livewire:select
                                />
                                <div class="form-group">
                                    <label for="text"
                                           class="control-label">Text</label>
                                    <textarea name="text" class="form-control" id="text" value="{{ old('text')}}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>


