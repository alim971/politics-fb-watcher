<head>
@if(!\Illuminate\Support\Facades\App::environment('local'))

    <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-NXB48JJ');</script>
        <!-- End Google Tag Manager -->
    @endif
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $descriptionGoogle }}" />
    <meta name="keywords" content="{{ $keywords }}" />
{{--    <meta name="description" content="Stránka s automatickým sledovaním facebook príspevkov mnohých politikov a reakciami na nich">--}}
{{--    <meta name="keywords" content="Blaha, Ľuboš, Ľuboš Blaha, Kotleba, Fico, Róbert Fico, Chmelár, Eduard Chmelár, Facebook, Res Publica, Vec verejná ">--}}
    <title>{{ $app ?? config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @if($cke)
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <!-- include summernote css/js -->
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
        <x-slot name="scripts">
            <script type="text/javascript">

                var imageUploadUrlSum = "{{ route('image.save') }}";

                $('.summernote').summernote({
                    height: 400,
                    lang: 'sk-SK'
                });

                // Initialize summernote plugin
                $('.summernote').on('summernote.change', function (we, contents, $editable) {
                    $(".input-info[data-langID='" + $(we.target).attr('data-langID') + "']").val(contents);
                });

                $('.summernote').summernote({
                    callbacks: {
                        onPaste: function (e) {
                            var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                            e.preventDefault();
                            document.execCommand('insertText', false, bufferText);
                        }
                    }
                });

{{--                @foreach(\App\Models\Language\Language::all() as $lang)--}}
{{--                if ($(".input-info[data-langID='{{$lang->id}}']").val() != '') {--}}
{{--                    $(".summernote[data-langID='{{$lang->id}}']").summernote('code', $(".input-info[data-langID='{{$lang->id}}']").val());--}}
{{--                }--}}
{{--                @endforeach--}}
            </script>
        </x-slot>

    @endif
{{--    @if($editor)--}}
{{--        <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>--}}
{{--    @endif--}}

@livewireStyles

<!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ '/js/prebid-ads.js' }}" defer></script>
    <meta property="og:url"                content="{{ $url }}" />
    <meta property="og:type"               content="{{ $type }}" />
    <meta property="og:title"              content="{{ $title }}" />
    <meta property="og:description"        content="{{ $description }}" />
    @if($img != null)
    <meta property="og:image"              content="{{ $img }}" />
    @endif
    <meta property="og:locale"              content="sk" />
    <meta property="fb:app_id"              content="1177874132956217" />
</head>
