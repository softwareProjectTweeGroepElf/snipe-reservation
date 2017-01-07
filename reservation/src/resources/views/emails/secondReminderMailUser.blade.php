@extends('.emails.layouts.default')

@section('content')
    <p>Hello {{ $first_name . ' ' . $last_name }},</p>

    <p>The loan period from your asset "<strong>{{ $asset_name }}</strong>" has ended today!</p>
    <p>A fine will be calculated per day late.</p>

    <p>With kind regards,</p>
    <p>The Snipe-it team</p>
@stop
