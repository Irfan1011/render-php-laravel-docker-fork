<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Promo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                @if($message=Session::get('success'))
                    <p>{{$message}}</p>
                @endif

                <div class="container justify-content-md-center">
                    <div class="row">
                        <div class="col col-8 mt-2">
                            <form>
                                <a href="{{route('promo.create')}}" class="btn btn-warning btn-sm mt-2 mb-4 text-white" style="color:#ebff0d"><i class="fa fa-plus fw-bold">
                                        Create Promo</i></a>
                            </form>
                        </div>
                        <div class="col p-0">
                            <form action="{{ route('searchPromo') }}" method="GET">
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

                <div class="container text-center">
                    <div class="row row-cols-5">
                        <div class="col border">Promo Code</div>
                        <div class="col border">Promo Type</div>
                        <div class="col border">Discount</div>
                        <div class="col border">Description</div>
                        <div class="col border">Action</div>
                    </div>
                    <div class="row">
                        <div class="col text-center border">
                            @if($promo= DB::select('select * from Promo'))
                                @foreach($promo as $Promo)
                                <div class="row">
                                    <div class="col">{{$Promo->promo_code}}</div>
                                    <div class="col">{{$Promo->promo_type}}</div>
                                    <div class="col">{{$Promo->discount}}%</div>
                                    <div class="col">{{$Promo->description}}</div>
                                    <div class="col">
                                        <form action="{{route('promo.destroy',$Promo->promo_code)}}" method="post">
                                            <a href="{{route('promo.edit',$Promo->promo_code)}}" class="btn style=" style="color:#1351d6">
                                                <i class="fa fa-pencil"></i></a>
                                            @csrf
                                            @method("DELETE")
                                            <button class="btn" type="submit" onclick="return confirm('Are you sure?')" style="color:#ff0000"><i
                                                    class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <tr>
                                    <td align="center" colspan="4">Empty Data!! Have a nice day :)</td>
                                </tr>
                            @endif
                        </div>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>