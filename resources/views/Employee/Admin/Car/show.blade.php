<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Car') }}
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
                                <a href="{{route('carMitra')}}" class="btn btn-primary btn-sm mt-2 mb-4 text-white fw-bold" style="color:#ebff0d">Mitra</a>
                            </form>
                        </div>
                        <div class="col p-0">
                            <form action="{{ route('searchCar') }}" method="GET">
                                <div class="row text-center">
                                    <div class="col ms-auto mt-2">
                                        <label class="form-label">Search</label>
                                    </div>
                                    <div class="col p-0">
                                        <input type="text" id="search" name="search" placeholder="Search Car"
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

                <div class="container text-center">
                    @if($car = DB::select('SELECT * FROM Car'))
                    @foreach($combinedData as $Car)
                    <div class="row border border-dark">
                        <div class="col-md-3 col-sm-12 d-flex justify-content-center align-items-center">
                            <img src="{{ asset('uploads/Car_Photo/'.$Car->photo) }}" height="250" width="250"/>
                        </div>
                        <div class="col">
                            <div class="row row-cols-2">
                                <div class="col-md-6 col-sm-6">
                                    <div class="row border-bottom border-dark ps-2">Name</div>
                                    <div class="row border-bottom border-dark ps-2">Type</div>
                                    <div class="row border-bottom border-dark ps-2">Transmission Type</div>
                                    <div class="row border-bottom border-dark ps-2">Fuel Type</div>
                                    <div class="row border-bottom border-dark ps-2">Color</div>
                                    <div class="row border-bottom border-dark ps-2">Trunk Volume</div>
                                    <div class="row border-bottom border-dark ps-2">Facility</div>
                                    <div class="row border-dark ps-2">Lisence Plate</div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="row border-bottom border-dark ps-2">{{$Car->name}}</div>
                                    <div class="row border-bottom border-dark ps-2">{{$Car->type}}</div>
                                    <div class="row border-bottom border-dark ps-2">{{$Car->transmission_type}}</div>
                                    <div class="row border-bottom border-dark ps-2">{{$Car->fuel_type}}</div>
                                    <div class="row border-bottom border-dark ps-2">{{$Car->color}}</div>
                                    <div class="row border-bottom border-dark ps-2">-</div>
                                    <div class="row border-bottom border-dark ps-2">{{$Car->facility}}</div>
                                    <div class="row border-dark ps-2">{{$Car->license_plate}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-2 border-bottom border-start border-end border-dark">
                        <div class="col-md-3 border-end border-dark fw-bold" colspan="2">
                            Daily Price: Rp.{{$Car->daily_price}}
                        </div>
                        <div class="col">
                            <form method="post">
                                <a href="{{route('car.edit',$Car->id)}}" class="btn" style="color:#1351d6">
                                    <i class="fa fa-pencil"></i></a>
                            </form>
                        </div>
                    </div>
                    <br>
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