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

                @if($message=Session::get('success'))
                    <p>{{$message}}</p>
                @endif
                
                <div class="container justify-content-md-center mb-4">
                    <div class="row">
                        <div class="col col-8 mt-2">
                            <form>
                                <a href="{{route('car.index')}}" class="btn btn-primary btn-sm mt-2 mb-4 text-white fw-bold" style="color:#ebff0d"><i class="fa fa-arrow-left"> Back</i></a>
                            </form>
                        </div>
                        <div class="col p-0">
                            <form action="{{ route('searchMitraAdmin') }}" method="GET">
                                <div class="row text-center">
                                    <div class="col ms-auto mt-2">
                                        <label class="form-label">Search</label>
                                    </div>
                                    <div class="col p-0">
                                        <input type="text" id="search" name="search" placeholder="Search Mitra"
                                            style="border-radius:10px; border: 1px solid black;">
                                    </div>
                                    <div class="col mt-2 p-0 mb-4">
                                        <button type="submit" style="border:none; background-color:transparent;"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    @if($mitra = DB::select('SELECT * FROM Mitra m
                                            join users u on(m.user_id = u.id)
                                            join customer c on(c.user_id = u.id)'))
                    @foreach($combinedData as $Mitra)
                    <table class="table table-bordered">
                        <tr>
                            <td class="fw-bold">Car Name:</td>
                            <td>{{$Mitra->car_name}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Car Type:</td>
                            <td>{{$Mitra->car_type}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Transmission Type:</td>
                            <td>{{$Mitra->transmission_type}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Fuel Type:</td>
                            <td>{{$Mitra->fuel_type}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Fuel Volume:</td>
                            <td>{{$Mitra->fuel_volume}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Color:</td>
                            <td>{{$Mitra->color}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Passenger Capasity:</td>
                            <td>{{$Mitra->passenger_capasity}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Facility:</td>
                            <td>{{$Mitra->facility}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Lisence Plate:</td>
                            <td>{{$Mitra->license_plate}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Vehicle Registration Number:</td>
                            <td>{{$Mitra->vehicle_registration_number}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Owner Name:</td>
                            <td>{{$Mitra->name}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Strated Contract:</td>
                            <td>{{$Mitra->started_contract}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Ending Contract:</td>
                            <td>{{$Mitra->ending_contract}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Latest Day Service:</td>
                            <td>{{$Mitra->latest_day_service}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Daily Price:</td>
                            <td>{{$Mitra->daily_price}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Status:</td>
                            <td>{{$Mitra->status}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Car Verification:</td>
                            <td>{{$Mitra->adminVerif}}</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">
                                <form action="{{route('mitraAdmin.destroy',$Mitra->id)}}" method="post">
                                    @csrf
                                    @method("patch")
                                    <a href="{{route('mitraAdmin.show',$Mitra->id)}}" class="btn" style="color:#1351d6">
                                        <i class="fa fa-check-circle-o"></i></a>
                                    <a href="{{route('mitraAdmin.edit',$Mitra->id)}}" class="btn" style="color:#1351d6">
                                        <i class="fa fa-pencil"></i></a>
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn" type="submit" onclick="return confirm('Are you sure?')" style="color:#ff0000"><i
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