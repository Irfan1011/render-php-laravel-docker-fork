<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shift') }}
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
                                <a href="{{route('shift.create')}}" class="btn btn-primary btn-sm mt-2 mb-4 text-white" style="color:#ebff0d"><i class="fa fa-plus fw-bold"> Add</i></a>
                            </form>
                        </div>
                        <div class="col p-0">
                            <form action="{{ route('searchShift') }}" method="GET">
                                <div class="row text-center">
                                    <div class="col ms-auto mt-2">
                                        <label class="form-label">Search</label>
                                    </div>
                                    <div class="col p-0">
                                        <input type="text" id="search" name="search" placeholder="Search Promo Code"
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

                <div class="container">
                    <div class="row">
                        @if($employee= DB::select('SELECT * FROM Shift'))
                        @foreach($combinedData as $Employee)
                        <div class="col-sm-6 text-center d-flex align-items-center justify-content-center"><img src="{{ asset('uploads/Employee_Photo/'.$Employee->photo) }}" height="300" width="300"/></div>
                        <div class="col-sm-6 text-center d-flex flex-column align-items-center mt-4">
                            <div class="row">
                                <div class="col">
                                    <div class="row">Name</div>
                                    <div class="row">Role</div>
                                    <div class="row">Shift</div>
                                    <div class="row">Day</div>
                                </div>
                                <div class="col">
                                    <div class="row">: {{$Employee->name}}</div>
                                    <div class="row">: {{$Employee->display_name}}</div>
                                    <div class="row">: {{$Employee->shift_time}}</div>
                                    <div class="row">: {{$Employee->day}}</div>
                                </div>
                                <div class="row">
                                    <form action="{{route('shift.destroy',$Employee->id)}}" method="post">
                                        <a href="{{route('shift.edit',$Employee->id)}}" class="btn ps-0" style="color:#1351d6">
                                            <i class="fa fa-pencil"></i></a>
                                        @csrf
                                        @method("DELETE")
                                        <button class="btn" type="submit" onclick="return confirm('Are you sure?')" style="color:#ff0000"><i
                                                class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                            <div align="center">Empty Data!! Have a nice day :)</div>
                        @endif
                    </div>
                </div>
                {{$combinedData->links()}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>