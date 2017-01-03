<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		$('#search').change(function () {
			searchAvailableAssets();
		});
		
		 $.ajax({
            type: 'GET',
            url: '/reservation/initdoclendservice',
            data: "",
            success:function(data){
                for (var i = 0; i < data['assets'].length; i=i+2) {
                    $('#asset_id').append("<option value=" + data['assets'][i] + ">" + data['assets'][i+1] + "</option>");
                }
                for (var i = 0; i < data['users'].length; i=i+2) {
                    $('#user_id').append("<option value=" + data['users'][i] + ">" + data['users'][i+1] + "</option>");
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
			url: '/reservation/lsaction',
			data: { 'asset_id': asset_id, 'asset_tag': asset_tag, 'asset_action': asset_action, 'user_id': user_id },
			success: function(data) {
				alert(data);
				// location.reload();
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
<link rel="stylesheet" type="text/css" href="{{ URL::asset('reservation/css/reservation.css') }}">
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
					$('select').on('change', function() {
						$("select option:selected").each(function() {
							$('#asset_tag').val('$' + $(this).attr('asset_id'));
						})
					})
				</script>		
				<form id="submitFormLen">
					{{ csrf_field() }}
					<table>
						<tr>
							<th>
								<label>Product: </label>
							</th>
							<th>
								<select id="asset_id"></select>
							</th>
						</tr>
						<tr>
							<th>
								<label>Product Tag:</label>
							</th>
							<th>
								<input type="text" id="asset_tag" autofocus>
							</th>
						</tr>
						<tr>
							<th>
								<label style="margin-left: 0px;">Actie: </label>
							</th>
							<th>
								<select id="asset_action" class="formWidthLen">
									<option></option>
									<option value="checkout">Check-out</option>
									<option value="checkin">Check-in</option>
								</select>
							</th>
						</tr>
	
						<tr>
							<th>
								<label style="margin-left: 0px;">Gebruiker: </label>
							</th>
							<th>
								<select id="user_id" class="formWidthLen"></select>
							</th>
						</tr>
					</table>
					<br>
					<button class="submit_btn" onclick="ajaxLenService()" type="submit">Submit</button>
					<br><br>
				</form>
			</div>
			<hr>
			
			<h1>Beschikbare voorwerpen: </h1>
			<div id="submitFormSearchLen">
				<b>Zoek specifiek product op een filter:</b><br>
				<input type="text" id="search" placeholder="Zoeken"><br>
				<form id="filter">
					<label>Filteren op:</label><br>
					<input type="radio" value="id" name="filter">ID<br>
					<input type="radio" value="name" name="filter">Naam<br>
					<input type="radio" value="asset_tag" name="filter">Tag<br>
					<input type="radio" value="serial" name="filter">Serienummer<br>
				</form>
			</div>
			<br><br>
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