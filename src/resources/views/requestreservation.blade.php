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
			data: { 'asset_id': datastring, 'subject': subject, 'note': note},
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
				$('#p_resultsLookup').empty();
				$('#p_resultsLookup').append(data.length);
			}
		});
	}
</script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('reservation/css/reservation.css') }}">
<div id="page_body">
	<div id="content">
		<div id="titelbar">
			<tekst id="titel_text">Students Page</tekst>
		</div>
		<div id="wrapper">
			<div id="submitCont">
				<h1>Product aanvragen:</h1>
				<p>Selecteer het product dat je wil lenen:</p>
				
				<form id="submitForm">
					{{ csrf_field() }}
					<table id="submitTable">
						<tr>
							<th><label>Asset: </label></th>
							<th><select id="asset_id">
							<option value="" disabled selected>Selecteer hier je product</option>
							</select><br></th>
						</tr>
						<tr>
							<th><label for="subject">Vak:</label></th>
							<th><input type="text" id="subject" placeholder="Het vak"><br></th>
						</tr>
						<tr>
							<th><label for="note">Opmerkingen:</label></th>
							<th><textarea id="note" placeholder="Beschrijf wat je ermee wilt presteren"></textarea></th>
						</tr>
					</table>
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
							<th>Notitie</th>
						</tr>
						
						@foreach($userassets as $asset)
							<tr>
								<td> {{$asset->user->first_name . " ". $asset->user->last_name}}<br></td>
								<td> {{$asset->asset->name}} </td>
								<td> {{$asset->subject}}</td>
								<td> {{$asset->note}}</td>
							</tr>
						@endforeach
					
					</table>
				</div>
			</div>
			<hr>
			
			<h1>Beschikbare voorwerpen: </h1>
			
			<table id="lookupTable">
				<th>
					<div id="studentZoekForm">
						<p>Zoek specifiek product op naam:</p>
						<input type="text" id="search" placeholder="Zoeken..">
					</div>
				</th>
				<th>
					<div id="resultsLookup">
						<p>Aantal producten:</p>
						<div id="p_resultsLookup">{{count($assets)}}</div>
					</div>
				</th>
			</table>
			
			<br><br>
			
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
					</table>
				</div>
			</div>
		</div>
	</div>
	<div id="footer">
		<tekst id="footer_text">Copyright © Groep 11</tekst>
	</div>

</div>
