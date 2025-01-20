<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>

                @if(Auth::user()->hasRole('manager'))
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('manager.promo')" :active="request()->routeIs('manager.promo') || request()->routeIs('promo.create') || request()->routeIs('searchPromo') || request()->routeIs('promo.index') || request()->routeIs('promo.edit')">
                        {{ __('Promo') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('manager.shift')" :active="request()->routeIs('manager.shift') || request()->routeIs('shift.create') || request()->routeIs('shift.index') || request()->routeIs('searchShift') || request()->routeIs('shift.edit')">
                        {{ __('Shift') }}
                    </x-nav-link>
                </div>
                @endif

                @if(Auth::user()->hasRole('admin'))
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('car.index')" :active="request()->routeIs('car.index') || request()->routeIs('car.edit') || request()->routeIs('searchCar') || request()->routeIs('carMitra') || request()->routeIs('mitraAdmin.edit')">
                        {{ __('Car') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('employee.index')" :active="request()->routeIs('employee.index') || request()->routeIs('searchEmployee') || request()->routeIs('employee.edit')">
                        {{ __('Employee') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('driver.index')" :active="request()->routeIs('driver.index') || request()->routeIs('searchDriver') || request()->routeIs('driver.edit')">
                        {{ __('Driver') }}
                    </x-nav-link>
                </div>
                @endif

                @if(Auth::user()->hasRole('customerServices'))
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('customer.index')" :active="request()->routeIs('customer.index') || request()->routeIs('customer.edit') || request()->routeIs('searchCustomer')">
                        {{ __('Customer Verification') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('transactionCS.index')" :active="request()->routeIs('transactionCS.index') || request()->routeIs('transactionCS.edit') || request()->routeIs('searchTransaction')">
                        {{ __('Transaction Verification') }}
                    </x-nav-link>
                </div>
                @endif

                @if(Auth::user()->hasRole('customer'))
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('transaction.index')" :active="request()->routeIs('transaction.index') || request()->routeIs('transaction.create') || request()->routeIs('transaction.edit')">
                        {{ __('Rental') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('mitra.index')" :active="request()->routeIs('mitra.index') || request()->routeIs('mitra.create') || request()->routeIs('mitra.edit') || request()->routeIs('searchMitra')">
                        {{ __('Mitra') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('note.index')" :active="request()->routeIs('note.index')">
                        {{ __('Note') }}
                    </x-nav-link>
                </div>
                @endif

                @if(Auth::user()->hasRole('driver'))
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('transactionDriver.index')" :active="request()->routeIs('transactionDriver.index')">
                        {{ __('Order') }}
                    </x-nav-link>
                </div>
                @endif
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
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

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        @if(Auth::user()->hasRole('manager'))
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('manager.promo')" :active="request()->routeIs('manager.promo') || request()->routeIs('promo.create') || request()->routeIs('searchPromo') || request()->routeIs('promo.index') || request()->routeIs('promo.edit')">
                {{ __('Promo') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('manager.shift')" :active="request()->routeIs('manager.shift') || request()->routeIs('shift.create') || request()->routeIs('shift.index') || request()->routeIs('searchShift') || request()->routeIs('shift.edit')">
                {{ __('Shift') }}
            </x-responsive-nav-link>
        </div>
        @endif

        @if(Auth::user()->hasRole('admin'))
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('car.index')" :active="request()->routeIs('car.index') || request()->routeIs('searchCar') || request()->routeIs('carMitra') || request()->routeIs('mitraAdmin.edit')">
                {{ __('Car') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('employee.index')" :active="request()->routeIs('employee.index') || request()->routeIs('searchEmployee') || request()->routeIs('employee.edit')">
                {{ __('Employee') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('driver.index')" :active="request()->routeIs('driver.index') || request()->routeIs('searchDriver') || request()->routeIs('driver.edit')">
                {{ __('Driver') }}
            </x-responsive-nav-link>
        </div>
        @endif

        @if(Auth::user()->hasRole('customerServices'))
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('customer.index')" :active="request()->routeIs('customer.index') || request()->routeIs('customer.edit') || request()->routeIs('searchCustomer')">
                {{ __('Customer Verification') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('transactionCS.index')" :active="request()->routeIs('transactionCS.index') || request()->routeIs('transactionCS.edit') || request()->routeIs('searchTransaction')">
                {{ __('Transaction Verification') }}
            </x-responsive-nav-link>
        </div>
        @endif

        @if(Auth::user()->hasRole('customer'))
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('transaction.index')" :active="request()->routeIs('transaction.index') || request()->routeIs('transaction.create') || request()->routeIs('transaction.edit')">
                {{ __('Rental') }}
            </x-responsive-nav-link>
        </div>
        
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('mitra.index')" :active="request()->routeIs('mitra.index') || request()->routeIs('mitra.create') || request()->routeIs('mitra.edit') || request()->routeIs('searchMitra')">
                {{ __('Mitra') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('note.index')" :active="request()->routeIs('note.index')">
                {{ __('Note') }}
            </x-responsive-nav-link>
        </div>
        @endif

        @if(Auth::user()->hasRole('driver'))
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('transactionDriver.index')" :active="request()->routeIs('transactionDriver.index')">
                {{ __('Order') }}
            </x-responsive-nav-link>
        </div>
        @endif

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

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
