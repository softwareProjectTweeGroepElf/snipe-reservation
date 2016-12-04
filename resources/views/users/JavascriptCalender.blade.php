<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Calendar Widget</title>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('JavascriptCalender.css') }}" />
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>

    var Calendar = function(o) {
        this.divId = o.ParentID;
        this.DaysOfWeek = o.DaysOfWeek;

        this.Months = o.Months;


        var d = new Date();

        this.CurrentMonth = d.getMonth();
        this.CurrentYear = d.getFullYear();



        var f=o.Format;

        if(typeof(f) == 'string') {
            this.f  = f.charAt(0).toUpperCase();
        } else {
            this.f = 'M';
        }


        $.ajax({
            type:"GET",
            url: "/JavascriptCalAjax",
            success: function(data) {

                for (var i = 0; i < data[0].length; i++) {
                    var $name = data[0][i][1];

                    $(".outputJavascript").append("<option value='$name'>" + $name + "</option>")

                }
            }

        });

    };
    Calendar.prototype.nextMonth = function() {

        if ( this.CurrentMonth == 11 ) {
            this.CurrentMonth = 0;


            this.CurrentYear = this.CurrentYear + 1;
         } else {

            this.CurrentMonth = this.CurrentMonth + 1;
         }

        this.showCurrent();

        $.ajax({
            type:"GET",
            url: "/JavascriptCalAjax",
            success: function(data) {

                for (var i = 0; i < data[0].length; i++) {
                    var $name = data[0][i][1];

                    $(".outputJavascript").append("<option value='$name'>" + $name + "</option>")

                }
            }

        });

    };

    Calendar.prototype.previousMonth = function() {

        if ( this.CurrentMonth == 0 ) {
            this.CurrentMonth = 11;


            this.CurrentYear = this.CurrentYear - 1;
         } else {

            this.CurrentMonth = this.CurrentMonth - 1;
        }

        this.showCurrent();


        $.ajax({
            type:"GET",
            url: "/JavascriptCalAjax",
            success: function(data) {

                for (var i = 0; i < data[0].length; i++) {
                    var $name = data[0][i][1];

                    $(".outputJavascript").append("<option value='$name'>" + $name + "</option>")

                }
            }

        });
    };

    Calendar.prototype.previousYear = function() {


        this.CurrentYear = this.CurrentYear - 1;


        this.showCurrent();



        $.ajax({
            type:"GET",
            url: "/JavascriptCalAjax",
            success: function(data) {

                for (var i = 0; i < data[0].length; i++) {
                    var $name = data[0][i][1];

                    $(".outputJavascript").append("<option value='$name'>" + $name + "</option>")

                }
            }

        });

    };

    Calendar.prototype.nextYear = function() {

        this.CurrentYear = this.CurrentYear + 1;


        this.showCurrent();

        $.ajax({
            type:"GET",
            url: "/JavascriptCalAjax",
            success: function(data) {

                for (var i = 0; i < data[0].length; i++) {
                    var $name = data[0][i][1];

                    $(".outputJavascript").append("<option value='$name'>" + $name + "</option>")

                }
            }

        });

    };

    Calendar.prototype.showCurrent = function() {

        this.Calendar(this.CurrentYear, this.CurrentMonth);
    };

    Calendar.prototype.Calendar = function(y,m) {
        typeof(y) == 'number' ? this.CurrentYear = y : null;

       typeof(y) == 'number' ? this.CurrentMonth = m : null;


        var EersteDagVanDeMaand = new Date(y, m, 1).getDay();



        var LaatsteDagVanDeMaand = new Date(y, m+1, 0).getDate();


        var LaatsteDagVanDeLaatsteMaand = m == 0 ? new Date(y-1, 11, 0).getDate() : new Date(y, m, 0).getDate();


        var MaandenJaarhtml = '<span id="monthandyearspan">' + this.Months[m] + ' - ' + y + '</span>';


        var html = '<table>';

        html += '<tr>';

        for(var i=0; i < 7;i++) {

            html += '<th class="daysheader">' + this.DaysOfWeek[i] + '</th>';
        }

        html += '</tr>';




        var p = dm = this.f == 'M' ? 1 : EersteDagVanDeMaand == 0 ? -5 : 2;



        var cellvalue;

        for (var d, i=0, z0=0; z0<6; z0++) {
            html += '<tr>';


            for (var z0a = 0; z0a < 7; z0a++) {

                d = i + dm - EersteDagVanDeMaand;



                if (d < 1){
                      cellvalue = LaatsteDagVanDeLaatsteMaand - EersteDagVanDeMaand + p++;



                    html += '<td id="prevmonthdates">' +
                            '<span id="cellvaluespan">' + (cellvalue) + '</span><br/></td>';

                } else if ( d > LaatsteDagVanDeMaand) {

                    html += '<td id="nextmonthdates">' + (p++) + '</td>';


                } else {


                    html += '<td id="currentmonthdates">' + (d)+'<br/><br/>'+'<select class="outputJavascript""></select>' + '</td>';



                    p = 1;

               }

                if (i % 7 == 6 && d >= LaatsteDagVanDeMaand) {

                    z0 = 10;
                }


                i++;

            }

            html += '</tr>';
        }


        html += '</table>';




        document.getElementById("monthandyear").innerHTML = MaandenJaarhtml;
        document.getElementById(this.divId).innerHTML = html;

    };


    window.onload = function() {


        var c = new Calendar({
            ParentID:"divcalendartable",

            DaysOfWeek:[
                'MON',
                'TUE',
                'WED',
                'THU',
                'FRI',
                'SAT',
                'SUN'
            ],

            Months:['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ],

            Format:'dd/mm/yyyy'
        });

        c.showCurrent();


        getId('btnPrev').onclick = function(){
            c.previousMonth();
        };

        getId('btnPrevYr').onclick = function(){
            c.previousYear();
        };

        getId('btnNext').onclick = function(){
            c.nextMonth();
        };

        getId('btnNextYr').onclick = function(){
            c.nextYear();
        };
    }

    function getId(id) {
        return document.getElementById(id);
    }


</script>
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