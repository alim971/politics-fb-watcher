<x-app-layout>
    <form action="{{ route('politician.update', ['politician' => $politician]) }}" method="post">
        @csrf
        @method('PUT')
        <x-slot name="header">
            <h2 class="pull-left font-semibold text-xl text-gray-800 leading-tight">
                Politici
            </h2>
            <div class="pull-right">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"><i class="fa fa-floppy-o"></i></button>
                <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="{{ url()->previous() }}"><i
                        class="fa fa-arrow-left"></i></a>
            </div>
            <div class="clearfix"></div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

                        <div class="mt-8 text-2xl">
                            Welcome to your Jetstream application!
                        </div>
                        <div class="mt-6 text-gray-500">
                            <div class="x_content">
                                <div class="form-group">
                                    <label for="name"
                                           class="control-label">Name</label>
                                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $politician->name)}}">
                                </div>
                                <div class="form-group">
                                    <label for="surname"
                                           class="control-label">Surname</label>
                                    <input type="text" name="surname" class="form-control" id="surname" value="{{ old('surname', $politician->surname)}}">
                                </div>
                                <div class="form-group">
                                    <label for="nick"
                                           class="control-label">Name</label>
                                    <input type="text" name="nick" class="form-control" id="nick" value="{{ old('nick', $politician->nick)}}">
                                </div>
                                <div class="form-group">
                                    <label for="username"
                                           class="control-label">Name</label>
                                    <input type="text" name="username" class="form-control" id="username" value="{{ old('username', $politician->username)}}">
                                </div>
                                <div class="form-group">
                                    <label for="image"
                                           class="control-label">Image source</label>
                                    <input type="text" name="image" class="form-control" id="image" value="{{ old('image', $politician->image)}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</x-app-layout>


