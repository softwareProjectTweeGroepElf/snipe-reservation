@extends('resources.views.emails.layouts.default')

@section('content')
    <p>Hello {{ $first_name . ' ' . $last_name }},</p>

    <p>The loan period from your asset {{ $asset_name }} ends tomorrow!.</p>
@stop
