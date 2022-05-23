<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="server-datetime" content="{{ now() }}">
    <meta name="name" content="">
    <meta name="user-type" content="">
    <meta name="id" content="">
    <title>Alturush | Grocery-Admin</title>
    <link rel="icon" type="image/x-icon" href="https://www.alturush.com/alturush_logo/AlturushDeliveryLogoGradient.png">


    <link rel="stylesheet" href="{{ asset('custom/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}


</head>

<body class="font-poppins antialiased">

    <img class="wave" src="custom/img/wave.png" class="shadow-lg">
    <div class="container">
        <div class="grid grid-flow-row md:grid-cols-2 grid-rows-1 gap-4 sm:grid-cols-1 p-16">
            <div class="img"><img src="custom/img/grocery.svg" alt="img" class=""></div>
            <div class="bg-gray-50 shadow-lg">
                <center>
                    <form method="POST" action="{{ route('login') }}" id='myForm' class="p-3">
                        @csrf
                        <img src="custom/img/avatar.svg" class="h-20">
                        <h3 class="text-2xl text-gray-600 uppercase my-2 ">Administrator</h3>

                        <div class="space-y-5 mt-10">
                            <div class="relative  w-full flex flex-wrap items-stretch focus:text-yellow-400">
                                <span
                                    class="absolute z-10 py-3 pl-3 w-8 h-full leading-snug bg-transparent rounded text-base font-normal text-gray-400 text-center flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </span>
                                <input type="text" name="username"
                                    class="relative py-3 px-3 pl-10 w-full  border focus:border-yellow-500 rounded-lg bg-white text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:shadow-outline transition duration-500"
                                    placeholder="Username" />
                            </div>
                            @error('username')
                                <small class="text-red-500 text-xs">{{ $message }}</small>
                            @enderror
                            <div class="relative w-full flex flex-wrap items-stretch focus:text-yellow-400">
                                <span
                                    class="absolute z-10 py-3 pl-3 w-8 h-full leading-snug bg-transparent rounded text-base font-normal text-gray-400 text-center flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                                <input type="password" name="password"
                                    class="relative py-3 px-3 pl-10 w-full  border focus:border-yellow-500 rounded-lg bg-white text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:shadow-outline transition duration-500"
                                    placeholder="Password" />
                            </div>
                            @error('password')
                                <small class="text-red-500 text-xs">{{ $message }}</small>
                            @enderror
                            <div class="w-full">
                                <button type="submit"
                                    class="bg-yellow-500 py-2 px-3 rounded w-full font-semibold text-white transition duration-500 hover:bg-yellow-600"
                                    tabindex="3">
                                    {{ __('Sign in') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </center>
            </div>
        </div>
    </div>
</body>

</html>
