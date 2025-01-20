<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer Verification') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('customer.update', $customer->user_id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div>
                                <p class="text-sm mt-2 text-gray-800">
                                    {{ __('Your email address is unverified.') }}

                                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 font-medium text-sm text-green-600">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Address -->
                    <div>
                        <x-input-label for="address" :value="__('Address')"/>
                        <textarea class="form-control border-gray-300 rounded-md w-full mt-1" placeholder="Address" rows="2" id="address" name="address"
                            required>{{$customer->address}}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <!-- Birth -->
                    <div>
                        <x-input-label for="birth" :value="__('Date of Birth')"/>
                        <input class="form-control border-gray-300 rounded-md w-full mt-1" type="date" id="birth" name="birth"
                            value="{{ old('birth', $customer->birth) }}" required>
                        <x-input-error :messages="$errors->get('birth')" class="mt-2" />
                    </div>

                    <!-- Gender -->
                    <div>
                        <x-input-label for="gender" :value="__('Gender')"/>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="man" value="Man"
                                {{ ($customer->gender=="Man")? "checked" : "" }} required>
                            <label class="form-check-label" for="man">Man</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="woman" value="Girl"
                                {{ ($customer->gender=="Girl")? "checked" : "" }} required>
                            <label class="form-check-label" for="woman">Woman</label>
                        </div>
                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                    </div>

                    <!-- Phone -->
                    <div>
                        <x-input-label for="phone" :value="__('Phone Number')"/>
                        <input class="form-control border-gray-300 rounded-md w-full mt-1" placeholder="08**********" id="phone" name="phone"
                            value="{{$customer->phone}}" required>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-center gap-4 mt-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>

                        @if (session('status') === 'profile-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600"
                            >{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>