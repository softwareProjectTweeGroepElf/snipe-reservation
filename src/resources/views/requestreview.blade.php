<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script>
	function submitAccptAjax(asset_id, user_id) {
		console.log(asset_id);
		$.ajax({
			type: 'GET',
			url: '/reservation/postreservation',
			data: { 'req_asset_id': asset_id, 'req_user_id': user_id },
			success: function(data) {
				alert("Reservation was added succesfully");
				console.log(data);
				location.reload();
			}
		});
	}
	function submitRjctAjax(asset_id, user_id) {
		$.ajax({
			type: 'GET',
			url: '/reservation/rejectreservation',
			data: { 'req_asset_id': asset_id, 'req_user_id': user_id },
			success: function(data) {
				alert("Reservation was rejected succesfully");
				console.log(data);
				location.reload();
			}
		});
	}

	function sendEmail(asset_id, user_id, decision) {
		$.ajax({
			type: 'GET',
			url: '/decision',
			data: { 'req_asset_id': asset_id, 'req_user_id': user_id, 'req_decision': decision },
			success: function(res) {
				console.log(res);
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
		margin-top: 0;
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
		padding: 20px 20px 50px 20px;
		margin 0;
	}
	
	.requested_assets_table_cont {
		width: 85%;
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
		text-align: center;
		display: inline-block;
		max-width: 80%;
		padding: 10px 0px 10px 0px;
	}
	
	.accepted_or_rejected {
		width: 70px;
	}
	
	#accepted_or_rejected_td {
		border: 1px solid white;
		border-collapse: collapse;
	}
	
	#select_td_id {
		margin-left: 100px;
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
		text-align: center;
		padding: 30px 0px 30px 0px;
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
	
	.no_padding_td {
		padding: 0px;
	}
</style>

<div id="page_body">
	<div id="content">
		<div id="titelbar">
			<tekst id="titel_text">Professors Page</tekst>
		</div>
		<div id="wrapper">
			<div id="result_text"></div>
			<h1>List of the students' requests: </h1>
			<div class="requested_assets_table_cont">
				<div class="requested_assets_table_cont2">
					<table id="requested_assets_table" class="requested_assets_table">
						<tr>
							<th>Aanvrager</th>
							<th>Voorwerp</th>
							<th>Vak</th>
							<th>Notities</th>
						</tr>
						@foreach($requestedassets as $asset)
							<tr>
								<div id="buttons_accept_reject">
									<td> {{$asset->user->first_name . ' ' . $asset->user->last_name}} </td>
									<td> {{$asset->asset->name}} </td>
									<td> {{$asset->subject}}</td>
									<td> {{$asset->note}}</td>
									<td class="no_padding_td">
										<button class="submit_btn"
											 onclick="submitAccptAjax({!!$asset->asset_id!!},{!!$asset->user_id!!});sendEmail({!!$asset->asset_id!!},{!!$asset->user_id!!},{!! "accepted" !!})">
											Accept
										</button>
									</td>
									<td class="no_padding_td">
										<button class="submit_btn"
											 onclick="submitRjctAjax({!!$asset->asset_id!!},{!!$asset->user_id!!});sendEmail({!!$asset->asset_id!!},{!!$asset->user_id!!},{!! "denied" !!})">
											Reject
										</button>
									</td>
								</div>
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