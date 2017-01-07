@extends('.emails.layouts.default')

@section('content')
    <p>Hello {{ $first_name . ' ' . $last_name }},</p>

    <p>Your reservation: "<strong>{{ $asset_name }}</strong>" is ready for loan!.</p>

    <p>With kind regards,</p>
    <p>The Snipe-it team</p>
@stop