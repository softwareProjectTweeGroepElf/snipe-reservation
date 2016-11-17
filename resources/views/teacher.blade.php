@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('Reservaties') }}

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
                                        </tr>
                                        <tr>
                                            <td>{{"Sam Van Roy"}}</td>
                                            <td>{{"17/11/2016"}}</td>
                                            <td>{{"Vorige reservaties verliepen prima!"}}</td>
                                            <td>
                                                <button type="button" class="btn btn-success">Accept</button>
                                                <!--<button type="button" class="btn btn-primary">Accept</button>-->
                                                <button type="button" class="btn btn-secondary">Reject</button>
                                            </td>
                                        </tr>
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
