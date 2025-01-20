<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Driver') }}
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
                            <form action="{{ route('searchDriver') }}" method="GET">
                                <label class="form-label">Search</label>
                                <input type="text" id="search" name="search" placeholder="Search Driver"
                                    style="border-radius:10px; border: 1px solid black;">
                                <button type="submit" style="border:none; background-color:transparent;"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="container text-center">
                    @if($driver = DB::select('SELECT * FROM Driver'))
                    @foreach($combinedData as $Driver)
                    <div class="row border border-dark">
                        <div class="col-md-3 col-sm-12 d-flex justify-content-center align-items-center">
                            <div class="img-fluid left-reveal" style="background-image: url('{{ asset('uploads/Driver_Photo/'.$Driver->photo) }}'); width: 250px; height: 200px; background-size: cover; background-position: center;"></div>
                        </div>
                        <div class="col">
                            <div class="row row-cols-2">
                                <div class="col-md-6 col-sm-6">
                                    <div class="row border-bottom border-dark ps-2">Name</div>
                                    <div class="row border-bottom border-dark ps-2">Address</div>
                                    <div class="row border-bottom border-dark ps-2">Birth (YYYY-MM-DD)</div>
                                    <div class="row border-bottom border-dark ps-2">Gender</div>
                                    <div class="row border-bottom border-dark ps-2">Phone</div>
                                    <div class="row border-bottom border-dark ps-2">Language</div>
                                    <div class="row border-bottom border-dark ps-2">Email</div>
                                    <div class="row border-dark ps-2">Status</div>
                                </div>
                                <div class="col-md-6 col-sm-6 overflow-auto">
                                    <div class="row border-bottom border-dark ps-2">{{$Driver->name}}</div>
                                    <div class="row border-bottom border-dark ps-2">{{$Driver->address}}</div>
                                    <div class="row border-bottom border-dark ps-2">{{$Driver->birth}}</div>
                                    <div class="row border-bottom border-dark ps-2">{{$Driver->gender}}</div>
                                    <div class="row border-bottom border-dark ps-2">{{$Driver->phone}}</div>
                                    <div class="row border-bottom border-dark ps-2">{{$Driver->language}}</div>
                                    <div class="row border-bottom border-dark ps-2">{{$Driver->email}}</div>
                                    <div class="row border-dark ps-2">{{$Driver->verifikasi_admin}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-auto justify-content-center border-bottom border-start border-end border-dark">
                        <div class="col mb-2 fw-bold">Photo Scan Driver License<embed src="{{ asset('uploads/Driver_File/'.$Driver->photocopy_scanDriverLicense) }}" width="250" height="250" /></div>
                        <div class="col mb-2 fw-bold">Drug Free Letter<embed src="{{ asset('uploads/Driver_File/'.$Driver->drug_free_letter) }}" width="250" height="250" /></div>
                        <div class="col mb-2 fw-bold">Mental Health Letter<embed src="{{ asset('uploads/Driver_File/'.$Driver->mental_health_letter) }}" width="250" height="250" /></div>
                    </div>
                    <div class="row row-cols-auto justify-content-center border-bottom border-start border-end border-dark">
                        <div class="col mb-2 fw-bold">Physical Health Certificate<embed src="{{ asset('uploads/Driver_File/'.$Driver->physical_health_certificate) }}" width="250" height="250" /></div>
                        <div class="col mb-2 fw-bold">Criminal Record Certificate<embed src="{{ asset('uploads/Driver_File/'.$Driver->criminal_record_certificate) }}" width="250" height="250" /></div>
                    </div>
                    <div class="row row-cols-auto justify-content-center border-bottom border-start border-end border-dark">
                        <form action="{{route('driver.destroy',$Driver->user_id)}}" method="post">
                            @csrf
                            @method("patch")
                            <a href="{{route('driver.show',$Driver->user_id)}}" class="btn style=" style="color:#1351d6">
                                <i class="fa fa-check-circle-o"></i></a>
                            <a href="{{route('driver.edit',$Driver->user_id)}}" class="btn style=" style="color:#1351d6">
                                <i class="fa fa-pencil"></i></a>
                            @csrf
                            @method("DELETE")
                            <button class="btn" type="submit" onclick="return confirm('Are you sure?')" style="color:#ff0000"><i
                                    class="fa fa-trash"></i></button>
                        </form>
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