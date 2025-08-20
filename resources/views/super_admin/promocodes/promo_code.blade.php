@extends('layouts.super_admin')


@section('content')

<div>
    @foreach ($promoCodes as $promoCode)
        <div>
            <h5>{{ $promoCode->code }}</h5>
            <p>Discount: {{ $promoCode->discount }}%</p>
            <p>Expires on: {{ $promoCode->expires_at }}</p>
        </div>
    @endforeach
    <p>{{ $promoCodes->links() }}</p>
</div>

@endsection
