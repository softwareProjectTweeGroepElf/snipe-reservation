
@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('Agenda Uitleendienst') }}
    @parent
@stop

{{-- Page content --}}
@section('content')

    <iframe src="https://calendar.google.com/calendar/embed?src=tb9g41069q101lvh8vn5abfq8g%40group.calendar.google.com&ctz=Europe/Brussels" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>

@section('moar_scripts')
    <script>
        $(function () {
            //binds to onchange event of your input field
            var uploadedFileSize = 0;
            $('#fileupload').bind('change', function() {
                uploadedFileSize = this.files[0].size;
                $('#progress-container').css('visibility', 'visible');
            });

            $('#fileupload').fileupload({
                //maxChunkSize: 100000,
                dataType: 'json',
                formData:{
                    _token:'{{ csrf_token() }}',
                    notes: $('#notes').val(),
                },

                progress: function (e, data) {
                    //var overallProgress = $('#fileupload').fileupload('progress');
                    //var activeUploads = $('#fileupload').fileupload('active');
                    var progress = parseInt((data.loaded / uploadedFileSize) * 100, 10);
                    $('.progress-bar').addClass('progress-bar-warning').css('width',progress + '%');
                    $('#progress-bar-text').html(progress + '%');
                    //console.dir(overallProgress);
                },

                done: function (e, data) {
                    console.dir(data);

                    // We use this instead of the fail option, since our API
                    // returns a 200 OK status which always shows as "success"

                    if (data && data.jqXHR.responseJSON.error && data.jqXHR.responseJSON && data.jqXHR.responseJSON.error) {
                        $('#progress-bar-text').html(data.jqXHR.responseJSON.error);
                        $('.progress-bar').removeClass('progress-bar-warning').addClass('progress-bar-danger').css('width','100%');
                        $('.progress-checkmark').fadeIn('fast').html('<i class="fa fa-times fa-3x icon-white" style="color: #d9534f"></i>');
                        console.log(data.jqXHR.responseJSON.error);
                    } else {
                        $('.progress-bar').removeClass('progress-bar-warning').addClass('progress-bar-success').css('width','100%');
                        $('.progress-checkmark').fadeIn('fast');
                        $('#progress-container').delay(950).css('visibility', 'visible');
                        $('.progress-bar-text').html('Finished!');
                        $('.progress-checkmark').fadeIn('fast').html('<i class="fa fa-check fa-3x icon-white" style="color: green"></i>');
                        $.each(data.result.file, function (index, file) {
                            $('<tr><td>' + file.notes + '</td><<td>' + file.name + '</td><td>Just now</td><td>' + file.filesize + '</td><td><a class="btn btn-info btn-sm" href="import/process/' + file.name + '"><i class="fa fa-spinner process"></i> Process</a></td></tr>').prependTo("#upload-table > tbody");
                            //$('<tr><td>').text(file.name).appendTo(document.body);
                        });
                    }
                    $('#progress').removeClass('active');


                }
            });
        });
    </script>

@stop

@stop

