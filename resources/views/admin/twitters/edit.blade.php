<x-app-layout>
    <x-slot name="head">
        <livewire:head
        />
    </x-slot>
    <form action="{{ route('twitter.update', ['twitter' => $twitter]) }}" method="post">
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
                                    <label for="name"
                                           class="control-label">Name</label>
                                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $twitter->name)}}">
                                </div>
                                <div class="form-group">
                                    <label for="url"
                                           class="control-label">Url</label>
                                    <input type="text" name="url" class="form-control" id="urk" value="{{ old('url', $twitter->url)}}">
                                </div>
                                <div class="form-group">
                                    <label for="nick"
                                           class="control-label">ID</label>
                                    <input type="text" name="nick" class="form-control" id="nick" value="{{ old('nick', $twitter->nick)}}">
                                </div>
                                <div class="form-group">
                                    <label for="db"
                                           class="control-label">Db</label>
                                    <input type="text" name="db" class="form-control" id="db" value="{{ old('db', $twitter->db)}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</x-app-layout>


