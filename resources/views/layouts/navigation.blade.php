<nav x-data="{
    open: false,
    uploadOpen: false,
    dataOpen: false,
    // Upload submenu state
    umumOpen: false,
    toeflOpen: false,
    smkOpen: false,
    smpOpen: false,
    sdOpen: false,
    // Data submenu state
    dataUmumOpen: false,
    dataSmaOpen: false,
    dataSmkOpen: false,
    dataSmpOpen: false,
    dataSdOpen: false
  }" class="bg-white border-b border-gray-100">
  <!-- Primary Navigation Menu -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16">
      <div class="flex">
        <!-- Logo -->
        <div class="shrink-0 flex items-center">
          <a href="{{ route('dashboard') }}">
            <img src="{{ asset('img/test.png') }}" alt="Logo" class="block h-9 w-auto">
          </a>
        </div>

        <!-- Dashboard Link -->
        <div class="hidden space-x-8 sm:-my-px px-2  sm:ms-10 sm:flex items-center">
          <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
          </x-nav-link>
        </div>

        <!-- Data Dropdown -->
        <div @click.away="dataOpen = false; dataSmaOpen = dataSmkOpen = dataSmpOpen = dataSdOpen = false"
             class="relative hidden sm:flex sm:items-center sm:ms-10">
          <button @click="dataOpen = !dataOpen"
                  class="inline-flex items-center px-2 pt-1 text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none transition">
            Data
            <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.944l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z"
                    clip-rule="evenodd"/>
            </svg>
          </button>
          <div x-show="dataOpen" x-transition
               class="absolute left-0 mt-60 w-48 bg-white border rounded shadow-lg z-50"
               style="display: none;">
            <!-- Umum -->
            <div class="relative">
              <button @click="dataUmumOpen = !dataUmumOpen; dataSmaOpen = dataSmkOpen = dataSmpOpen = dataSdOpen = false"
                      class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex justify-between items-center">
                Umum
                <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                        d="M7.21 5.23a.75.75 0 011.06-.02l4.24 4.24a.75.75 0 010 1.06l-4.24 4.24a.75.75 0 11-1.06-1.06L10.944 10 7.21 6.29a.75.75 0 01-.02-1.06z"
                        clip-rule="evenodd"/>
                </svg>
              </button>
              <div x-show="dataUmumOpen" x-transition
                   class="absolute left-full top-0 ml-1 w-56 bg-white border rounded shadow-lg z-50"
                   style="display: none;">
                <a href="{{ route('data.toeflumum') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">TOEFL iBT</a>
                <a href="{{ route('data.ieltstestcumum') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">IELTS </a>
                <a href="{{ route('data.toeicumum') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">TOEIC</a>
                <a href="{{ route('data.toefljuniorumum') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">TOEFL Junior </a>
                <a href="{{ route('data.toeflprimarystep1umum') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">TOEFL Primary Step 1</a>
                <a href="{{ route('data.toeflprimarystep2umum') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">TOEFL Primary Step 2 </a>
              </div>
            </div>
            <!-- SMA -->
            <div class="relative">
              <button @click="dataSmaOpen = !dataSmaOpen; dataUmumOpen = dataSmkOpen = dataSmpOpen = dataSdOpen = false"
                      class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex justify-between items-center">
                SMA
                <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                        d="M7.21 5.23a.75.75 0 011.06-.02l4.24 4.24a.75.75 0 010 1.06l-4.24 4.24a.75.75 0 11-1.06-1.06L10.944 10 7.21 6.29a.75.75 0 01-.02-1.06z"
                        clip-rule="evenodd"/>
                </svg>
              </button>
              <div x-show="dataSmaOpen" x-transition
                   class="absolute left-full top-0 ml-1 w-56 bg-white border rounded shadow-lg z-50"
                   style="display: none;">
                <a href="{{ route('data.toefl') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">TOEFL iBT</a>
                <a href="{{ route('data.ieltstestc') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">IELTS </a>
              </div>
            </div>
            <!-- SMK -->
            <div class="relative">
              <button @click="dataSmkOpen = !dataSmkOpen; dataUmumOpen = dataSmaOpen = dataSmpOpen = dataSdOpen = false"
                      class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex justify-between items-center">
                SMK
                <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                        d="M7.21 5.23a.75.75 0 011.06-.02l4.24 4.24a.75.75 0 010 1.06l-4.24 4.24a.75.75 0 11-1.06-1.06L10.944 10 7.21 6.29a.75.75 0 01-.02-1.06z"
                        clip-rule="evenodd"/>
                </svg>
              </button>
              <div x-show="dataSmkOpen" x-transition
                   class="absolute left-full top-0 ml-1 w-48 bg-white border rounded shadow-lg z-50"
                   style="display: none;">
                <a href="{{ route('data.toeic') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">TOEIC</a>
              </div>
            </div>
            <!-- SMP -->
            <div class="relative">
              <button @click="dataSmpOpen = !dataSmpOpen; dataUmumOpen = dataSmaOpen = dataSmkOpen = dataSdOpen = false"
                      class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex justify-between items-center">
                SMP
                <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                        d="M7.21 5.23a.75.75 0 011.06-.02l4.24 4.24a.75.75 0 010 1.06l-4.24 4.24a.75.75 0 11-1.06-1.06L10.944 10 7.21 6.29a.75.75 0 01-.02-1.06z"
                        clip-rule="evenodd"/>
                </svg>
              </button>
              <div x-show="dataSmpOpen" x-transition
                   class="absolute left-full top-0 ml-1 w-48 bg-white border rounded shadow-lg z-50"
                   style="display: none;">
                <a href="{{ route('data.toefljunior') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">TOEFL Junior</a>
              </div>
            </div>
            <!-- SD -->
            <div class="relative">
              <button @click="dataSdOpen = !dataSdOpen; dataUmumOpen = dataSmaOpen = dataSmkOpen = dataSmpOpen = false"
                      class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex justify-between items-center">
                SD
                <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                        d="M7.21 5.23a.75.75 0 011.06-.02l4.24 4.24a.75.75 0 010 1.06l-4.24 4.24a.75.75 0 11-1.06-1.06L10.944 10 7.21 6.29a.75.75 0 01-.02-1.06z"
                        clip-rule="evenodd"/>
                </svg>
              </button>
              <div x-show="dataSdOpen" x-transition
                   class="absolute left-full top-0 ml-1 w-56 bg-white border rounded shadow-lg z-50"
                   style="display: none;">
                <a href="{{ route('data.toeflprimarystep1') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">Toefl Primary Step 1</a>
                <a href="{{ route('data.toeflprimarystep2') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">Toefl Primary Step 2</a>
              </div>
            </div>
          </div>
        </div>





        <!-- Score Conversion Dropdown -->
        <div @click.away="uploadOpen = false; toeflOpen = false; smkOpen = false; smpOpen = false; sdOpen = false"
             class="relative hidden sm:flex sm:items-center sm:ms-10">
             <button @click="uploadOpen = !uploadOpen"
                class="
                    inline-flex items-center px-2 pt-1 text-sm font-medium focus:outline-none transition
                    {{ request()->routeIs('scores.*') || request()->routeIs('conversion.*')
                        ? 'text-blue-600 border-b-2 border-blue-600'
                        : 'text-gray-700 hover:text-gray-900' }}
                ">
            Score Conversion
            <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.944l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z"
                    clip-rule="evenodd"/>
            </svg>
        </button>

          <div x-show="uploadOpen"
               x-transition
               class="absolute left-0 mt-48 w-48 bg-white border rounded shadow-lg z-50"
               style="display: none;">
              <!-- Umum -->
            <div class="relative">
              <button @click="umumOpen = !umumOpen; toeflOpen = false; smkOpen = false; smpOpen = false; sdOpen = false"
                      class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex justify-between items-center">
                Umum
                <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                        d="M7.21 5.23a.75.75 0 011.06-.02l4.24 4.24a.75.75 0 010 1.06l-4.24 4.24a.75.75 0 11-1.06-1.06L10.944 10 7.21 6.29a.75.75 0 01-.02-1.06z"
                        clip-rule="evenodd" />
                </svg>
              </button>
              <div x-show="umumOpen"
                   x-transition
                   class="absolute left-full top-0 ml-1 w-64 bg-white border rounded shadow-lg z-50"
                   style="display: none;">
                <a href="{{ route('uploadumum') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  TOEFL iBT
                </a>
                <a href="{{ route('uploadIeltsTestCumum') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  IELTS 
                </a>
                  <a href="{{ route('uploadToeicumum') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  TOEIC
                </a>
                <a href="{{ route('uploadJuniorumum') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  TOEFL Junior
                </a>
                <a href="{{ route('uploadToeflPrimaryStep1umum') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">Toefl Primary Step 1</a>
                <a href="{{ route('uploadToeflPrimaryStep2umum') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">Toefl Primary Step 2</a>
              </div>
            </div>


               
            <!-- SMA -->
            <div class="relative">
              <button @click="toeflOpen = !toeflOpen; umumOpen = false; smkOpen = false; smpOpen = false; sdOpen = false"
                      class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex justify-between items-center">
                SMA
                <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                        d="M7.21 5.23a.75.75 0 011.06-.02l4.24 4.24a.75.75 0 010 1.06l-4.24 4.24a.75.75 0 11-1.06-1.06L10.944 10 7.21 6.29a.75.75 0 01-.02-1.06z"
                        clip-rule="evenodd" />
                </svg>
              </button>
              <div x-show="toeflOpen"
                   x-transition
                   class="absolute left-full top-0 ml-1 w-64 bg-white border rounded shadow-lg z-50"
                   style="display: none;">
                <a href="{{ route('upload') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  TOEFL iBT
                </a>
                <a href="{{ route('uploadIeltsTestC') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  IELTS 
                </a>
              </div>
            </div>

            <!-- SMK -->
            <div class="relative">
              <button @click="smkOpen = !smkOpen; toeflOpen = false; smpOpen = false; sdOpen = false"
                      class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex justify-between items-center">
                SMK
                <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                        d="M7.21 5.23a.75.75 0 011.06-.02l4.24 4.24a.75.75 0 010 1.06l-4.24 4.24a.75.75 0 11-1.06-1.06L10.944 10 7.21 6.29a.75.75 0 01-.02-1.06z"
                        clip-rule="evenodd" />
                </svg>
              </button>
              <div x-show="smkOpen"
                   x-transition
                   class="absolute left-full top-0 ml-1 w-64 bg-white border rounded shadow-lg z-50"
                   style="display: none;">
                <a href="{{ route('uploadToeic') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  TOEIC
                </a>
              </div>
            </div>

            <!-- SMP -->
            <div class="relative">
              <button @click="smpOpen = !smpOpen; toeflOpen = false; smkOpen = false; sdOpen = false"
                      class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex justify-between items-center">
                SMP
                <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                        d="M7.21 5.23a.75.75 0 011.06-.02l4.24 4.24a.75.75 0 010 1.06l-4.24 4.24a.75.75 0 11-1.06-1.06L10.944 10 7.21 6.29a.75.75 0 01-.02-1.06z"
                        clip-rule="evenodd" />
                </svg>
              </button>
              <div x-show="smpOpen"
                   x-transition
                   class="absolute left-full top-0 ml-1 w-64 bg-white border rounded shadow-lg z-50"
                   style="display: none;">
                <a href="{{ route('uploadJunior') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  TOEFL Junior
                </a>
              </div>
            </div>

            <!-- SD -->
            <div class="relative">
              <button @click="sdOpen = !sdOpen; toeflOpen = false; smkOpen = false; smpOpen = false"
                      class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex justify-between items-center">
                SD
                <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                        d="M7.21 5.23a.75.75 0 011.06-.02l4.24 4.24a.75.75 0 010 1.06l-4.24 4.24a.75.75 0 11-1.06-1.06L10.944 10 7.21 6.29a.75.75 0 01-.02-1.06z"
                        clip-rule="evenodd" />
                </svg>
              </button>
              <div x-show="sdOpen"
                   x-transition
                   class="absolute left-full top-0 ml-1 w-64 bg-white border rounded shadow-lg z-50"
                   style="display: none;">
                  <a href="{{ route('uploadToeflPrimaryStep1') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">Toefl Primary Step 1</a>
                  <a href="{{ route('uploadToeflPrimaryStep2') }}"
                   class="block px-6 py-2 text-sm text-gray-700 hover:bg-gray-100">Toefl Primary Step 2</a>
               
              </div>
            </div>
          </div>

           <!-- Dashboard Link -->
          <div class="hidden space-x-8 sm:-my-px px-2  sm:ms-10 sm:flex items-center">
            <x-nav-link :href="route('panduan')" :active="request()->routeIs('panduan')">
              {{ __('Panduan') }}
            </x-nav-link>
          </div>
        </div>
      </div>

      <!-- Settings Dropdown -->
      <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('data.toefl')" :active="request()->routeIs('data.toefl')">
                {{ __('Data') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('upload')">
                {{ __('Upload TOEFL iBT') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('uploadJunior')">
                {{ __('Upload TOEFL Junior') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
  
</nav>
