@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('Reservations') }}

    @parent
@stop




{{-- Page content --}}
@section('content')
    <div class="row">
        <div class="col-md-12">

            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">

                <div class="tab-content">
                    <div class="tab-pane fade in active" id="details">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="table-responsive" style="margin-top: 10px;">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td>{{ "Naam aanvrager" }}</td>
                                            <td>{{"Datum van aanvraag"}}</td>
                                            <td> {{"Reservatie-info"}}</td>
                                            <td> {{"Actions"}}</td>
                                        </tr>
                                        @foreach($reservations as $reservation)
                                        <tr>
                                            <td>{{User::find($reservation->user_id)->name}}</td>
                                            <td>{{$reservation->created_at}}</td>
                                            <td>{{$reservation->subject}}</td>
                                            <td>
                                                <input type="button" class="btn btn-primary" value="Accept" name="btnAccept">
                                                <input type="button" class="btn btn-secondary" value="Reject" name="btnReject">

                                                @if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                    @if (isset($_POST['btnAccept'])) {
                                                        {{\Reservation\Controllers\ReservationController::acceptReservation($request)}}
                                                    } @else {
                                                        {{\Reservation\Controllers\ReservationController::rejectReservation($request)}}
                                                    }
                                                }
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div> <!-- /.col-md-12 -->
                            </div> <!-- /.row -->
                        </div> <!-- /.tab-pane files -->
                    </div> <!-- /. tab-content -->
                </div> <!-- /.nav-tabs-custom -->
            </div> <!-- /. col-md-12 -->
        </div> <!-- /. row -->
    </div>
@section('moar_scripts')
    <script>
        $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    </script>
@stop

@stop
