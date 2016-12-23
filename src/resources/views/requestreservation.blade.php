<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		$('#search').change(function() {
			searchAvailableAssets();
		});
		
		$.ajax({
			type: 'GET',
			url: '/reservation/initdoc',
			data: "",
			success: function(data) {
				for(var i = 0; i < data.length; i++) {
					$('#asset_id').append("<option value=" + data[i]['id'] + ">" + data[i]['name'] + "</option>");
				}
			}
		});
	});
	function callAjax() {
		var datastring = $('#asset_id').val();
		var subject = $('#subject').val();
		var note = $('#note').val();
		$.ajax({
			type: 'GET',
			url: '/reservation/postrequestreservation',
			data: { 'asset_id': datastring },
			success: function(data) {
				console.log(data);
				location.reload();
			}
		});
	}
	
	function searchAvailableAssets()
	{
		var search_text = $('#search').val();
		$.ajax({
			type: 'GET',
			url: '/reservation/searchAvailableAssets',
			data: { 'text': search_text, 'filter': 'name' },
			success: function(data) {
				$('#search_content tr:not(:first)').remove();
				
				for(var i = 0; i < data.length; i++) {
					$('#search_content').append('<tr><td>' + data[i]['name'] + '</td></tr>');
				}
			}
		});
	}
</script>

<style type="text/css">
	body {
		font-family: Tahoma;
		padding: 0;
		margin: 0;
	}
	
	h1 {
		font-weight: 100;
	}
	
	select {
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
	}
	
	#content {
		margin-left: calc(20vw - 8.5px);
		width: 60vw;
		box-shadow: 6px 0px 17px -5px rgba(0, 0, 0, 0.75), -6px 0px 17px -5px rgba(0, 0, 0, 0.75);
		height: auto;
	}
	
	#titelbar {
		background-color: rgb(229, 229, 229);
		color: white;
		height: 200px;
		line-height: 200px;
		text-align: center;
	}
	
	#titel_text {
		margin-top: 30px;
		font-size: 60px;
	}
	
	#wrapper {
		background-color: rgb(242, 242, 242);
		padding: 20px 15px;
	}
	
	.requested_assets_table_cont {
		width: 90%;
		margin: auto;
		height: 600px;
		-webkit-box-shadow: 0px 0px 25px -5px rgba(0, 0, 0, 0.75);
		-moz-box-shadow: 0px 0px 25px -5px rgba(0, 0, 0, 0.75);
		box-shadow: 0px 0px 25px -5px rgba(0, 0, 0, 0.75);
		overflow-y: scroll;
		background-color: white;
		text-align: center;
	}
	
	.requested_assets_table_cont::-webkit-scrollbar {
		width: 10px;
		margin-right: 5px;
	}
	
	.requested_assets_table_cont::-webkit-scrollbar-thumb {
		background: #EDEDED;
		height: 15px;
	}
	
	.requested_assets_table_cont2 {
		display: inline-block;
		max-width: 80%;
		padding: 10px 0px 10px 0px;
	}
	
	.requested_assets_table {
		width: auto;
		border-collapse: collapse;
	}
	
	.requested_assets_table td {
		border: 1px solid black;
		border-collapse: collapse;
	}
	
	.requested_assets_table th, td {
		padding: 3px 5px 3px 5px;
	}
	
	.submit_btn {
		height: 45px;
		width: 150px;
		text-align: center;
		line-height: 45px;
		color: white;
		background-color: rgb(193, 193, 193);
		cursor: pointer;
		transition: background-color 0.15s ease-in 0s;
	}
	
	.submit_btn:hover {
		background-color: rgb(147, 147, 147);
	}
	
	#submitCont {
		background-color: white;
		width: 50%;
		margin: auto;
		text-align: center;
		border: 2px solid white;
		border-radius: 30px;
		margin-bottom: 30px;
	}
	
	#submitCont .submit_btn {
		margin: auto;
	}
	
	#footer {
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
					<select id="asset_id" name="asset_list">
					</select>
					<label for="subject">Vak</label>
					<input type="text" id="subject" name="subject">
					<label for="note">Extra notities</label>
					<textarea id="note" name="note"></textarea>
					<div class="submit_btn" onclick="callAjax()">Submit</div>
				</form>
			</div>
			<hr>
			
			<h1>Uw aanvragen: </h1>
			
			<div class="requested_assets_table_cont">
				<div class="requested_assets_table_cont2">
					<table id="requested_assets_table" class="requested_assets_table">
						
						<tr>
							<th>Uitlener</th>
							<th>Voorwerp</th>
							<th>Vak</th>
						</tr>
						
						@foreach($userassets as $asset)
							<tr>
								<td>  {{$asset->user->first_name . " ". $asset->user->last_name}}<br></td>
								<td> {{$asset->asset->name}} </td>
								<td> {{ $asset->subject }}</td>
							</tr>
						@endforeach
					
					</table>
				</div>
			</div>
			<hr>
			
			<h1>Beschikbare voorwerpen: </h1>
			<input type="text" id="search" placeholder="Zoeken..">
			<div class="requested_assets_table_cont">
				<div class="requested_assets_table_cont2">
					<table class="requested_assets_table" id="search_content">
						<tr>
							<th>Voorwerp</th>
						</tr>
						
						@foreach($assets as $asset)
							<tr>
								<td> {{$asset->name}} </td>
							</tr>
						@endforeach
		</div>
	</div>
	
	<div id="footer">
		<tekst id="footer_text">Copyright © Groep 11</tekst>
	</div>

</div>