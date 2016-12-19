<head>
	<title>Reservaties Configuratie</title>
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/reservation.css') }}">
</head>

<body>
	<div id="page_body">
		<div id="content">
			<div id="titelbar">
				<tekst id="titel_text">Configuratie</tekst>
			</div>
			<div id="wrapper">
				<div class="requested_assets_table_cont">
					<div class="requested_assets_table_cont2">
						<table class="requested_assets_table">
							<tr>
								<th>Optie</th>
								<th>Waarde</th>
								<th>Beschrijving</th>
							</tr>
							
							@foreach($config->getParsedConfig() as $option => $value)
								<tr>
									<td> {{ $option }} </td>
									<td> <input type="text" value="{{ $value }}"> </td>
									<td> {{ $config->getDescription($option) }}</td>
								</tr>
							@endforeach
						
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>