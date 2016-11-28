<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $.ajax({
            type: 'GET',
            url: '/package/initdoc',
            data: "",
            success:function(data){
                for (var i = 0; i < data.length; i++) {
                    $('#asset_id').append("<option value=" + data[i][0] + ">" + data[i][1] + "</option>");
                }
            }
        });
    });
    function callAjax() {
        var datastring = $('#asset_id').val();
        console.log("Function works");
        $.ajax({
            type: 'GET',
            url: '/package/postrequestreservation',
            data: {'asset_id' : datastring},
            success:function(data){
                console.log(data);
                location.reload();
            }
        });
    }
</script>

<style type="text/css">
    body{
        font-family: Tahoma;
        padding: 0;
        margin: 0;
    }
    h1{
        font-weight: 100;
    }
    select{
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
    #content{
        margin-left: calc(20vw - 8.5px);
        width: 60vw;
        box-shadow: 6px 0px 17px -5px rgba(0,0,0,0.75), -6px 0px 17px -5px rgba(0,0,0,0.75);
        height: auto;
    }
    #titelbar{
        background-color: rgb(229, 229, 229);
        color: white;
        height: 200px;
        line-height: 200px;
        text-align: center;
    }
    #titel_text{
        margin-top: 30px;
        font-size: 60px;
    }
    #wrapper {
        background-color: rgb(242, 242, 242);
        padding: 20px 15px;
    }
    .requested_assets_table_cont{
        width: 90%;
        margin: auto;
        height: 600px;
        -webkit-box-shadow: 0px 0px 25px -5px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 0px 25px -5px rgba(0,0,0,0.75);
        box-shadow: 0px 0px 25px -5px rgba(0,0,0,0.75);
        overflow-y: scroll;
        background-color: white;
        text-align: center;
    }
    .requested_assets_table_cont::-webkit-scrollbar {
        width : 10px;
        margin-right: 5px;
    }
    .requested_assets_table_cont::-webkit-scrollbar-thumb {
        background: #EDEDED;
        height: 15px;
    }
    .requested_assets_table_cont2{
        display: inline-block;
        max-width: 80%;
        padding: 10px 0px 10px 0px;
    }
    .requested_assets_table{
        width: auto;
        border-collapse: collapse;
    }
    .requested_assets_table td{
        border: 1px solid black;
        border-collapse: collapse;
    }
    .requested_assets_table th, td{
        padding: 3px 5px 3px 5px;
    }
    .submit_btn{
        height: 45px;
        width: 150px;
        text-align: center;
        line-height: 45px;
        color: white;
        background-color: rgb(193, 193, 193);
        cursor: pointer;
        transition: background-color 0.15s ease-in 0s;
    }
    .submit_btn:hover{
        background-color: rgb(147, 147, 147);
    }
    #submitCont{
        background-color: white;
        width: 50%;
        margin: auto;
        text-align: center;
        border: 2px solid white;
        border-radius: 30px;
        margin-bottom: 30px;
    }
    #submitCont .submit_btn{
        margin: auto;
    }
    #footer{
        line-height: 60px;
        text-align: center;
        width: 100vw;
        height: 60px;
        background-color: rgb(229, 229, 229);
        -webkit-box-shadow: inset 0px 16px 0px -13px #939393;
        -moz-box-shadow: inset 0px 16px 0px -13px #939393;
        box-shadow: inset 0px 16px 0px -13px #939393;
    }
</style>
<div id="page_body">
    <div id="content">
        <div id="titelbar">
            <tekst id="titel_text">Students Page</tekst>
        </div>
        <div id="wrapper">
            <div id="submitCont">
                <h1>Request a loan:</h1>
                <p>Select the asset you want to loan</p>

                <form id="submitForm">
                    {{ csrf_field() }}
                    <label>Asset: </label>
                    <select id="asset_id">
                    </select>
                    <br> <br>
                    <div class="submit_btn" onclick="callAjax()">Submit</div>
                </form>
            </div>
            <hr>

            <h1>List of your requests: </h1>

            <div class="requested_assets_table_cont">
                <div class="requested_assets_table_cont2">
                    <table id="requested_assets_table" class="requested_assets_table">

                        <tr>
                            <th>User ID</th>
                            <th>Asset ID</th>
                            <th>User name</th>
                            <th>Asset name</th>
                        </tr>

                        @foreach($userassets as $asset)
                        <tr>
                            <td> {{$asset->user_id}} <br> </td>
                            <td> {{$asset->asset_id}} <br> </td>
                            <td> {{$asset->name}} <br> </td>
                            <td> {{$asset->Aname}} <br> </td>
                        </tr>
                        @endforeach

                    </table>
                </div>
            </div>

            <br>
            <hr>

            <h1>List of available assets: </h1>

            <div class="requested_assets_table_cont">
                <div class="requested_assets_table_cont2">
                    <table class="requested_assets_table">
                        <tr>
                            <th>ID</th>
                            <th>Asset name</th>
                            <th>Asset Tag</th>
                            <th>Serial</th>
                            <th>Status</th>
                        </tr>

                        @foreach($assets as $asset)
                        <tr>
                            <td> {{$asset->id}} <br> </td>
                            <td> {{$asset->name}} <br> </td>
                            <td> {{$asset->asset_tag}} <br>  </td>
                            <td> {{$asset->serial}} <br>  </td>
                            <td> <?php if($asset->assigned_to == null){echo "available";}else {echo "Assigned to user with ID ".$asset->assigned_to;}?> <br> </td>
                        </tr>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="footer">
        <tekst id="footer_text">Copyright © Groep 11</tekst>
    </div>

</div>