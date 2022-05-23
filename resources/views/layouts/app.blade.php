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

    <title>Alturush | GROCERY-ADMIN</title>
    {{-- <link rel="icon" type="image/x-icon" href="https://www.alturush.com/alturush_logo/AlturushDeliveryLogoGradient.png"> --}}

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>


<body class="font-quest antialiased  ">
    <div id='app'>
        {{-- NavBar --}}

        <nav class="fixed w-full z-20 top-0 border-b ">
            <div class=" flex items-center justify-between bg-gray-50 p-4  border-gray-200  ">
                <div class="flex items-center flex-shrink-0 text-white  ">
                    <router-link to="/" class="brand-logo flex items-center gap-2">
                        <img class="w-40" src="{{ asset('img/alturush.png') }}" alt="main">
                    </router-link>
                </div>
                <div class="flex items-center gap-10">
                    <div class="sm:hidden lg:block">
                        {{-- Clock Vue Component --}}
                        <Clock />
                        {{-- End Clock Vue Component --}}

                    </div>
                    <div id="idDropdown" class="relative sm:hidden lg:block">
                        <button id="showMenu" @click="open = !open" @blur="handleBlur" class="max-w-xs flex items-center rounded-full text-white focus:outline-none focus:shadow-solid p-2 md:border hover:bg-gray-200 transition duration-500">
                            <div class="flex items-center text-black">
                                <span class="text-center  px-3  tracking-wide">Welcome!
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ease" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </button> 

                        <transition enter-active-class=" ease-in-out transition duration-500 " enter-class="transform -translate-y-5 opacity-0 " enter-to-class="opacity-100" leave-active-class="ease-in-out transition duration-500" leave-class=" opacity-100" leave-to-class="transform -translate-y-5 opacity-0">

                            <div id='menu' v-if="open" class="absolute w-80 right-0 bg-white rounded top-14">
                                <div class="grid grid-cols-3 gap-3 p-5 ">
                                    <div class=" rounded-full h-20 w-20 relative bg-gray-200">
                                        <img class="w-20 rounded-full" src="{{ asset('USER-PROFILE/' . Auth::user()->image) }}" alt="">
                                        <button @click="showUpload" class="absolute bottom-0 right-0 p-1 bg-white rounded-full focus:outline-none text-black hover:text-blue-500 transition duration-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5  " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class=" col-span-2">
                                        <div class="w-full flex flex-col items-center justify-between space-y-2">
                                            <router-link to="/change_username" class=" text-center w-full p-2   rounded bg-blue-500 bg-opacity-80 text-white  hover:text-white hover:bg-blue-500 transition duration-500">
                                                Change Username
                                            </router-link>
                                            <router-link to="/change_password" class="text-center w-full p-2  rounded bg-blue-500 bg-opacity-80 text-white  hover:text-white hover:bg-blue-500 transition duration-500">
                                                Change Password
                                            </router-link>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();" class=" flex justify-end items-center uppercase  focus:outline-none  bg-gradient-to-tl to-yellow-600 from-red-500 w-full  px-4 py-2 text-white hover:text-white hover:bg-yellow-600 transition duration-500">
                                    <span class="mx-auto">Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </transition>

                    </div>
                </div>

            </div>

    

        </nav>
        {{-- End NavBar --}}

        <aside class="fixed inset-0 h-screen w-60 overflow-y-auto  scrollbar border-r">
            <header class="flex flex-col items-center px-5 mt-[75px] ">
                {{-- <img class="w-10" src="{{ asset('img/AlturushDeliveryLogoGradient.png') }}" alt="main"> --}}
                <div class="ml-2 flex items-center  flex-col uppercase my-2">
                    <h1 class="text-xs text-gray-700 font-bold">Alturush Administrator</h1>
                    <h1 class="text-gray-400 text-xs mt-1"> [ {{ auth()->user()->type->usertype }} MENU ]</h1>
                </div>
            </header>
            <div >
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
        {{-- Where Vue Components Display --}}
        <div class="ml-60 mt-[75px] p-2  ">
                <router-view />
        </div>

        {{-- End Where Vue Components Display --}}

        {{-- Button for back to top --}}
        <button id="backtoTop" class="hidden fixed z-30 bottom-0 right-0 mb-3 mr-3 focus:outline-none bg-gradient-to-tl to-yellow-600 from-red-500 w-12 h-12 rounded-full shadow-xl transition duration-700 ease-in-out transform hover:scale-105 ">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
            </svg>
        </button>
        {{-- End Button for back to top --}}

        {{-- Profile Vue Component --}}
        <Profile v-if="upload_profile" />
        {{-- End Profile Vue Component --}}

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
    <script src="{{ asset('js/custom.js') }}" defer></script>
    {{-- <script src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js" defer></script> --}}
    <script src="{{ asset('js/excel.js') }}" defer></script>

</body>

</html>