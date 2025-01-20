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

                    <form action="{{ route('storeFindDriver.store',$transaction->id) }}" method="post">
                        @csrf
                        <!-- Driver Name -->
                        <div>
                            <x-input-label for="driver_id" :value="__('Driver Name')"/>
                            @if($driver = DB::select('SELECT d.user_id, u.name FROM users u join driver d on(u.id = d.user_id) WHERE verifikasi_admin = "Verified" AND rental_verif = "Null"'))
                            <select class="block mt-1 w-full rounded-md border-gray-300" name="driver_id">
                                @foreach($driver as $Driver)
                                <option value="{{$Driver->user_id}}">{{$Driver->name}}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>

                        <!-- Driver Price -->
                        <div>
                            <x-input-label for="daily_price" :value="__('Driver Price')" />
                            <input id="daily_price" class="block mt-1 w-full" type="number" name="daily_price" placeholder="Rp.00." value="{{old('daily_price')}}" required/>
                            <x-input-error :messages="$errors->get('daily_price')" class="mt-2" />
                        </div>

                        <div class="gap-2 mt-4 text-center">
                            <button type="submit" class="btn btn-outline-primary">Submit</button>
                            <a class="btn btn-outline-primary ms-2" href="{{ route('transactionCS.index') }}">Back</i></a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>