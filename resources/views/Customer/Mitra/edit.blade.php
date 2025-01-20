<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mitra') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('mitra.update', $mitra->id) }}" method="post">
                        @csrf
                        @method('patch')
                        <!-- Car Name -->
                        <div>
                            <x-input-label for="car_name" :value="__('Car Name')" />
                            <input id="car_name" class="block mt-1 w-full" type="text" name="car_name" placeholder="Car Name" value="{{old('car_name', $mitra->car_name)}}" required autofocus/>
                            <x-input-error :messages="$errors->get('car_name')" class="mt-2" />
                        </div>

                        <!-- Car Type -->
                        <div>
                            <x-input-label for="car_type" :value="__('Car Type')" />
                            <input id="car_type" class="block mt-1 w-full" type="text" name="car_type" placeholder="Car Type" value="{{old('car_type', $mitra->car_type)}}" required/>
                            <x-input-error :messages="$errors->get('car_type')" class="mt-2" />
                        </div>

                        <!-- Transmission Type -->
                        <div>
                            <x-input-label for="transmission_type" :value="__('Transmission Type')" />
                            <input id="transmission_type" class="block mt-1 w-full" type="text" name="transmission_type" placeholder="Transmission Type" value="{{old('transmission_type', $mitra->transmission_type)}}" required/>
                            <x-input-error :messages="$errors->get('transmission_type')" class="mt-2" />
                        </div>

                        <!-- Fuel Type -->
                        <div>
                            <x-input-label for="fuel_type" :value="__('Fuel Type')"/>
                            <select class="block mt-1 w-full rounded-md border-gray-300" name="fuel_type" required>
                                <option value="pertalite" <?= $mitra->fuel_type == "pertalite" ? "selected" : ""?>> Pertalite</option>
                                <option value="pertamax" <?= $mitra->fuel_type == "pertamax" ? "selected" : ""?>>Pertamax</option>
                            </select>
                            <x-input-error :messages="$errors->get('fuel_type')" class="mt-2" />
                        </div>

                        <!-- Fuel Volume -->
                        <div>
                            <x-input-label for="fuel_volume" :value="__('Fuel Volume')" />
                            <input id="fuel_volume" class="block mt-1 w-full" type="number" min="30" max="80" name="fuel_volume" placeholder="Fuel Volume (Liter)" value="{{old('fuel_volume', $mitra->fuel_volume)}}" required/>
                            <x-input-error :messages="$errors->get('fuel_volume')" class="mt-2" />
                        </div>

                        <!-- Color -->
                        <div>
                            <x-input-label for="color" :value="__('Color')" />
                            <input id="color" class="block mt-1 w-full" type="text" name="color" placeholder="Color" value="{{old('color', $mitra->color)}}" required/>
                            <x-input-error :messages="$errors->get('color')" class="mt-2" />
                        </div>

                        <!-- Passenger Capasity -->
                        <div>
                            <x-input-label for="passenger_capasity" :value="__('Passenger Capasity')" />
                            <input id="passenger_capasity" class="block mt-1 w-full" type="number" min="4" max="8" name="passenger_capasity" placeholder="4 Person" value="{{old('passenger_capasity', $mitra->passenger_capasity)}}" required/>
                            <x-input-error :messages="$errors->get('passenger_capasity')" class="mt-2" />
                        </div>

                        <!-- Facility -->
                        <div>
                            <x-input-label for="facility" :value="__('Facility')"/>
                            <select class="form-select" name="facility" id="facility" required>
                                <option value="AC" <?= $mitra->facility == "AC" ? "selected" : ""?>>AC</option>
                                <option value="Multimedia" <?= $mitra->facility == "Multimedia" ? "selected" : ""?>>Multimedia</option>
                                <option value="Safety (Air Bag)" <?= $mitra->facility == "Safety (Air Bag)" ? "selected" : ""?>>Safety (Air Bag)</option>
                                <option value="AC + Multimedia" <?= $mitra->facility == "AC + Multimedia" ? "selected" : ""?>>AC + Multimedia</option>
                                <option value="AC + Safety (Air Bag)"<?= $mitra->facility == "AC + Safety (Air Bag)" ? "selected" : ""?>>AC + Safety (Air Bag)</option>
                                <option value="Multimedia + Safety (Air Bag)"<?= $mitra->facility == "Multimedia + Safety (Air Bag)" ? "selected" : ""?>>Multimedia + Safety (Air Bag)</option>
                                <option value="AC + Multimedia + Safety (Air Bag)"<?= $mitra->facility == "AC + Multimedia + Safety (Air Bag)" ? "selected" : ""?>>AC + Multimedia + Safety (Air Bag)</option>
                            </select>
                            <x-input-error :messages="$errors->get('facility')" class="mt-2" />
                        </div>

                        <!-- Lisence Plate -->
                        <div>
                            <x-input-label for="license_plate" :value="__('Lisence Plate')" />
                            <input id="license_plate" class="block mt-1 w-full" type="text" name="license_plate" placeholder="XX 1234 XX" value="{{old('license_plate', $mitra->license_plate)}}" required/>
                            <x-input-error :messages="$errors->get('license_plate')" class="mt-2" />
                        </div>

                        <!-- Vehicle Registration Number -->
                        <div>
                            <x-input-label for="vehicle_registration_number" :value="__('Vehicle Registration Number')" />
                            <input id="vehicle_registration_number" class="block mt-1 w-full" type="text" name="vehicle_registration_number" placeholder="1234XX" value="{{old('vehicle_registration_number', $mitra->vehicle_registration_number)}}" required/>
                            <x-input-error :messages="$errors->get('vehicle_registration_number')" class="mt-2" />
                        </div>

                        <!-- Asset Category -->
                        <div>
                            <x-input-label for="asset_category" :value="__('Asset Category')"/>
                            <select class="form-select" name="asset_category" id="asset_category" disabled>
                                <option value="Mitra">Mitra</option>
                            </select>
                            <x-input-error :messages="$errors->get('asset_category')" class="mt-2" />
                            <input type="hidden" name="asset_category" value="Mitra">
                        </div>

                        <!-- Owner ID -->
                        <div>
                            <x-input-label for="owner_id" :value="__('Owner ID')" />
                            <input id="owner_id" class="block mt-1 w-full" type="text" name="owner_id" placeholder="1234XX" value="{{old('owner_id', $mitra->owner_id)}}" required/>
                            <x-input-error :messages="$errors->get('owner_id')" class="mt-2" />
                        </div>

                        <!-- Started Contract -->
                        <div>
                            <x-input-label for="started_contract" :value="__('Started Contract')"/>
                            <input class="form-control border-gray-300 rounded-md w-full mt-1" type="date" id="started_contract" name="started_contract" value="{{old('started_contract', $mitra->started_contract)}}" required>
                            <x-input-error :messages="$errors->get('started_contract')" class="mt-2" />
                        </div>

                        <!-- Ending Contract -->
                        <div>
                            <x-input-label for="ending_contract" :value="__('Ending Contract')"/>
                            <input class="form-control border-gray-300 rounded-md w-full mt-1" type="date" id="ending_contract" name="ending_contract" value="{{old('ending_contract', $mitra->ending_contract)}}" required>
                            <x-input-error :messages="$errors->get('ending_contract')" class="mt-2" />
                        </div>

                        <!-- Latest Day Service -->
                        <div>
                            <x-input-label for="latest_day_service" :value="__('Latest Day Service')"/>
                            <input class="form-control border-gray-300 rounded-md w-full mt-1" type="date" id="latest_day_service" name="latest_day_service" value="{{old('latest_day_service', $mitra->latest_day_service)}}" required>
                            <x-input-error :messages="$errors->get('latest_day_service')" class="mt-2" />
                        </div>

                        <div class="gap-2 mt-4 text-center">
                            <button type="submit" class="btn btn-outline-primary">Submit</button>
                            <a class="btn btn-outline-primary ms-2" href="{{ route('mitra.index') }}">Back</i></a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>