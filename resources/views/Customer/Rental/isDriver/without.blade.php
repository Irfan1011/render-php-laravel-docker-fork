<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rental') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('isDriver.update',$transaction->id) }}" method="post">
                        @csrf
                        @method('patch')
                        <!-- Customer License -->
                        <div>
                            <x-input-label for="customer_license" :value="__('Customer License')" />
                            <input id="customer_license" class="block mt-1 w-full" type="text" name="customer_license" placeholder="Customer License" value="{{old('customer_license')}}" required/>
                            <x-input-error :messages="$errors->get('customer_license')" class="mt-2" />
                        </div>

                        <div class="gap-2 mt-4 text-center">
                            <button type="submit" class="btn btn-outline-primary">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>