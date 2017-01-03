@extends('.emails.layouts.default')

@section('content')
    <p>Hello {{ $first_name . ' ' . $last_name }},</p>

    <p>Your teacher has {{ $decision }} your reservationrequest for the asset: {{ $asset_name }}.</p>
    <p>You'll get an email when your asset is ready for loan</p>

    <p>With kind regards,</p>
    <p>The Snipe-it team</p>
@stop
