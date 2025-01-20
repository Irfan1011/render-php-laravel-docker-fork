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
                        @php
                            $transaction = DB::table('transaction')
                                        ->where('driver_id', Auth::user()->id)
                                        ->where('status', 'Null')
                                        ->first();

                            $driverAccept = DB::table('transaction')
                                        ->join('driver','driver.user_id','=','transaction.driver_id')
                                        ->where('driver_id', Auth::user()->id)
                                        ->where('rental_verif','=','Accept')
                                        ->where('transaction.CS_Verif','=','Verified')
                                        ->first();
                        @endphp

                        @if($transaction)
                        @foreach($combinedData as $Transaction)
                        <table class="table table-bordered">
                            <tr>
                                <td class="fw-bold">Customer Name:</td>
                                <td>{{$Transaction->user_name}}</td>
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
                                <td class="fw-bold">Car Name:</td>
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
                                <td class="fw-bold">Driver Status:</td>
                                <td>{{$Transaction->rental_verif}}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Transaction Status:</td>
                                <td>{{$Transaction->CS_Verif}}</td>
                            </tr>
                            <tr>
                                <td class="text-center" colspan="2">
                                    <div class="text-center">
                                        @if($driverAccept)
                                        <form action="{{ route('accept', $Transaction->id_transaction) }}" method="post" class="d-inline">
                                            @csrf
                                            @method("put")
                                            <x-secondary-button disabled>
                                                {{ __('Accept') }}
                                            </x-secondary-button>
                                        </form>

                                        <form action="{{ route('decline', $Transaction->id_transaction) }}" method="post" class="d-inline">
                                            @csrf
                                            @method("put")
                                            <x-secondary-button class="ml-4" disabled>
                                                {{ __('Decline') }}
                                            </x-secondary-button>
                                        </form>

                                        <tr>
                                            <td class="text-center" colspan="2">
                                                <form action="{{route('finishDriver',$Transaction->id_transaction)}}" method="post">
                                                    @csrf
                                                    @method("DELETE")
                                                    <button class="btn btn-outline-warning fw-bold" type="submit" onclick="return confirm('Finish The Order?')" style="color:#ff0000">Finish</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @else
                                        <form action="{{ route('accept', $Transaction->id_transaction) }}" method="post" class="d-inline">
                                            @csrf
                                            @method("put")
                                            <x-primary-button>
                                                {{ __('Accept') }}
                                            </x-primary-button>
                                        </form>

                                        <form action="{{ route('decline', $Transaction->id_transaction) }}" method="post" class="d-inline">
                                            @csrf
                                            @method("put")
                                            <x-danger-button class="ml-4">
                                                {{ __('Decline') }}
                                            </x-danger-button>
                                        </form>
                                        @endif
                                    </div>
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
