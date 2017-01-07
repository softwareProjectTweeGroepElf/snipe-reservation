<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Calendar</title>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('reservation/css/calendar.css') }}" />
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="{{ URL::asset('reservation/js/calendar.js') }}"></script>
<div class="divcalendar">

    <div id="calendaroverallcontrols">

        <div id="calendarmonthcontrols">
            <a id="btnPrevYr" href="#" title="Previous Year"><span><<</span></a>

            <a id="btnPrev" href="#" title="Previous Month"><span><</span></a>

            <div id="monthandyear"></div>

            <a id="btnNext" href="#" title="Next Month"><span>></span></a>

            <a id="btnNextYr" href="#" title="Next Year"><span>>></span></a>
        </div>
    </div>
    <div id="divcalendartable"></div>

</body>
</html>