var HuidigeDatum = new Date();
var datetime = "Last Sync: " + HuidigeDatum.getDate() + "/"
    + (HuidigeDatum.getMonth()+1)  + "/"
    + HuidigeDatum.getFullYear() + " @ "
    + HuidigeDatum.getHours() + ":"
    + HuidigeDatum.getMinutes() + ":"
    + HuidigeDatum.getSeconds();



var Calendar = function(o) {
    this.divId = o.ParentID;

    this.DaysOfWeek = o.DaysOfWeek;

    console.log("this.DaysOfWeek == ", this.DaysOfWeek)

    this.Months = o.Months;

    console.log("this.Months == ", this.Months)

    var d = new Date();

    console.log("d == ", d)

    this.CurrentMonth = d.getMonth();

    console.log("this.CurrentMonth == ", this.CurrentMonth);

    this.CurrentYear = d.getFullYear();

    console.log("this.CurrentYear == ", this.CurrentYear);

    var f=o.Format;

    console.log("o == ", o);

    console.log("f == ", f);


    if(typeof(f) == 'string') {
        this.f  = f.charAt(0).toUpperCase();
    } else {
        this.f = 'M';
    }

    console.log("this.f == ", this.f);
};

Calendar.prototype.nextMonth = function() {
    console.log("Calendar.prototype.nextMonth = function() {");

    if ( this.CurrentMonth == 11 ) {
        console.log("this.CurrentMonth == ", this.CurrentMonth);

        this.CurrentMonth = 0;

        console.log("this.CurrentMonth == ", this.CurrentMonth);

        console.log("this.CurrentYear == ", this.CurrentYear);

        this.CurrentYear = this.CurrentYear + 1;

        console.log("this.CurrentYear == ", this.CurrentYear);
    } else {
        console.log("this.CurrentMonth == ", this.CurrentMonth);

        this.CurrentMonth = this.CurrentMonth + 1;

        console.log("this.CurrentMonth + 1 == ", this.CurrentMonth);
    }

    this.showCurrent();
};

Calendar.prototype.previousMonth = function() {
    console.log("Calendar.prototype.previousMonth = function() {");

    if ( this.CurrentMonth == 0 ) {
        console.log("this.CurrentMonth == ", this.CurrentMonth);

        this.CurrentMonth = 11;

        console.log("this.CurrentMonth == ", this.CurrentMonth);

        console.log("this.CurrentYear == ", this.CurrentYear);

        this.CurrentYear = this.CurrentYear - 1;

        console.log("this.CurrentYear == ", this.CurrentYear);
    } else {
        console.log("this.CurrentMonth == ", this.CurrentMonth);

        this.CurrentMonth = this.CurrentMonth - 1;

        console.log("this.CurrentMonth - 1 == ", this.CurrentMonth);
    }

    this.showCurrent();
};

Calendar.prototype.previousYear = function() {
    console.log(" ");

    console.log("Calendar.prototype.previousYear = function() {");

    console.log("this.CurrentYear == " + this.CurrentYear);

    this.CurrentYear = this.CurrentYear - 1;

    console.log("this.CurrentYear - 1 i.e. this.CurrentYear == " + this.CurrentYear);

    this.showCurrent();
}

Calendar.prototype.nextYear = function() {
    console.log(" ");

    console.log("Calendar.prototype.nextYear = function() {");

    console.log("this.CurrentYear == " + this.CurrentYear);

    this.CurrentYear = this.CurrentYear + 1;

    console.log("this.CurrentYear - 1 i.e. this.CurrentYear == " + this.CurrentYear);

    this.showCurrent();
}

Calendar.prototype.showCurrent = function() {
    console.log(" ");

    console.log("Calendar.prototype.showCurrent = function() {");

    console.log("this.CurrentYear == ", this.CurrentYear);

    console.log("this.CurrentMonth == ", this.CurrentMonth);

    this.Calendar(this.CurrentYear, this.CurrentMonth);
};

Calendar.prototype.Calendar = function(y,m) {
    console.log(" ");

    console.log("Calendar.prototype.Calendar = function(y,m){");

    typeof(y) == 'number' ? this.CurrentYear = y : null;

    console.log("this.CurrentYear == ", this.CurrentYear);

    typeof(y) == 'number' ? this.CurrentMonth = m : null;

    console.log("this.CurrentMonth == ", this.CurrentMonth);


    var EersteDagVanDeMaand = new Date(y, m, 1).getDay();

    console.log("firstDayOfCurrentMonth == ", EersteDagVanDeMaand);


    var LaatsteDagVanDeMaand = new Date(y, m+1, 0).getDate();

    console.log("lastDateOfCurrentMonth == ", LaatsteDagVanDeMaand);


    console.log("m == ", m);

    var LaatsteDagVanDeLaatsteMaand = m == 0 ? new Date(y-1, 11, 0).getDate() : new Date(y, m, 0).getDate();

    console.log("lastDateOfLastMonth == ", LaatsteDagVanDeLaatsteMaand);

    console.log("Print selected month and year.");


    var MaandenJaarhtml = '<span id="monthandyearspan">' + this.Months[m] + ' - ' + y + '</span>';

    console.log("monthandyearhtml == " + MaandenJaarhtml);

    var html = '<table>';

    html += '<tr>';

    console.log(" ");

    console.log("Write the header of the days of the week");

    for(var i=0; i < 7;i++) {
        console.log("i == ", i);

        console.log("this.DaysOfWeek[i] == ", this.DaysOfWeek[i]);

        html += '<th class="daysheader">' + this.DaysOfWeek[i] + '</th>';
    }

    html += '</tr>';

    console.log("Before conditional operator this.f == ", this.f);



    var p = dm = this.f == 'M' ? 1 : EersteDagVanDeMaand == 0 ? -5 : 2;


    console.log("After conditional operator");

    console.log("this.f == ", this.f);

    console.log("p == ", p);

    console.log("dm == ", dm);

    console.log("firstDayOfCurrentMonth == ", EersteDagVanDeMaand);

    var cellvalue;

        for (var d, i=0, z0=0; z0<6; z0++) {
            html += '<tr>';

            console.log("Inside 1st for loop - d == " + d + " | i == " + i + " | z0 == " + z0);

            for (var z0a = 0; z0a < 7; z0a++) {
                console.log("Inside 2nd for loop");

                console.log("z0a == " + z0a);

                d = i + dm - EersteDagVanDeMaand;

                console.log("d outside if statm == " + d);


                if (d < 1){
                    console.log("d < 1");

                    console.log("p before p++ == " + p);

                    cellvalue = LaatsteDagVanDeLaatsteMaand - EersteDagVanDeMaand + p++;

                    console.log("p after p++ == " + p);

                    console.log("cellvalue == " + cellvalue);


                    html += '<td id="prevmonthdates">' +
                        '<span id="cellvaluespan">' + (cellvalue) + '</span><br/></td>';

                } else if ( d > LaatsteDagVanDeMaand) {
                    console.log("d > lastDateOfCurrentMonth");

                    console.log("p before p++ == " + p);

                    html += '<td id="nextmonthdates">' + (p++) + '</td>';
                    console.log("p after p++ == " + p);


                } else {
                    html += '<td id="currentmonthdates">' + (d) + '</td>';

/*
                    html += '<td id="currentmonthdates"><ul>'+ $(document).ready(function ()
                        {
                            $.ajax({
                                url: '/JavascriptCalAjax',
                                type:"GET",
                                success: function (data) {
                                    console.log(data);
                                    for (var i = 0; i < data[0].length; i++) {
                                        where(data.last_checkout < HuidigeDatum && data.expected_checkin > HuidigeDatum)
                                        {
                                            $('#name').append("<li>" + data[i] + "</ul>");
                                        }
                                }

                                }
                            });
                            function ajaxJavascriptCal() {
                            var asset_id = $('#asset_id').val();
                            var asset_name = $('#asset_name').val();
                            var expected_checkin = $('#checkin_at').val();
                            var last_checkout = $('#checkout_at').val();
                            console.log("Function works");
                            $.ajax({
                                type: 'GET',
                                url: '/JavascriptCalAjax',
                                data: {'asset_id' : asset_id, 'asset_name' : asset_name, 'expected_checkin': expected_checkin,'last_checkout':last_checkout},
                                success:function(data){
                                    alert(data);
                                    location.reload();
                                }
                            });

                        }
                        });+ '</ul></td>';
                    */
                    console.log("d inside else { == " + d);

                    p = 1;

                    console.log("p inside } else { == " + p);
                }

                if (i % 7 == 6 && d >= LaatsteDagVanDeMaand) {
                    console.log("INSIDE if (i % 7 == 6 && d >= lastDateOfCurrentMonth) {");

                    console.log("i == " + i);

                    console.log("d == " + d);

                    console.log("z0 == " + z0);

                    z0 = 10;
                }

                console.log("i before i++ == " + i);

                i++;

                console.log("i after i++ == " + i);
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
