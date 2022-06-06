<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="name" content="{{ Auth::user()->name }}">
    <meta name="user-type" content="{{ Auth::user()->usertype_id }}">
    <meta name="id" content="{{ Auth::user()->id }}">
    <meta name="server-datetime" content="{{ now() }}">

    <title>Alturush | Administrator</title>
    {{-- <link rel="icon" type="image/x-icon" href="https://www.alturush.com/alturush_logo/AlturushDeliveryLogoGradient.png"> --}}

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="font-quest antialiased  ">
    <div id='app'>
        <nav class="fixed w-full z-20 top-0 border-b ">
            <div class=" flex items-center justify-between bg-gray-50 p-4  border-gray-200  ">
                <div class="flex items-center flex-shrink-0 text-white  ">
                    <router-link to="/" class="brand-logo flex items-center gap-2">
                        <img class="w-40" src="{{ asset('img/alturush.png') }}" alt="main">
                    </router-link>
                </div>
                <div class="flex items-center gap-10">
                    <div class="sm:hidden lg:block">
                        <module-clock />
                    </div>
                    <div class="sm:hidden lg:block">
                        <module-dropdown />
                    </div>
                </div>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>
        </nav>

        <aside class="fixed inset-0 h-screen w-60 overflow-y-auto  scrollbar border-r bg-white">
            <header class="flex flex-col items-center px-5 mt-[75px] ">
                <div class="ml-2 flex items-center  flex-col uppercase my-2">
                    <h1 class="text-xs text-gray-700 font-bold">Alturush Administrator</h1>
                    <h1 class="text-gray-400 text-xs mt-1"> [ {{ auth()->user()->type->usertype }} MENU ]</h1>
                </div>
            </header>
            <section>
                @can('isSuperAdmin')
                    <menu-main></menu-main>
                @endcan
                @can('isAdmin')
                    <menu-admin></menu-admin>
                @endcan
                @can('isIAD')
                    <menu-audit></menu-audit>
                @endcan
                @can('isPurchasing')
                    <menu-purch></menu-purch>
                @endcan

            </section>
        </aside>
        <main class="ml-60 mt-[75px] p-2  ">
            <router-view />
        </main>
        <back-to-top />

        <Profile v-if="upload_profile" />

    </div>


    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/excel.js') }}" defer></script>
</body>

</html>
