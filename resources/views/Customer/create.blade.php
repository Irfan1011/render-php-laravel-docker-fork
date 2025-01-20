<x-guest-layout>
    <form method="POST" action="{{ route('customer.store') }}">
        @csrf

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Address')"/>
            <textarea class="form-control border-gray-300 rounded-md w-full mt-1" placeholder="Address" rows="2" id="address" name="address"
                required>{{old('address')}}</textarea>
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Birth -->
        <div class="mt-4">
            <x-input-label for="birth" :value="__('Date of Birth')"/>
            <input class="form-control border-gray-300 rounded-md w-full mt-1" type="date" id="birth" name="birth"
                value="{{old('birth')}}" required>
            <x-input-error :messages="$errors->get('birth')" class="mt-2" />
        </div>

        <!-- Gender -->
        <div class="mt-4">
            <x-input-label for="gender" :value="__('Gender')"/>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="man" value="Man"
                    {{ (old('gender')=="Man")? "checked" : "" }} required>
                <label class="form-check-label" for="man">Man</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="woman" value="Girl"
                    {{ (old('gender')=="Girl")? "checked" : "" }} required>
                <label class="form-check-label" for="woman">Woman</label>
            </div>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone Number')"/>
            <input class="form-control border-gray-300 rounded-md w-full mt-1" placeholder="08**********" id="phone" name="phone"
                value="{{old('phone')}}" required>
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>