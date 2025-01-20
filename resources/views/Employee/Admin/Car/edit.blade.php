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

                    <form method="POST" action="{{ route('car.update', $car->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <!-- License Plate -->
                    <div>
                        <x-input-label for="license_plate" :value="__('License Plate')" />
                        <x-text-input id="license_plate" name="license_plate" type="text" class="mt-1 block w-full" :value="old('license_plate', $car->license_plate)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('license_plate')" />
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