<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Print Card') }}
        </h2>
        
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Here is your customer card") }}
        </p>
    </header>

    @php
        $Customer = DB::table('users')
                    ->join('customer','customer.user_id','=','users.id')
                    ->where('customer.user_id','=',Auth::user()->id)
                    ->first();
    @endphp

    <div class="flex items-center gap-4 mt-6">
        <a href="{{route('exportCard',$Customer->id)}}"><x-primary-button>{{ __('Export Card') }}<i class="fa fa-id-card-o"></i></x-primary-button></a>

        @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600"
            >{{ __('Saved.') }}</p>
        @endif
    </div>
</section>
