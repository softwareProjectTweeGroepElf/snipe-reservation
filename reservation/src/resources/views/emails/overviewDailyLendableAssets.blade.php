@extends('.emails.layouts.default')

@section('content')
    <p>Hello,</p>

    <p>Here is an overview from the assets that will be lend on {{$today}}: </p>

    <table style="border: 1px solid black; padding: 5px;" width="100%" cellspacing="0" cellpadding="3">
        <tr>
            <td><strong>Name</strong></td>
            <td><strong>Asset</strong></td>
        </tr>

        @for ($x = 0; $x < $count; $x++)
            <tr>
                <td>{{$data[$x]['first_name'] . ' ' . $data[$x]['last_name'] }}</td>
                <td>{{ $data[$x]['asset_name'] }}</td>
            </tr>

        @endfor


    </table>

    <p>With kind regards,</p>
    <p>The Snipe-it team</p>
@stop
