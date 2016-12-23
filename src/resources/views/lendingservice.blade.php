<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		$('#search').change(function () {
			searchAvailableAssets();
		});
		
		$.ajax({
			type: 'GET',
			url: '/package/initdoclendservice',
			data: "",
			success: function(data) {
				console.log(data);
				for(var i = 0; i < data[0].length; i++) {
					$('#asset_id').append("<option value=" + data[0][i][0] + ">" + data[0][i][1] + "</option>");
				}
				for(var i = 0; i < data[1].length; i++) {
					$('#user_id').append("<option value=" + data[1][i][0] + ">" + data[1][i][1] + "</option>");
				}
			}
		});
	});
	function ajaxLenService() {
		var asset_id = $('#asset_id').val();
		var asset_tag = $('#asset_tag').val();
		var asset_action = $('#asset_action').val();
		var user_id = $('#user_id').val();
		var expected_checkin = $('#expected_checkin').val();
		console.log("Function works");
		$.ajax({
			type: 'GET',
			url: '/package/lsaction',
			data: { 'asset_id': asset_id, 'asset_tag': asset_tag, 'asset_action': asset_action, 'user_id': user_id },
			success: function(data) {
				alert(data);
				location.reload();
			}
		});
	}

	function searchAvailableAssets()
	{
		var search_text = $('#search').val();
		var filter = $('#filter input:checked').val();
		$.ajax({
			type: 'GET',
			url: '/reservation/searchAvailableAssets',
			data: { 'text': search_text, 'filter': filter },
			success: function(data) {
				$('#search_content tr:not(:first)').remove();

				for(var i = 0; i < data.length; i++) {
					$('#search_content').append('<tr><td>' + data[i]['id'] + '</td><td>' + data[i]['name'] + '</td><td>' + data[i]['asset_tag'] + '</td><td>' + data[i]['serial'] + '</td></tr>');
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
			<tekst id="titel_text">Uitleendienst</tekst>
		</div>
		<div id="wrapper">
			<div id="submitCont">
				<h1>Voorwerp aanpassen</h1>
				<p>Selecteer de actie die u wilt uitvoeren op een voorwerp</p>
				
				<script>
					//function ChooseAsset(data) {
					//document.getElementById("asset_tag").value = data.value;}
					$('select').on('change', function() {
						$("select option:selected").each(function() {
							$('#asset_tag').val('$' + $(this).attr('asset_id'));
						})
					})
				</script>
				
				
				<form id="submitForm">
					{{ csrf_field() }}
					<div style="width: auto; Margin-left: 0; Margin-right: auto;">
						<label>Asset: </label>
						<select id="asset_id"></select>
						<br><br>
						<label>Asset Tag</label>
						<input type="text" id="asset_tag" autofocus>
						<br><br>
						<label style="margin-left: 0px;">Action: </label>
						<select id="asset_action">
							<option></option>
							<option value="checkout">Check-out</option>
							<option value="checkin">Check-in</option>
						</select>
						<br><br>
						<label style="margin-left: 0px;">For user: </label>
						<select id="user_id"></select>
					
					</div>
					<br> <br>
					<button class="submit_btn" onclick="ajaxLenService()" type="submit">Submit</button>
				</form>
			</div>
			<hr>
			
			<h1>Beschikbare voorwerpen: </h1>
			<input type="text" id="search" placeholder="Zoeken">
			<form id="filter">
				<label>Filteren op:</label>
				<input type="radio" value="id">ID<br>
				<input type="radio" value="name" checked>Naam<br>
				<input type="radio" value="asset_tag">Tag<br>
				<input type="radio" value="serial">Serienummer<br>
			</form>
			<div class="requested_assets_table_cont">
				<div class="requested_assets_table_cont2">
					<table class="requested_assets_table" id="search_content">
						<tr>
							<th>ID</th>
							<th>Voorwerp</th>
							<th>Tag</th>
							<th>Serienummer</th>
						</tr>
						
						@foreach($assets as $asset)
							<tr>
								<td> {{$asset->id}} <br></td>
								<td> {{$asset->name}} <br></td>
								<td> {{$asset->asset_tag}} <br></td>
								<td> {{$asset->serial}} <br></td>
							
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