<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @if (isset($head))
        {{ $head }}
    @endif
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
        <script type="text/javascript">
            window.addEventListener('load', function () {
                if(document.getElementsByTagName('iframe').length === 0) {
                    setTimeout(function () {
                        if(document.getElementsByTagName('iframe')[0].clientHeight === 0){
                            // adblocker detected, show fallback
                            document.getElementById('showBlocked').className = 'text-center'
                        }
                    }, 500)
                } else if(document.getElementsByTagName('iframe')[0] !== undefined){
                    if (document.getElementsByTagName('iframe')[0].clientHeight === 0) {
                        // adblocker detected, show fallback
                        document.getElementById('showBlocked').className = 'text-center'
                    }
                }
            })
        </script>

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
{{--        @include('cookieConsent::index')--}}
        @stack('modals')

        @livewireScripts
    </body>
</html>
