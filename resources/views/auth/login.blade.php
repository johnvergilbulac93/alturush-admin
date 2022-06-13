<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="server-datetime" content="{{ now() }}">
    <meta name="name" content="">
    <meta name="user-type" content="">
    <meta name="id" content="">
    <title>Alturush | Administrator</title>
    {{-- <link rel="icon" type="image/x-icon" href="https://www.alturush.com/alturush_logo/AlturushDeliveryLogoGradient.png"> --}}

    <link rel="stylesheet" href="{{ asset('custom/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body class="font-inter antialiased " id='bodyClass'>
    <div id="app" class="min-h-full flex items-center justify-center lg:justify-end py-12 px-4 sm:px-6 lg:px-8 ">
        <div class="max-w-md w-full space-y-4 block bg-gray-100 rounded  mt-12 ">
            <img src="{{ asset('/img/AlturushDeliveryLogoGradient.png') }}" class="mx-auto h-20 w-auto mt-2">
            <h2 class=" text-center text-xl font-extrabold  " class=" ">Sign in to
                your account</h2>
            <div class="flex justify-center items-center bg-gray-200 rounded-b p-2">
                <form class="space-y-6 " action="#" method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="remember" value="true">
                    <div class="rounded-md shadow-sm -space-y-px">
                        <div class="w-auto">
                            <label for="username" class="sr-only">Username</label>
                            @error('username')
                                <span class="text-xs text-red-500" role="alert" id="idErrorMsg">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <input name="username" type="text" autocomplete="username" required
                                value="{{ old('username') }}" class="form-control2" placeholder="Username">

                        </div>
                        <div class="w-auto">
                            <label for="password" class="sr-only">Password</label>
                            <input name="password" :type="showPassword ? 'text' : 'password'"
                                autocomplete="current-password" required class="form-control3" placeholder="Password">
                            @error('password')
                                <span class="text-xs text-red-500" role="alert" id="idErrorMsg">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" @click="toggleShow"
                                class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm "> Show Password </label>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-orange-400 group-hover:text-orange-5   00"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                            Sign in
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>
