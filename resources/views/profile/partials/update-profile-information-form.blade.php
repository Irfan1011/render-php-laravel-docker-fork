<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        @if(Auth::user()->hasRole('customer'))
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
        @elseif(Auth::user()->hasRole('customerServices') || Auth::user()->hasRole('admin'))
        <!-- Photo -->
        <div>
            <x-input-label for="photo" :value="__('SelfPicture')"/>
            <input class="form-control border rounded-md w-full mt-1" id="photo" name="photo" type="file" required>
            @if ($employee->photo)
                <p><img src="{{ asset('uploads/employee_photo/'.$employee->photo) }}" alt="Photo" width="250px" height="250px" class="mt-2">Current File: {{ $employee->photo }} </p>
            @else
                <p>No File Uploaded</p>
            @endif
            <x-input-error :messages="$errors->get('photo')" class="mt-2" />
        </div>

        <!-- Address -->
        <div>
            <x-input-label for="address" :value="__('Address')"/>
            <textarea class="form-control border-gray-300 rounded-md w-full mt-1" placeholder="Address" rows="2" id="address" name="address"
                required>{{$employee->address}}</textarea>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Birth -->
        <div>
            <x-input-label for="birth" :value="__('Date of Birth')"/>
            <input class="form-control border-gray-300 rounded-md w-full mt-1" type="date" id="birth" name="birth"
                value="{{ old('birth', $employee->birth) }}" required>
            <x-input-error :messages="$errors->get('birth')" class="mt-2" />
        </div>

        <!-- Gender -->
        <div>
            <x-input-label for="gender" :value="__('Gender')"/>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="man" value="Man"
                    {{ ($employee->gender=="Man")? "checked" : "" }} required>
                <label class="form-check-label" for="man">Man</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="woman" value="Girl"
                    {{ ($employee->gender=="Girl")? "checked" : "" }} required>
                <label class="form-check-label" for="woman">Woman</label>
            </div>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('Phone Number')"/>
            <input class="form-control border-gray-300 rounded-md w-full mt-1" placeholder="08**********" id="phone" name="phone"
                value="{{$employee->phone}}" required>
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>
        @elseif(Auth::user()->hasRole('driver'))
        <!-- Photo -->
        <div>
            <x-input-label for="photo" :value="__('SelfPicture')"/>
            <input class="form-control border rounded-md w-full mt-1" id="photo" name="photo" type="file" required>
            @if ($driver->photo)
                <p><img src="{{ asset('uploads/driver_photo/'.$driver->photo) }}" alt="Photo" width="250px" height="250px" class="mt-2">Current File: {{ $driver->photo }} </p>
            @else
                <p>No File Uploaded</p>
            @endif
            <x-input-error :messages="$errors->get('photo')" class="mt-2" />
        </div>

        <!-- Address -->
        <div>
            <x-input-label for="address" :value="__('Address')"/>
            <textarea class="form-control border-gray-300 rounded-md w-full mt-1" placeholder="Address" rows="2" id="address" name="address"
                required>{{$driver->address}}</textarea>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Birth -->
        <div>
            <x-input-label for="birth" :value="__('Date of Birth')"/>
            <input class="form-control border-gray-300 rounded-md w-full mt-1" type="date" id="birth" name="birth"
                value="{{ old('birth', $driver->birth) }}" required>
            <x-input-error :messages="$errors->get('birth')" class="mt-2" />
        </div>

        <!-- Gender -->
        <div>
            <x-input-label for="gender" :value="__('Gender')"/>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="man" value="Man"
                    {{ ($driver->gender=="Man")? "checked" : "" }} required>
                <label class="form-check-label" for="man">Man</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="woman" value="Girl"
                    {{ ($driver->gender=="Girl")? "checked" : "" }} required>
                <label class="form-check-label" for="woman">Woman</label>
            </div>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('Phone Number')"/>
            <input class="form-control border-gray-300 rounded-md w-full mt-1" placeholder="08**********" id="phone" name="phone"
                value="{{$driver->phone}}" required>
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Language -->
        <div>
            <x-input-label for="language" :value="__('Language')"/>
            <select class="block mt-1 w-full rounded-md border-gray-300" name="language" required>
                <option value="English + Bahasa Indonesia" <?= $driver->language == "English + Bahasa Indonesia" ? "selected" : ""?>>English + Bahasa Indonesia</option>
                <option value="Bahasa Indonesia" <?= $driver->language == "Bahasa Indonesia" ? "selected" : ""?>>Bahasa Indonesia</option>
                <option value="English" <?= $driver->language == "English" ? "selected" : ""?>>English</option>
            </select>
            <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
        </div>
        @endif

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

        <div class="flex items-center gap-4">
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
</section>
