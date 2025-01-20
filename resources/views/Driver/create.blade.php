<x-guest-layout>
    <form method="POST" action="{{ route('driver.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Photo -->
        <div class="mt-4">
            <x-input-label for="selfPicture" :value="__('SelfPicture')"/>
            <input class="form-control border rounded-md w-full mt-1" id="photo" name="photo" type="file" value="{{old('photo')}}"
                required>
            <x-input-error :messages="$errors->get('selfPicture')" class="mt-2" />
        </div>

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

        <!-- Language -->
        <div class="mt-4">
            <x-input-label for="language" :value="__('Language')"/>
            <select class="form-select border-gray-300 rounded-md w-full mt-1" name="language" id="language" required>
                <option value="English + Bahasa Indonesia"
                    <?= old('language') == "English + Bahasa Indonesia" ? "selected" : ""?>>English + Bahasa
                    Indonesia</option>
                <option value="Bahasa Indonesia" <?= old('language') == "Bahasa Indonesia" ? "selected" : ""?>>
                    Bahasa Indonesia</option>
                <option value="English" <?= old('language') == "English" ? "selected" : ""?>>English</option>
            </select>
            <x-input-error :messages="$errors->get('language')" class="mt-2" />
        </div>

        <!-- Photocopy / Scan Driver's License -->
        <div class="mt-4">
            <x-input-label for="photocopy_scanDriverLicense" :value="__('Photocopy / Scan Driver License')"/>
            <input class="form-control border rounded-md w-full mt-1" id="photocopy_scanDriverLicense" name="photocopy_scanDriverLicense" type="file" value="{{old('photocopy_scanDriverLicense')}}"
                required>
            <x-input-error :messages="$errors->get('photocopy_scanDriverLicense')" class="mt-2" />
        </div>

        <!-- Drug Free Letter -->
        <div class="mt-4">
            <x-input-label for="drug_free_letter" :value="__('Drug Free Letter')"/>
            <input class="form-control border rounded-md w-full mt-1" id="drug_free_letter" name="drug_free_letter" type="file" value="{{old('drug_free_letter')}}"
                required>
            <x-input-error :messages="$errors->get('drug_free_letter')" class="mt-2" />
        </div>

        <!-- Mental Health Letter -->
        <div class="mt-4">
            <x-input-label for="mental_health_letter" :value="__('Mental Health Letter')"/>
            <input class="form-control border rounded-md w-full mt-1" id="mental_health_letter" name="mental_health_letter" type="file" value="{{old('mental_health_letter')}}"
                required>
            <x-input-error :messages="$errors->get('mental_health_letter')" class="mt-2" />
        </div>

        <!-- Physical Health Certificate -->
        <div class="mt-4">
            <x-input-label for="physical_health_certificate" :value="__('Physical Health Certificate')"/>
            <input class="form-control border rounded-md w-full mt-1" id="physical_health_certificate" name="physical_health_certificate" type="file" value="{{old('physical_health_certificate')}}"
                required>
            <x-input-error :messages="$errors->get('physical_health_certificate')" class="mt-2" />
        </div>
        
        <!-- Criminal Record Certificate -->
        <div class="mt-4">
            <x-input-label for="criminal_record_certificate" :value="__('Criminal Record Certificate')"/>
            <input class="form-control border rounded-md w-full mt-1" id="criminal_record_certificate" name="criminal_record_certificate" type="file" value="{{old('criminal_record_certificate')}}"
                required>
            <x-input-error :messages="$errors->get('criminal_record_certificate')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>