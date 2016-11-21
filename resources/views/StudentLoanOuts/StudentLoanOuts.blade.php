<?php
use Carbon\Carbon;
?>
@extends('layouts/default')


{{-- Page title --}}
@section('title')
    {{ trans('general.reservation_report') }}
    @parent
@stop

        {{-- Page content --}}
        @section('content')
            <div class="row">
                <div class="col-md-12">

                    <div class="box box-default">
                        <div class="box-body">

                            <table
                                    data-url="{{route('api.users.list')}}"
                                    user="user"
                                    name="reservation"
                                    id="table"
                                    class="table table-striped"
                                    data-url="{{route('api.reservation_request.list') }}"
                                    data-cookie="true"
                                    data-click-to-select="true"
                                    data-cookie-id-table="reservationTable-{{ config('version.hash_version') }}">
                                <thead>
                                <tr>



                                    <th data-sortable="true"  data-field="id" data-visible="false">     </th>

                                    <th data-sortable="false" data-field="name" data-visible="user_name">{{ trans('user') }}</th>
                                    @where(reservation_request/table.asset_userId==user/userId)
                                    <th data-sortable="false" data-field="asset_name">{{ trans('reservation_request/table.asset_name') }}</th>
                                    <th data-sortable="true" data-field="id" data-visible="false">{{ trans('reservation_request/table.asset_Id') }}</th>
                                    <th data-sortable="false" data-field="supplier">{{ trans('reservation_request/table.supplier_name') }}</th>
                                    <th data-searchable="true" data-sortable="false" data-field="start_date">{{ trans('reservation_request/table.form.start_date') }}</th>
                                    <th data-searchable="true" data-sortable="true" data-field="end_date">{{ trans('reservation_request/table.form.completion_date') }}</th>
                                    @stop
                                </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
                @stop

                @section('moar_scripts')
                    <script src="{{ asset('assets/js/bootstrap-table.js') }}"></script>
                    <script src="{{ asset('assets/js/extensions/cookie/bootstrap-table-cookie.js') }}"></script>
                    <script src="{{ asset('assets/js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
                    <script src="{{ asset('assets/js/extensions/export/bootstrap-table-export.js') }}"></script>
                    <script src="{{ asset('assets/js/extensions/export/tableExport.js') }}"></script>
                    <script src="{{ asset('assets/js/extensions/export/jquery.base64.js') }}"></script>
                    <script src="{{ asset('assets/js/plugins/chartjs/Chart.min.js') }}"></script>
                    <script type="text/javascript">
                        $('#table').bootstrapTable({
                            classes: 'table table-responsive table-no-bordered',
                            undefinedText: '',
                            iconsPrefix: 'fa',
                            showRefresh: true,
                            search: true,
                            pageSize:{{ \App\Models\Setting::getSettings()->per_page }},
                            pagination: true,
                            sidePagination: 'server',
                            sortable: true,
                            cookie: true,
                            cookieExpire: '2y',
                            mobileResponsive: true,
                            showExport: true,
                            showColumns: true,
                            exportDataType: 'all',
                            exportTypes: ['csv', 'txt','json', 'xml'],
                            exportOptions: {
                                fileName: 'maintenances-export-' + (new Date()).toISOString().slice(0,10),
                            },
                            maintainSelected: true,
                            paginationFirstText: "{{ trans('general.first') }}",
                            paginationLastText: "{{ trans('general.last') }}",
                            paginationPreText: "{{ trans('general.previous') }}",
                            paginationNextText: "{{ trans('general.next') }}",
                            pageList: ['10','25','50','100','150','200'],
                            icons: {
                                paginationSwitchDown: 'fa-caret-square-o-down',
                                paginationSwitchUp: 'fa-caret-square-o-up',
                                columns: 'fa-columns',
                                refresh: 'fa-refresh'
                            },

                        });
                    var pieChartCanvas = $("#statusPieChart").get(0).getContext("2d");
                    var pieChart = new Chart(pieChartCanvas);
                    var ctx = document.getElementById("statusPieChart");


                    $.get('{{  route('api.statuslabels.assets') }}', function (data) {
                        var myPieChart = new Chart(ctx,{

                            type: 'doughnut',
                            data: data,
                            options: pieOptions
                        });
                        // document.getElementById('my-doughnut-legend').innerHTML = myPieChart.generateLegend();
                    });
                </script>
@stop
