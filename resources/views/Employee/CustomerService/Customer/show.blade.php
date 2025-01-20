<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer Verification') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                @if($message=Session::get('success'))
                    <p>{{$message}}</p>
                @endif
                
                <div class="container mb-4 mt-2">
                    <div class="row row-cols-auto">
                        <div class="col ms-auto">
                            <form action="{{ route('searchCustomer') }}" method="GET">
                                <label class="form-label">Search</label>
                                <input type="text" id="search" name="search" placeholder="Search Customer"
                                    style="border-radius:10px; border: 1px solid black;">
                                <button type="submit" style="border:none; background-color:transparent;"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    @if($customer = DB::select('SELECT * FROM Customer c
                                            join users u on(c.user_id = u.id)'))
                    @foreach($customer as $Customer)
                    <hr>
                    <table class="table table-bordered">
                        <tr>
                            <td class="fw-bold">Name:</td>
                            <td>{{$Customer->name}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Address:</td>
                            <td>{{$Customer->address}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Birth:</td>
                            <td>{{$Customer->birth}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Gender:</td>
                            <td>{{$Customer->gender}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Phone:</td>
                            <td>{{$Customer->phone}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Email:</td>
                            <td>{{$Customer->email}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Status:</td>
                            <td>{{$Customer->verifikasi_CS}}</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="2">
                                <form action="{{route('customer.destroy',$Customer->id)}}" method="post">
                                    @csrf
                                    @method("patch")
                                    <a href="{{route('customer.show',$Customer->user_id)}}" class="btn style=" style="color:#1351d6">
                                        <i class="fa fa-check-circle-o"></i></a>
                                    <a href="{{route('customer.edit',$Customer->id)}}" class="btn style=" style="color:#1351d6">
                                        <i class="fa fa-pencil"></i></a>
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn" type="submit" onclick="return confirm('Are you sure?')" style="color:#ff0000"><i
                                            class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    </table>
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