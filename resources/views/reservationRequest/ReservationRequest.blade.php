@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('Reservation Request') }}
    @parent
@stop


@section('header_right')
    <a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
        {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')



    <div class="row">
        <div class="col-md-9">
            <form class="form-horizontal" method="post" action="" autocomplete="off">
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                <div class="box box-default">
                    <div class="box-header with-border">

                        <h3 class="box-title">
                            @if('asset_maintenances/table.assetId=$assetId')
                                {{'asset_maintenances/table.asset_name}}
                                @stop
                        </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <!-- Asset -->
                        <div class="form-group {{ $errors->has('asset_name') ? ' has-error' : '' }}">
                            @if('table.asset_maintenance.assetId=$assetId)
                            <label for="asset_id" class="col-md-3 control-label">{{ trans('asset_maintenances/table.asset_name') }}
                            </label>
                                @stop
                        </div>

                        <!-- Supplier -->
                        <div class="form-group {{ $errors->has('supplier_id') ? ' has-error' : '' }}">
                            @if('table.asset_maintenance.assetId=$assetId)
                            <label for="supplier_id" class="col-md-3 control-label">{{ trans('asset_maintenances/table.supplier_name') }}
                            </label>
                            @stop
                        </div>


                        <!-- Title -->
                        <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                            @if('table.asset_maintenance.assetId=$assetId)
                            <label for="title" class="col-md-3 control-label">{{ trans('asset_maintenances/table.form.title') }}
                            </label>
                            <div>
                                <input class="form-control" type="text" name="title" id="title" />
                                {!! $errors->first('title', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                            </div>
                                @stop
                        </div>

                        <!-- Start Date -->
                        <div class="form-group {{ $errors->has('start_date') ? ' has-error' : '' }}">
                            @if('table.asset_maintenance.assetId=$assetId)
                            <label for="start_date" class="col-md-3 control-label">{{ trans('asset_maintenances/table.form.start_date') }}
                            </label>
                            <div class="input-group col-md-2">
                                <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Select Date" name="start_date" id="start_date" >
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                {!! $errors->first('start_date', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                            </div>
                                @stop
                        </div>

                        <!-- End Date -->
                        <div class="form-group {{ $errors->has('end_date') ? ' has-error' : '' }}">
                            @if('table.asset_maintenance.assetId=$assetId)
                            <label for="end_date" class="col-md-3 control-label">End date</label>
                            <div class="input-group col-md-2">
                                <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="Select Date" name="end_date" id="end_date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                {!! $errors->first('end_date', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                            </div>
                                @stop
                        </div>

                        <!-- Course -->
                        <div class="form-group {{ $errors->has('courses') ? ' has-error' : '' }}">
                            @if('table.asset_maintenance.assetId=$assetId)
                            <label for="courses" class="col-md-3 control-label">Courses</label>
                            <div class="col-md-7">
                                <textarea class="col-md-6 form-control" id="courses" name="courses"></textarea>
                                {!! $errors->first('courses', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                            </div>
                                @stop
                        </div>

                        <!-- Notes -->
                        <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
                            @if('table.asset_maintenance.assetId=$assetId)
                            <label for="notes" class="col-md-3 control-label">{{ trans('asset_maintenances/table.form.notes') }}</label>
                            <div class="col-md-7">
                                <textarea class="col-md-6 form-control" id="notes" name="notes"></textarea>
                                {!! $errors->first('notes', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                            </div>
                                @stop
                        </div>

                    </div>
                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
                    </div>
            </form>
        </div>
    </div>

@stop
