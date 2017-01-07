@extends('.emails.layouts.default')

@section('content')
    <p>Hello {{ $first_name . ' ' . $last_name }},</p>

    <p>The loan period from your asset "<strong>{{ $asset_name }}</strong>" ends tomorrow!.</p>
    <p>Don't forget to bring it back, otherwise you'll need to pay a fine</p>

    <p>With kind regards,</p>
    <p>The Snipe-it team</p>
@stop
