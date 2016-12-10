@extends('resources.views.emails.layouts.default')

@section('content')
    <p>Hello {{ $first_name . ' ' . $last_name }},</p>

    <p>Your reservation: {{ $asset_name }} is ready for loan!.</p>

    <p>With kind regards,</p>
    <p>The Snipe-it team</p>
@stop