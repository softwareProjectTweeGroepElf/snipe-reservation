<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Calendar Widget</title>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('JavascriptCalender.css') }}" />
    <script src="{{ URL::asset('JavascriptCalender.js') }}"></script>
</head>
<body><div class="divcalendar">

    <div id="calendaroverallcontrols">
        <!-- <div id="year"></div> -->

        <div id="calendarmonthcontrols">
            <a id="btnPrevYr" href="#" title="Previous Year"><span><<</span></a>

            <a id="btnPrev" href="#" title="Previous Month"><span><</span></a>

            <!-- <input type="button" src="images/btnprevmonth.png" alt="Submit" id="btnPrev"/>-->

            <!-- <div id="month"></div>-->

            <div id="monthandyear"></div>

            <!--<input type="button" src="images/btnnextmonth.png" alt="Submit" id="btnNext"/>-->

            <a id="btnNext" href="#" title="Next Month"><span>></span></a>

            <a id="btnNextYr" href="#" title="Next Year"><span>>></span></a>
        </div>
    </div>

    <div id="divcalendartable"></div></div>
</body>
</html>