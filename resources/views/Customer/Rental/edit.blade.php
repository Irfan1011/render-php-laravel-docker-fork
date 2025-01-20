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

                    @if(Auth::user()->hasRole('customer'))
                    <form action="{{ route('transaction.update', $transaction->id) }}" method="post">
                        @csrf
                        @method('patch')
                        <!-- Customer ID -->
                        <div>
                            <x-input-label for="customer_IDCard" :value="__('Customer ID')" />
                            <input id="customer_IDCard" class="block mt-1 w-full" type="text" name="customer_IDCard" placeholder="Customer ID" value="{{old('customer_IDCard', $transaction->customer_IDCard)}}" required autofocus/>
                            <x-input-error :messages="$errors->get('customer_IDCard')" class="mt-2" />
                        </div>

                        <!-- Customer License -->
                        @if($isDriver = DB::select('SELECT isDriver FROM transaction WHERE isDriver = "No"'))
                        <div>
                            <x-input-label for="customer_license" :value="__('Customer License')" />
                            <input id="customer_license" class="block mt-1 w-full" type="text" name="customer_license" placeholder="Customer License" value="{{old('customer_license', $transaction->customer_license)}}" required/>
                            <x-input-error :messages="$errors->get('customer_license')" class="mt-2" />
                        </div>
                        @endif

                        <!-- Transaction Date -->
                        <div>
                            <x-input-label for="transaction_date" :value="__('Transaction Date')"/>
                            <input class="form-control border-gray-300 rounded-md w-full mt-1" type="date" id="transaction_date" name="transaction_date" value="{{old('transaction_date', $transaction->transaction_date)}}" disabled>
                            <x-input-error :messages="$errors->get('transaction_date')" class="mt-2" />
                            <input type="hidden" name="transaction_date" value="{{old('transaction_date', $transaction->transaction_date)}}">
                        </div>

                        <!-- Date and Time Started -->
                        <div>
                            <x-input-label for="date_and_time_transaction_started" :value="__('Date and Time Started')"/>
                            <input class="form-control border-gray-300 rounded-md w-full mt-1" type="datetime-local" id="date_and_time_transaction_started" name="date_and_time_transaction_started" value="{{old('date_and_time_transaction_started', $transaction->date_and_time_transaction_started)}}" required>
                            <x-input-error :messages="$errors->get('date_and_time_transaction_started')" class="mt-2" />
                        </div>
                        
                        <!-- Date and Time End -->
                        <div>
                            <x-input-label for="date_and_time_transaction_end" :value="__('Date and Time End')"/>
                            <input class="form-control border-gray-300 rounded-md w-full mt-1" type="datetime-local" id="date_and_time_transaction_end" name="date_and_time_transaction_end" value="{{old('date_and_time_transaction_end', $transaction->date_and_time_transaction_end)}}" required>
                            <x-input-error :messages="$errors->get('date_and_time_transaction_end')" class="mt-2" />
                            <input type="hidden" name="date_and_time_transaction_end" value="{{old('date_and_time_transaction_end', $transaction->date_and_time_transaction_end)}}">
                        </div>

                        <!-- Car Name -->
                        <div>
                            <x-input-label for="mitra_id" :value="__('Other Car')"/>
                            @if($car = DB::select('SELECT id, car_name FROM mitra WHERE adminVerif = "verified"'))
                            <select class="block mt-1 w-full rounded-md border-gray-300" name="mitra_id">
                                <option value="">I Choose AJR Car Option</option>
                                @foreach($car as $Car)
                                <option value="{{$Car->id}}" @if(old('mitra_id', $transaction->mitra_id) == $Car->id) selected @endif>{{$Car->car_name}}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>

                        <!-- Car Name -->
                        <div>
                            <x-input-label for="car_id" :value="__('AJR Car')"/>
                            @if($car = DB::select('SELECT id, name FROM car'))
                            <select class="block mt-1 w-full rounded-md border-gray-300" name="car_id">
                                <option value="">I Choose Other Car Option</option>
                                @foreach($car as $Car)
                                <option value="{{$Car->id}}" @if(old('car_id', $transaction->car_id) == $Car->id) selected @endif)>{{$Car->name}}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <x-input-label for="payment_method" :value="__('Payment Method')"/>
                            <select class="block mt-1 w-full rounded-md border-gray-300" name="payment_method" required>
                                <option value="Cash" <?= $transaction->payment_method == "Cash" ? "selected" : ""?>>Cash</option>
                                <option value="Transfer" <?= $transaction->payment_method == "Transfer" ? "selected" : ""?>>Transfer</option>
                            </select>
                            <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                        </div>

                        <!-- Promo -->
                        <div>
                            <x-input-label for="promo_code" :value="__('Promo')"/>
                            @if($promo = DB::select('SELECT * FROM promo'))
                            <select class="block mt-1 w-full rounded-md border-gray-300" name="promo_code" required>
                                @foreach($promo as $Promo)
                                <option value="{{$Promo->promo_code}}" @if(old('promo_code', $transaction->promo_code) == $Promo->promo_code) selected @endif>{{$Promo->promo_code}}</option>
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

                    @elseif(Auth::user()->hasRole('customerServices'))
                    <form action="{{ route('transactionCS.update', $transaction->id) }}" method="post">
                        @csrf
                        @method('patch')
                        <!-- Customer ID -->
                        <div>
                            <x-input-label for="customer_IDCard" :value="__('Customer ID')" />
                            <input id="customer_IDCard" class="block mt-1 w-full" type="text" name="customer_IDCard" placeholder="Customer ID" value="{{old('customer_IDCard', $transaction->customer_IDCard)}}" required autofocus/>
                            <x-input-error :messages="$errors->get('customer_IDCard')" class="mt-2" />
                        </div>

                        <!-- Customer License -->
                        @if($isDriver = DB::select('SELECT isDriver FROM transaction WHERE isDriver = "No"'))
                        <div>
                            <x-input-label for="customer_license" :value="__('Customer License')" />
                            <input id="customer_license" class="block mt-1 w-full" type="text" name="customer_license" placeholder="Customer License" value="{{old('customer_license', $transaction->customer_license)}}" required/>
                            <x-input-error :messages="$errors->get('customer_license')" class="mt-2" />
                        </div>
                        @endif

                        <!-- Transaction Date -->
                        <div>
                            <x-input-label for="transaction_date" :value="__('Transaction Date')"/>
                            <input class="form-control border-gray-300 rounded-md w-full mt-1" type="date" id="transaction_date" name="transaction_date" value="{{old('transaction_date', $transaction->transaction_date)}}" disabled>
                            <x-input-error :messages="$errors->get('transaction_date')" class="mt-2" />
                            <input type="hidden" name="transaction_date" value="{{old('transaction_date', $transaction->transaction_date)}}">
                        </div>

                        <!-- Date and Time Started -->
                        <div>
                            <x-input-label for="date_and_time_transaction_started" :value="__('Date and Time Started')"/>
                            <input class="form-control border-gray-300 rounded-md w-full mt-1" type="datetime-local" id="date_and_time_transaction_started" name="date_and_time_transaction_started" value="{{old('date_and_time_transaction_started', $transaction->date_and_time_transaction_started)}}" required>
                            <x-input-error :messages="$errors->get('date_and_time_transaction_started')" class="mt-2" />
                        </div>
                        
                        <!-- Date and Time End -->
                        <div>
                            <x-input-label for="date_and_time_transaction_end" :value="__('Date and Time End')"/>
                            <input class="form-control border-gray-300 rounded-md w-full mt-1" type="datetime-local" id="date_and_time_transaction_end" name="date_and_time_transaction_end" value="{{old('date_and_time_transaction_end', $transaction->date_and_time_transaction_end)}}" required>
                            <x-input-error :messages="$errors->get('date_and_time_transaction_end')" class="mt-2" />
                            <input type="hidden" name="date_and_time_transaction_end" value="{{old('date_and_time_transaction_end', $transaction->date_and_time_transaction_end)}}">
                        </div>

                        <!-- Car Name -->
                        <div>
                            <x-input-label for="mitra_id" :value="__('Other Car')"/>
                            @if($car = DB::select('SELECT id, car_name FROM mitra WHERE adminVerif = "verified"'))
                            <select class="block mt-1 w-full rounded-md border-gray-300" name="mitra_id">
                                <option value="">I Choose AJR Car Option</option>
                                @foreach($car as $Car)
                                <option value="{{$Car->id}}" @if(old('mitra_id', $transaction->mitra_id) == $Car->id) selected @endif>{{$Car->car_name}}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>

                        <!-- Car Name -->
                        <div>
                            <x-input-label for="car_id" :value="__('AJR Car')"/>
                            @if($car = DB::select('SELECT id, name FROM car'))
                            <select class="block mt-1 w-full rounded-md border-gray-300" name="car_id">
                                <option value="">I Choose Other Car Option</option>
                                @foreach($car as $Car)
                                <option value="{{$Car->id}}" @if(old('car_id', $transaction->car_id) == $Car->id) selected @endif)>{{$Car->name}}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <x-input-label for="payment_method" :value="__('Payment Method')"/>
                            <select class="block mt-1 w-full rounded-md border-gray-300" name="payment_method" required>
                                <option value="Cash" <?= $transaction->payment_method == "Cash" ? "selected" : ""?>>Cash</option>
                                <option value="Transfer" <?= $transaction->payment_method == "Transfer" ? "selected" : ""?>>Transfer</option>
                            </select>
                            <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                        </div>

                        <!-- Promo -->
                        <div>
                            <x-input-label for="promo_code" :value="__('Promo')"/>
                            @if($promo = DB::select('SELECT * FROM promo'))
                            <select class="block mt-1 w-full rounded-md border-gray-300" name="promo_code" required>
                                @foreach($promo as $Promo)
                                <option value="{{$Promo->promo_code}}" @if(old('promo_code', $transaction->promo_code) == $Promo->promo_code) selected @endif>{{$Promo->promo_code}}</option>
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
                            <a class="btn btn-outline-primary ms-2" href="{{ route('transactionCS.index') }}">Back</i></a>
                        </div>
                    </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>