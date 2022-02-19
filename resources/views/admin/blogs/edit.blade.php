<x-app-layout>
    <x-slot name="head">
        <livewire:head
            :cke="true"
        />
    </x-slot>
    <form action="{{ route('blog.update', ['blog' => $blog]) }}" method="post">
        @csrf
        @method('PUT')
        <x-slot name="header">
            <h2 class="pull-left font-semibold text-xl text-gray-800 leading-tight">
                Politici
            </h2>
            <div class="clearfix"></div>
        </x-slot>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                        <label for="url"
                                               class="control-label">Url</label>
                                    </div>
                                </div>
                                <div class="ml-12">
                                    <input type="text" name="url" class="form-control" id="url" value="{{ old('url', $blog->url)}}">
                                </div>
                            </div>

                            <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                                <div class="p-6">
                                    <div class="flex items-center">
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold" style="width: 100%">
                                            <label for="title"
                                                   class="control-label">Title</label>
                                            <button style="float: right" type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"><i class="fa fa-floppy-o"></i></button>

                                        </div>
                                    </div>
                                    <div class="ml-12">
                                        <textarea name="title" class="ckeditor form-control" id="title">
                                            {{ old('title', $blog->title)}}
                                        </textarea>
                                    </div>
                                </div>

                                <div class="ml-12">
                                </div>
                            </div>

                            <div class="p-6 border-t border-gray-200">
                                <div class="flex items-center">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
{{--                                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">--}}
{{--                                        Details--}}
{{--                                    </div>--}}
                                </div>
                                <livewire:select
                                    :selected-post="$blog->post_id"
                                    :selected-politician="$blog->politician->id"
                                />
                            </div>

                            <div class="p-6 border-t border-gray-200 md:border-l">
                                <div class="flex items-center">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                                        <label for="text"
                                               class="control-label">Text</label>
                                    </div>
                                </div>

                                <div class="ml-12">
                                    <div class="mt-2 text-sm text-gray-500">
                                        <textarea name="text" class="form-control" id="text">
                                            {{ old('text', $blog->text)}}
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <x-slot name="scripts">
        <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
        <script type="text/javascript">
            CKEDITOR.replace('text', {
                filebrowserUploadUrl: "{{route('ckeditor.image-upload', ['_token' => csrf_token() ])}}",
                filebrowserUploadMethod: 'form'
            });
            $(document).ready(function () {
                $('.ckeditor').ckeditor();
            });
        </script>
    </x-slot>
</x-app-layout>
