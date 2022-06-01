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

        <aside class="fixed inset-0 h-screen w-60 overflow-y-auto  scrollbar border-r">
            <header class="flex flex-col items-center px-5 mt-[75px] ">
                <div class="ml-2 flex items-center  flex-col uppercase my-2">
                    <h1 class="text-xs text-gray-700 font-bold">Alturush Administrator</h1>
                    <h1 class="text-gray-400 text-xs mt-1"> [ {{ auth()->user()->type->usertype }} MENU ]</h1>
                </div>
            </header>
            <div>
                @can('isSuperAdmin')
                    <menu-main></menu-main>
                @endcan
                @can('isAdmin')
                    <menu-admin></menu-admin>
                @endcan
                @can('isGoodsIAD')
                    <menu-iad-goods></menu-iad-goods>
                @endcan
                @can('isPurchasing')
                    <menu-purch></menu-purch>
                @endcan
                @can('isAccounting')
                    <menu-acct></menu-acct>
                @endcan
                @can('isSupervisor')
                    <menu-sup></menu-sup>
                @endcan
                @can('isFoodsIAD')
                    <menu-iad-foods></menu-iad-foods>
                @endcan
            </div>
        </aside>

        <div class="ml-60 mt-[75px] p-2  ">
            <router-view />
        </div>
        <back-to-top />

        <Profile v-if="upload_profile" />

    </div>

    {{-- <footer class="fixed bottom-0 bg-gray-50 left-72 w-screen p-2 border-t">
        <div class="flex justify-center items-center mr-64 gap-2">
            <button onclick="window.open('https://www.facebook.com/AlturushDeliveryOfficial')"
                class="focus:outline-none"><i
                    class="fab fa-facebook fa-lg text-yellow-500 hover:text-yellow-600"></i></button>
            <button onclick="window.open('https://alturush.com')" class="focus:outline-none"><i
                    class="fas fa-globe fa-lg text-yellow-500 hover:text-yellow-600"></i></button>
        </div>
        <div class="flex justify-center items-center mr-64 group gap-1 ">
            <h4 class="text-sm group-hover:text-blue-600">
                &copy;
            </h4>
            <button onclick="window.open('https://admins.alturush.com')" class="group-hover:text-blue-600">Alturush |
                Grocery-Admin 2020</button>
        </div>

    </footer> --}}

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/excel.js') }}" defer></script>
</body>

</html>
