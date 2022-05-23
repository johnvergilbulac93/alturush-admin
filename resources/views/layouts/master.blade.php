@extends("layouts.app")
@section('menu')
    {{-- @can('isSuperAdmin')
            <div class="container mx-auto px-20">
                <ul
                    class="list-reset flex sm:flex-col md:flex-row items-center uppercase space-x-5 text-white font-poppins text-md tracking-normal p-2">
                    <router-link :to="{ name: 'dashboard', params: { id: {{ Auth::user()->usertype_id }}  } }"
                        class=" text-white hover:bg-white hover:text-yellow-500 rounded transition duration-500 p-2 flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="">DASHBOARD</span>
                    </router-link>
                    <router-link :to="{ name: 'menu', params: { id: {{ Auth::user()->usertype_id }}  } }"
                        class=" text-white hover:bg-white hover:text-yellow-500 rounded transition duration-500 p-2 flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <span>MENU</span>
                    </router-link>
                </ul>
            </div>
    @endcan --}}

    @can('isGGM')
        <header class="main-sidenav navbar navbar-expand-lg navbar-light bg-light navbar-white">
            <div class="container">
                <button class="navbar-toggler float-right" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent" style="font-size: 16px;">
                    <ul class="navbar-nav mr-auto mt-2">
                        <li class="nav-item">
                            <router-link :to="{ name: 'home', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link ">
                                <i class="fas fa-home text-orange fa-lg"></i>
                                <span>DASHBOARD</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name: 'uploading', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link">
                                <i class="fas fa-cloud-upload-alt text-orange fa-lg"></i>
                                <span>ITEM, PRICE</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name: 'setting', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link">
                                <i class="fas fa-cloud-upload-alt text-orange fa-lg"></i>
                                <span>IMAGE FILENAME AND CATEGORY</span>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
    @endcan

    @can('isIAD')
        <header class="main-sidenav navbar navbar-expand-lg navbar-light bg-light navbar-white">
            <div class="container">
                <button class="navbar-toggler float-right" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent" style="font-size: 16px;">
                    <ul class="navbar-nav mr-auto mt-2">
                        <li class="nav-item">
                            <router-link :to="{ name: 'liquidition_store', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link">
                                <i class="fas fa-clipboard-list text-orange fa-lg"></i>
                                <span>LIQUIDITION REPORT</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                :to="{ name: 'accountability_store', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link">
                                <i class="fas fa-clipboard-list text-orange fa-lg"></i>
                                <span>CASHIER ACCOUNTABILITY REPORT</span>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
    @endcan

    @can('isPurchasing')
        <header class="main-sidenav navbar navbar-expand-lg navbar-light bg-light navbar-white">
            <div class="container">
                <button class="navbar-toggler float-right" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent" style="font-size: 16px;">
                    <ul class="navbar-nav mr-auto mt-2">
                        <li class="nav-item">
                            <router-link :to="{ name: 'home', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link ">
                                <i class="fas fa-home text-orange fa-lg"></i>
                                <span>DASHBOARD</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name: 'item', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link">
                                <i class="fas fa-shopping-cart text-orange fa-lg"></i>
                                <span>ITEM MASTERFILE</span>
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name: 'disabled_item', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link ">
                                <i class="fas fa-cloud-upload-alt text-orange fa-lg"></i>
                                <span>UPLOAD ITEM CODE TO DISABLE</span>
                            </router-link>
                        </li>
                        <li class="nav-item ml-1">
                            <router-link :to="{ name: 'reports_store', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link ">
                                <i class="fas fa-clipboard-list text-orange fa-lg"></i>
                                <span>ITEM REPORT</span>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
    @endcan

    @can('isAccounting')
        <header class="main-sidenav navbar navbar-expand-lg navbar-light bg-light navbar-white">
            <div class="container">
                <button class="navbar-toggler float-right" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent" style="font-size: 16px;">
                    <ul class="navbar-nav mr-auto mt-2">
                        <li class="nav-item">
                            <router-link :to="{ name: 'export', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link ">
                                <p>EXPORT FILES</p>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
    @endcan

    @can('isSupervisor')
        <header class="main-sidenav navbar navbar-expand-lg navbar-light bg-light navbar-white">
            <div class="container">
                <button class="navbar-toggler float-right" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent" style="font-size: 16px;">
                    <ul class="navbar-nav mr-auto mt-2">
                        <li class="nav-item ml-1">
                            <router-link
                                :to="{ name: 'liquidition_store', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class="nav-link">
                                <i class="fas fa-clipboard-list text-orange fa-lg"></i>
                                <span>LIQUIDITION REPORT</span>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
    @endcan

    <div class="p-5 mt-2">
        {{-- <transition enter-active-class="ease-out duration-700" enter-class="opacity-0" enter-to-class="opacity-100"
            leave-active-class="ease-in duration-300" leave-class="opacity-100" leave-to-class="opacity-0">
            <router-view></router-view>
        </transition> --}}
        <router-view></router-view>

    </div>
@endsection
