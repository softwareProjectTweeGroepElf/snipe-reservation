@extends('emails/layouts/default')

@section('content')
    <p>Hello {{ $first_name . ' ' . $last_name }},</p>

    <p>Your teacher has {{ $decision }} your reservationrequest for the asset: {{ $asset_name }}.</p>
@stop