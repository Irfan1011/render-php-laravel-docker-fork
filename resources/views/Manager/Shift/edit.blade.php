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

                <form action="{{ route('shift.update',$shift->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <!-- Shift -->
                    <div class="mb-3">
                        <label class="form-label">Shift</label>
                        <select class="form-select" name="shift_time" required>
                            <option value="1" <?= $shift->shift_time  == "1" ? "selected" : ""?>>1</option>
                            <option value="2" <?= $shift->shift_time == "2" ? "selected" : ""?>>2</option>
                        </select>
                    </div>

                    <!-- Day -->
                    <div class="mb-3">
                        <label class="form-label">Day</label>
                        <select class="form-select" name="day" required>
                            <option value="Tuesday" <?= $shift->day == "Tuesday" ? "selected" : ""?>>Tuesday</option>
                            <option value="Wednesday" <?= $shift->day == "Wednesday" ? "selected" : ""?>>Wednesday</option>
                            <option value="Thursday" <?= $shift->day == "Thursday" ? "selected" : ""?>>Thursday</option>
                            <option value="Friday" <?= $shift->day == "Friday" ? "selected" : ""?>>Friday</option>
                            <option value="Saturday" <?= $shift->day == "Saturday" ? "selected" : ""?>>Saturday</option>
                            <option value="Sunday" <?= $shift->day == "Sunday" ? "selected" : ""?>>Sunday</option>
                        </select>
                    </div>

                    <!-- Employee -->
                    <div class="mb-3">
                        <label class="form-label">Employee Name</label>
                        @if($employeeShift = DB::select('select * from Shift s join Users u on(s.user_id = u.id)'))
                            <select class="form-select" name="user_id" required disabled>
                                @foreach($employeeShift as $EmployeeShift)
                                    @if($EmployeeShift->id == $shift->user_id)
                                    <option value="{{$EmployeeShift->id}}"
                                        {{ $shift->user_id == $EmployeeShift->id ? "selected" : ""}}>
                                        {{$EmployeeShift->name}}</option>
                                    @endif
                                @endforeach

                                @foreach($employeeShift as $EmployeeShift)
                                    @if($EmployeeShift->id == $shift->user_id)
                                        <input type="hidden" name="user_id[]" value="{{$EmployeeShift->id}}">
                                    @endif
                                @endforeach
                            </select>
                            <div class="gap-2 mt-4 text-center">
                                <button type="submit" class="btn btn-outline-primary" name="submit">Submit</button>
                                <a class="btn btn-outline-primary ms-2" href="{{ route('shift.index') }}">Back</i></a>
                            </div>
                        @endif
                    </div>
                </form>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>