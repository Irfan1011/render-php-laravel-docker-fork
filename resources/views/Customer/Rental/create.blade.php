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

                    <form action="{{ route('transaction.store') }}" method="post">
                        @csrf
                        <!-- Customer ID Card -->
                        <div>
                            <x-input-label for="customer_IDCard" :value="__('Customer ID')" />
                            <input id="customer_IDCard" class="block mt-1 w-full" type="text" name="customer_IDCard" placeholder="Customer ID" value="{{old('customer_IDCard')}}" required autofocus/>
                            <x-input-error :messages="$errors->get('customer_IDCard')" class="mt-2" />
                        </div>

                        <!-- Transaction Date -->
                        <div>
                            <x-input-label for="transaction_date" :value="__('Transaction Date')"/>
                            <input class="form-control border-gray-300 rounded-md w-full mt-1" type="date" id="transaction_date" name="transaction_date" value="{{old('transaction_date')}}" required>
                            <x-input-error :messages="$errors->get('transaction_date')" class="mt-2" />
                        </div>

                        <!-- Date and Time Started -->
                        <div>
                            <x-input-label for="date_and_time_transaction_started" :value="__('Date and Time Started')"/>
                            <input class="form-control border-gray-300 rounded-md w-full mt-1" type="datetime-local" id="date_and_time_transaction_started" name="date_and_time_transaction_started" value="{{old('date_and_time_transaction_started')}}" required>
                            <x-input-error :messages="$errors->get('date_and_time_transaction_started')" class="mt-2" />
                        </div>

                        <!-- Date and Time End -->
                        <div>
                            <x-input-label for="date_and_time_transaction_end" :value="__('Date and Time End')"/>
                            <input class="form-control border-gray-300 rounded-md w-full mt-1" type="datetime-local" id="date_and_time_transaction_end" name="date_and_time_transaction_end" value="{{old('date_and_time_transaction_end')}}" required>
                            <x-input-error :messages="$errors->get('date_and_time_transaction_end')" class="mt-2" />
                        </div>

                        <!-- Car Name -->
                        <div>
                            <x-input-label for="mitra_id" :value="__('Other Car')"/>
                            @if($car = DB::select('SELECT id, car_name FROM mitra WHERE adminVerif = "verified"'))
                            <select class="block mt-1 w-full rounded-md border-gray-300" name="mitra_id">
                                <option value="">I Choose AJR Car Option</option>
                                @if($cars = DB::select('SELECT * FROM mitra WHERE status = "Null"'))
                                @foreach($cars as $Car)
                                <option value="{{$Car->id}}" @if(old('mitra_id') == $Car->id) selected @endif>{{$Car->car_name}}</option>
                                @endforeach
                                @endif
                            </select>
                            @endif
                        </div>
                        
                        <!-- Car Name -->
                        <div>
                            <x-input-label for="car_id" :value="__('AJR Car')"/>
                            @if($car = DB::select('SELECT id, name FROM car'))
                            <select class="block mt-1 w-full rounded-md border-gray-300" name="car_id">
                                <option value="">I Choose Other Car Option</option>
                                @if($cars = DB::select('SELECT * FROM car WHERE status = "Null"'))
                                @foreach($cars as $Car)
                                <option value="{{$Car->id}}" @if(old('car_id') == $Car->id) selected @endif>{{$Car->name}}</option>
                                @endforeach
                                @endif
                            </select>
                            @endif
                        </div>

                        <!-- Driver Option -->
                        <div>
                            <x-input-label for="isDriver" :value="__('Driver Option')"/>
                            <select class="block mt-1 w-full rounded-md border-gray-300" name="isDriver" required>
                                <option value="No">Without Driver</option>
                                <option value="Yes">With Driver</option>
                            </select>
                            <x-input-error :messages="$errors->get('isDriver')" class="mt-2" />
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <x-input-label for="payment_method" :value="__('Payment Method')"/>
                            <select class="block mt-1 w-full rounded-md border-gray-300" name="payment_method" required>
                                <option value="Cash">Cash</option>
                                <option value="Transfer">Transfer</option>
                            </select>
                            <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                        </div>

                        <!-- Promo -->
                        <div>
                            <x-input-label for="promo_code" :value="__('Promo')"/>
                            @if($promo = DB::select('SELECT * FROM promo'))
                            <select class="block mt-1 w-full rounded-md border-gray-300" name="promo_code">
                                <option value="">Tidak Menggunakan Promo</option>
                                @foreach($promo as $Promo)
                                <option value="{{$Promo->promo_code}}">{{$Promo->promo_code}}</option>
                                @endforeach
                            </select>
                            @else
                            <select class="block mt-1 w-full rounded-md border-gray-300" name="promo_code">
                                <option value="">Tidak Menggunakan Promo</option>
                            </select>
                            @endif
                        </div>

                        <div class="gap-2 mt-4 text-center">
                            <button type="submit" class="btn btn-outline-primary">Submit</button>
                            <a class="btn btn-outline-primary ms-2" href="{{ route('transaction.index') }}">Back</i></a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>