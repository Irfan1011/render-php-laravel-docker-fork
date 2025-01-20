<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Note') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="table-responsive">
                        @php
                            $transaction = DB::table('transaction')
                                        ->join('users','users.id','=','transaction.user_id')
                                        ->join('customer','transaction.customer_id','=','customer.user_id')
                                        ->leftjoin('driver','transaction.driver_id','=','driver.user_id')
                                        ->leftjoin('employee','transaction.employee_id','=','employee.user_id')
                                        ->leftjoin('car','transaction.car_id','=','car.id')
                                        ->leftjoin('mitra','transaction.mitra_id','=','mitra.id')
                                        ->leftjoin('promo','transaction.promo_code','=','promo.promo_code')
                                        ->select(
                                            'transaction.id',
                                            'transaction.employee_id',
                                            'transaction.driver_id',
                                            'transaction.car_id',
                                            'transaction.mitra_id',
                                            'transaction.transaction_date',
                                            'transaction.date_and_time_transaction_started',
                                            'transaction.date_and_time_transaction_end',
                                            'transaction.date_return',
                                            'transaction.car_rental_costs',
                                            'transaction.driver_costs',
                                            'transaction.payment_total',
                                            'users.name as user_name',
                                            'promo.promo_code',
                                            'promo.discount',
                                            'car.name as car_name',
                                            'car.daily_price as car_daily_price',
                                            'mitra.car_name as mitra_name',
                                            'mitra.daily_price as mitra_daily_price',
                                            'driver.daily_price as driver_daily_price',
                                        )
                                        ->where('transaction.status','=','Finish')
                                        ->where('transaction.user_id', Auth::user()->id)
                                        ->paginate(3);
                                        
                            $driver_names = DB::table('driver')
                                        ->join('users', 'driver.user_id', '=', 'users.id')
                                        ->join('transaction', 'driver.user_id', '=', 'transaction.driver_id')
                                        ->pluck('users.name', 'transaction.driver_id')
                                        ->toArray();

                            $employee_name = DB::table('employee')
                                        ->join('users', 'employee.user_id', '=', 'users.id')
                                        ->join('transaction', 'employee.user_id', '=', 'transaction.employee_id')
                                        ->pluck('users.name', 'transaction.employee_id')
                                        ->toArray();

                            $noDriver = DB::table('transaction')
                                        ->where('isDriver','=','No')
                                        ->first();
                        @endphp

                        @if($transaction)
                        @foreach($transaction as $Transaction)
                        <div class="container border border-dark">
                            <div class="row">
                                <div class="cols" colspan="2">
                                    <p class="fw-bold text-center">Atma Rental</p>
                                </div>
                            </div>
                            <div class="row row-cols-auto">
                                <div class="cols">
                                    @php
                                    $dateParts = explode('-', $Transaction->transaction_date);
                                    $year = substr($dateParts[0], -2);
                                    $month = substr($dateParts[1], -2);
                                    $day = substr($dateParts[2], -2);

                                    $transactionId = str_pad($Transaction->id, 3, '0', STR_PAD_LEFT);

                                    $transactionDate = new DateTime($Transaction->date_and_time_transaction_started);
                                    $hour = $transactionDate->format('H');
                                    $minutes = $transactionDate->format('i');
                                    
                                    $formattedTransactionNumber = "TRN{$year}{$month}{$day}-{$transactionId}";
                                    $formattedTransactionDate = "{$year}-{$month}-{$day}, {$hour}:{$minutes}";
                                    @endphp
                                    <p>{{ $formattedTransactionNumber }}</p>
                                </div>
                                <div class="cols ms-auto">
                                    <p>{{ $formattedTransactionDate }}</p>
                                </div>
                            </div>
                            <div class="row row-cols-4 border-top border-dark">
                                <div class="cols">
                                    <p>Cust</p>
                                    <p>CS</p>
                                    <p>DRV</p>
                                </div>
                                <div class="cols">
                                    <p>{{$Transaction->user_name}}</p>
                                    <p>{{$employee_name[$Transaction->employee_id]}}</p>

                                    @if(!$noDriver)
                                    <p>{{$driver_names[$Transaction->driver_id]}}</p>
                                    @else
                                    <p>-</p>
                                    @endif

                                </div>
                                <div class="cols">
                                    <p>PRO:</p>
                                </div>
                                <div class="cols">
                                    <p>{{$Transaction->promo_code}}</p>
                                </div>
                            </div>
                            <div class="row text-center border-top border-dark">
                                <p class="fw-bold">Transaction Note</p>
                            </div>
                            <div class="row row-cols-4 border-top border-dark">
                                <div class="cols">
                                    Rental Started
                                </div>
                                <div class="cols">
                                    <p>{{$Transaction->date_and_time_transaction_started}}</p>
                                </div>
                            </div>
                            <div class="row row-cols-4 border-top border-dark">
                                <div class="cols">
                                    Rental End
                                </div>
                                <div class="cols">
                                    <p>{{$Transaction->date_and_time_transaction_end}}</p>
                                </div>
                            </div>
                            <div class="row row-cols-4 border-top border-dark">
                                <div class="cols">
                                    Rental Return
                                </div>
                                <div class="cols">
                                    <p>{{$Transaction->date_return}}</p>
                                </div>
                            </div>
                            <div class="row row-cols-4 border-top border-dark text-center">
                                <div class="cols">
                                    <p class="fw-bold">Item</p>
                                </div>
                                <div class="cols">
                                    <p class="fw-bold">Unit</p>
                                </div>
                                <div class="cols">
                                    <p class="fw-bold">Duration</p>
                                </div>
                                <div class="cols">
                                    <p class="fw-bold">Sub Total</p>
                                </div>
                            </div>
                            <div class="row row-cols-4 border-top border-dark text-center">
                                @php
                                    $startDate = new DateTime($Transaction->date_and_time_transaction_started);
                                    $endDate = new DateTime($Transaction->date_and_time_transaction_end);
                                    $interval = $startDate->diff($endDate);
                                    $numberOfDays = $interval->days + 1;
                                @endphp
                                @if($Transaction->mitra_id == "")
                                <div class="cols" style="word-warp: break-word;">{{$Transaction->car_name}}</div>
                                <div class="cols">{{$Transaction->car_daily_price}}</div>
                                <div class="cols">{{$numberOfDays}} Day</div>
                                <div class="cols">{{$Transaction->car_rental_costs}}</div>
                                @elseif($Transaction->car_id == "")
                                <div class="cols" style="word-wrap: break-word;">{{$Transaction->mitra_name}}</div>
                                <div class="cols">{{$Transaction->mitra_daily_price}}</div>
                                <div class="cols">{{$numberOfDays}} Day</div>
                                <div class="cols">{{$Transaction->car_rental_costs}}</div>
                                @endif
                            </div>
                            <div class="row row-cols-4 border-top border-dark text-center">
                                @if(!$noDriver)
                                <div class="cols">Driver {{$driver_names[$Transaction->driver_id]}}</div>
                                @else
                                <div class="cols">Driver -</div>
                                @endif
                                <div class="cols">{{$Transaction->driver_daily_price}}</div>
                                <div class="cols">{{$numberOfDays}} Day</div>
                                <div class="cols">{{$Transaction->driver_costs}}</div>
                            </div>
                            <div class="row row-cols-4 border-top border-dark text-center">
                                <div class="cols"></div>
                                <div class="cols"></div>
                                <div class="cols"></div>
                                @php
                                    $Costs = $Transaction->driver_costs + $Transaction->car_rental_costs;
                                @endphp
                                <div class="cols fw-bold">{{$Costs}}</div>
                            </div>
                            <div class="row row-cols-4 border-top border-dark text-center">
                                <div class="cols">Cust</div>
                                <div class="cols">CS</div>
                                <div class="cols">Disc</div>
                                <div class="cols">{{$Transaction->discount}}%</div>
                            </div>
                            <!-- <div class="row row-cols-4 text-center">
                                <div class="cols"></div>
                                <div class="cols"></div>
                                <div class="cols border-top border-dark">Fine</div>
                                <div class="cols border-top border-dark">{{$Transaction->promo_code}}</div>
                            </div> -->
                            <div class="row row-cols-4 text-center">
                                <div class="cols"></div>
                                <div class="cols"></div>
                                @php
                                    $Total = $Transaction->payment_total - ($Transaction->payment_total * ($Transaction->discount/100));
                                @endphp
                                <div class="cols border-top border-dark">Total</div>
                                <div class="cols border-top border-dark fw-bold">{{$Total}}</div>
                            </div>
                            <div class="row row-cols-4 text-center">
                                <div class="cols">{{$Transaction->user_name}}</div>
                                <div class="cols">{{$employee_name[$Transaction->employee_id]}}</div>
                                <div class="cols">-</div>
                            </div>
                        </div>
                        <br><br><br>
                        @endforeach
                        @else
                        <p align="center">Empty Data!! Have a nice day :)</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
