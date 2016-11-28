@extends('emails/layouts/default')

@section('content')
    <p>Hello {{ $first_name . ' ' . $last_name }},</p>

    <p>The loan period from your asset {{ $asset_name }} has ended today! A fine will be calculated per day late.</p>
@stop
