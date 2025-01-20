<style>
.container {
    position: relative;
    text-align: center;
    color: rgb(247, 247, 242);
}

.top-right {
    position: absolute;
    top: 100px;
    right: 80px;
    font-size: 40px;
    font-weight: bold;
}

.customer {
    position: absolute;
    top: 150px;
    right: 80px;
    font-size: 15px;
    font-weight: 500;
}

.id {
    position: absolute;
    top: 170px;
    right: 80px;
    font-size: 15px;
    font-weight: 500;
}

.mobile {
    position: absolute;
    top: 210px;
    right: 80px;
    font-size: 15px;
}

.address {
    position: absolute;
    top: 230px;
    right: 80px;
    font-size: 15px;
}

.email {
    position: absolute;
    top: 250px;
    right: 80px;
    font-size: 15px;
}
</style>
@php
    $customer = DB::table('users')
                ->join('customer','customer.user_id','=','users.id')
                ->where('customer.user_id','=',Auth::user()->id)
                ->first();
                
    $customerID = str_pad($customer->id, 3, '0', STR_PAD_LEFT);
@endphp

<div class="container">
    <img src="{{ public_path('uploads/AJR Customer Card.jpg') }}" alt="Customer Card" width="700"></img>

    <div class="top-right">{{ strtoupper($customer->name) }}</div>

    <p class="customer">CUSTOMER</p>
    <p class="id">CUS{{ date('ymd',strtotime($customer->birth)) }}-{{ $customerID }}</p>

    <p class="mobile">Mobile: {{ $customer->phone }}</p>
    <p class="address">Address: {{ $customer->address }}</p>
    <p class="email">Email: {{ $customer->email }}</p>

</div>