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

                    <form action="{{ route('shift.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Shift</label>
                            <select class="form-select" name="shift_time" required>
                                <option value="1" <?= old('shift_time') == "1" ? "selected" : ""?>>1</option>
                                <option value="2" <?= old('shift_time') == "2" ? "selected" : ""?>>2</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Day</label>
                            <select class="form-select" name="day" required>
                                <option value="Tuesday" <?= old('day') == "Tuesday" ? "selected" : ""?>>Tuesday</option>
                                <option value="Wednesday" <?= old('day') == "Wednesday" ? "selected" : ""?>>Wednesday</option>
                                <option value="Thursday" <?= old('day') == "Thursday" ? "selected" : ""?>>Thursday</option>
                                <option value="Friday" <?= old('day') == "Friday" ? "selected" : ""?>>Friday</option>
                                <option value="Saturday" <?= old('day') == "Saturday" ? "selected" : ""?>>Saturday</option>
                                <option value="Sunday" <?= old('day') == "Sunday" ? "selected" : ""?>>Sunday</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Employee Name</label>
                            @if($employee = DB::select('select * from Employee e join Users u on(e.user_id = u.id)
                                                        where e.verifikasi_admin = "Verified"'))
                                <select class="form-select" name="user_id" required>
                                    @foreach($employee as $Employee)
                                    <option value="{{$Employee->id}}"
                                        <?= old('hari') == "{{$Employee->id}}" ? "selected" : ""?>>
                                        {{$Employee->name}}</option>
                                    @endforeach
                                </select>
                                
                                <div class="gap-2 mt-4 text-center">
                                    <button type="submit" class="btn btn-outline-primary" name="register">Submit</button>
                                    <a class="btn btn-outline-primary ms-2" href="{{ route('shift.index') }}">Back</a>
                                </div>
                            @else
                                <select class="form-select" disabled>
                                    <option>There's No Employee Yet :(</option>
                                </select>

                                <div class="d-grid gap-2 mt-4">
                                    <a class="btn btn-outline-primary" href="{{ route('shift.index') }}"><i class="fa fa-arrow-left"> Back</i></a>
                                </div>
                            @endif
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>