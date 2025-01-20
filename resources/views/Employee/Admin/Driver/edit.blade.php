<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Driver') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('driver.update', $driver->user_id) }}" enctype="multipart/form-data">
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

                    <!-- Photo -->
                    <div>
                        <x-input-label for="selfPicture" :value="__('SelfPicture')"/>
                        <input class="form-control border rounded-md w-full mt-1" id="photo" name="photo" type="file" required>
                        @if ($driver->photo)
                            <p><img src="{{ asset('uploads/driver_photo/'.$driver->photo) }}" alt="Photo" width="250px" height="250px" class="mt-2">Current File: {{ $driver->photo }} </p>
                        @else
                            <p>No File Uploaded</p>
                        @endif
                        <x-input-error :messages="$errors->get('selfPicture')" class="mt-2" />
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

                    <!-- Photocopy / Scan Driver's License -->
                    <div>
                        <x-input-label for="photocopy_scanDriverLicense" :value="__('Photocopy / Scan Driver License')"/>
                        <input class="form-control border rounded-md w-full mt-1" id="photocopy_scanDriverLicense" name="photocopy_scanDriverLicense" type="file" required>
                        @if ($driver->photocopy_scanDriverLicense)
                            <p><embed src="{{ asset('uploads/driver_file/'.$driver->photocopy_scanDriverLicense) }}" alt="Photo" width="250px" height="250px" class="mt-2"/>Current File: {{ $driver->photocopy_scanDriverLicense }} </p>
                        @else
                            <p>No File Uploaded</p>
                        @endif
                        <x-input-error :messages="$errors->get('photocopy_scanDriverLicense')" class="mt-2" />
                    </div>

                    <!-- Drug Free Letter -->
                    <div>
                        <x-input-label for="drug_free_letter" :value="__('Drug Free Letter')"/>
                        <input class="form-control border rounded-md w-full mt-1" id="drug_free_letter" name="drug_free_letter" type="file" required>
                        @if ($driver->drug_free_letter)
                            <p><embed src="{{ asset('uploads/driver_file/'.$driver->drug_free_letter) }}" alt="Photo" width="250px" height="250px" class="mt-2"/>Current File: {{ $driver->drug_free_letter }} </p>
                        @else
                            <p>No File Uploaded</p>
                        @endif
                        <x-input-error :messages="$errors->get('drug_free_letter')" class="mt-2" />
                    </div>

                    <!-- Mental Health Letter -->
                    <div>
                        <x-input-label for="mental_health_letter" :value="__('Mental Health Letter')"/>
                        <input class="form-control border rounded-md w-full mt-1" id="mental_health_letter" name="mental_health_letter" type="file" required>
                        @if ($driver->mental_health_letter)
                            <p><embed src="{{ asset('uploads/driver_file/'.$driver->mental_health_letter) }}" alt="Photo" width="250px" height="250px" class="mt-2"/>Current File: {{ $driver->mental_health_letter }} </p>
                        @else
                            <p>No File Uploaded</p>
                        @endif
                        <x-input-error :messages="$errors->get('mental_health_letter')" class="mt-2" />
                    </div>

                    <!-- Physical Health Certificate -->
                    <div>
                        <x-input-label for="physical_health_certificate" :value="__('Physical Health Certificate')"/>
                        <input class="form-control border rounded-md w-full mt-1" id="physical_health_certificate" name="physical_health_certificate" type="file" required>
                        @if ($driver->physical_health_certificate)
                            <p><embed src="{{ asset('uploads/driver_file/'.$driver->physical_health_certificate) }}" alt="Photo" width="250px" height="250px" class="mt-2"/>Current File: {{ $driver->physical_health_certificate }} </p>
                        @else
                            <p>No File Uploaded</p>
                        @endif
                        <x-input-error :messages="$errors->get('physical_health_certificate')" class="mt-2" />
                    </div>

                    <!-- Criminal Record Certificate -->
                    <div>
                        <x-input-label for="criminal_record_certificate" :value="__('Criminal Record Certificate')"/>
                        <input class="form-control border rounded-md w-full mt-1" id="criminal_record_certificate" name="criminal_record_certificate" type="file" required>
                        @if ($driver->criminal_record_certificate)
                            <p><embed src="{{ asset('uploads/driver_file/'.$driver->criminal_record_certificate) }}" alt="Photo" width="250px" height="250px" class="mt-2"/>Current File: {{ $driver->criminal_record_certificate }} </p>
                        @else
                            <p>No File Uploaded</p>
                        @endif
                        <x-input-error :messages="$errors->get('criminal_record_certificate')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-center gap-4 mt-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>

                        @if (session('status') === 'driver-updated')
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