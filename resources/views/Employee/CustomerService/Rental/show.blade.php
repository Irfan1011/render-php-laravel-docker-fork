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

                    @if($message=Session::get('success'))
                    <p>{{$message}}</p>
                    @endif

                    <div class="container mb-4">
                        <div class="row row-cols-auto">
                            <div class="col-md-4 p-0 mt-2 ms-auto">
                                <form action="{{ route('searchTransaction') }}" method="GET" class="form-inline">
                                    <div class="row text-center">
                                        <div class="col-auto mt-2">
                                            <label class="form-label">Search</label>
                                        </div>
                                        <div class="col">
                                            <input type="text" id="search" name="search" placeholder="Search Rental"
                                                class="form-control" style="border-radius:10px; border: 1px solid black;">
                                        </div>
                                        <div class="col-auto mt-2">
                                            <button type="submit" class="btn">
                                            <i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        @if($transaction = DB::select('SELECT * FROM transaction'))
                        @foreach($combinedData as $Transaction)
                        <table class="table table-bordered">
                            <tr>
                                <td class="fw-bold">Customer Name:</td>
                                <td>{{$Transaction->user_name}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Customer ID:</td>
                                <td>{{$Transaction->customer_IDCard}}</td>
                            </tr>
                            @if($isDriver = DB::select('SELECT isDriver FROM transaction WHERE isDriver = "No"'))
                            <tr>
                                <td class="fw-bold">Customer License:</td>
                                <td>{{$Transaction->customer_license}}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="fw-bold">Transaction Date:</td>
                                <td>{{$Transaction->transaction_date}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Date And Time Rental Started:</td>
                                <td>{{$Transaction->date_and_time_transaction_started}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Date And Time Rental End:</td>
                                <td>{{$Transaction->date_and_time_transaction_end}}</td>
                            </tr>
                            @if($Transaction->car_id == "")
                            <tr>
                                <td class="fw-bold">Car Name:</td>
                                <td>{{$Transaction->car_name}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">License Plate:</td>
                                <td>{{$Transaction->mitra_license_plate}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Daily Price:</td>
                                <td>{{$Transaction->mitra_daily_price}}</td>
                            </tr>
                            @elseif($Transaction->mitra_id == "")
                            <tr>
                                <td class="fw-bold">Name:</td>
                                <td>{{$Transaction->name}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">License Plate:</td>
                                <td>{{$Transaction->car_license_plate}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Daily Price:</td>
                                <td>{{$Transaction->car_daily_price}}</td>
                            </tr>
                            @endif
                            @if($isDriver = DB::select('SELECT isDriver FROM transaction WHERE isDriver = "Yes"'))
                            <tr>
                                <td class="fw-bold">Driver Name:</td>
                                <td>
                                    @if($Transaction->driver_id == "")
                                    No Driver
                                    @else
                                    {{$driver_names[$Transaction->driver_id]}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Driver Phone:</td>
                                <td>{{$Transaction->driver_phone}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Driver Rental Price:</td>
                                <td>{{$Transaction->driver_price}}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="fw-bold">Payment Method:</td>
                                <td>{{$Transaction->payment_method}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Car Rental Costs:</td>
                                <td>{{$Transaction->car_rental_costs}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Driver Costs:</td>
                                <td>{{$Transaction->driver_costs}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Loan Extension:</td>
                                <td>{{$Transaction->loan_extension}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Payment Total:</td>
                                <td>{{$Transaction->payment_total}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Driver Status:</td>
                                <td>{{$Transaction->rental_verif}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Transaction Status:</td>
                                <td>{{$Transaction->CS_Verif}}</td>
                            </tr>
                            <tr>
                                <td class="text-center" colspan="2">
                                    @php
                                        $driverAccept = DB::table('transaction')
                                                    ->join('driver','driver.user_id','=','transaction.driver_id')
                                                    ->where('rental_verif','=','Accept')
                                                    ->first();

                                        $noDriver = DB::table('transaction')
                                                    ->where('isDriver','=','No')
                                                    ->first();
                                    @endphp
                                    @if($driverAccept || $noDriver)
                                    <form action="{{route('storeFindDriver.create',$Transaction->id_transaction)}}" method="post">
                                        @csrf
                                        @method("put")
                                        <x-secondary-button class="ml-4" disabled>
                                            {{ __('Find Driver') }}
                                        </x-secondary-button>
                                    </form>
                                    @else
                                    <form action="{{route('storeFindDriver.create',$Transaction->id_transaction)}}" method="post">
                                        @csrf
                                        @method("put")
                                        <x-primary-button class="ml-4">
                                            {{ __('Find Driver') }}
                                        </x-primary-button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center" colspan="2">
                                    <form action="{{route('transactionCS.destroy',$Transaction->id_transaction)}}" method="post">
                                        @if($driverStatus = DB::select('SELECT d.id, d.rental_verif FROM Driver d
                                                                        join transaction t on(t.driver_id = d.user_id)
                                                                        WHERE t.driver_id = d.user_id && rental_verif = "Accept"')  || $noDriver)
                                        @csrf
                                        @method("patch")
                                        <a href="{{route('transactionCS.show',$Transaction->id_transaction)}}" class="btn" style="color:#1351d6">
                                            <i class="fa fa-check-circle-o"></i></a>
                                        @endif
                                        <a href="{{route('transactionCS.edit',$Transaction->id_transaction)}}" class="btn"
                                            style="color:#1351d6"><i class="fa fa-pencil"></i></a>
                                        @csrf
                                        @method("DELETE")
                                        <button class="btn" type="submit"
                                            onclick="return confirm('Are you sure?')" style="color:#ff0000"><i
                                                class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        </table>
                        <hr>
                        @endforeach
                        @else
                        <p align="center">Empty Data!! Have a nice day :)</p>
                        @endif
                    </div>
                    {{$combinedData->links()}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
