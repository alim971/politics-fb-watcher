<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="{{ '/js/prebid-ads.js' }}" defer></script>
    </head>
    <body class="font-sans antialiased">
    @if(!\Illuminate\Support\Facades\App::environment('local'))
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXB48JJ"
                          height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    @endif
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v12.0&appId=1177874132956217&autoLogAppEvents=1" nonce="4C20h8kE"></script>
        <x-jet-banner />
{{--        <script type="text/javascript">--}}
{{--            // window.addEventListener('load', function () {--}}
{{--            //     if( window.canRunAds === undefined ){--}}
{{--            //         // adblocker detected, show fallback--}}
{{--            //         document.getElementById('showBlocked').className = 'text-center'--}}
{{--            //     }--}}
{{--            // })--}}
{{--        </script>--}}

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-1 px-4 sm:px-6 lg:px-8" style="padding-bottom: 0">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @include('cookieConsent::index')
        @stack('modals')

        @livewireScripts
    </body>
</html>
