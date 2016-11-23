<h1>Lijst van ongeassigneerde assets: </h1>

<table>
<tr>
	<th>ID</th>
    <th>Naam van de asset</th>
    <th>Asset Tag</th> 
    <th>Serial</th>
    <th>Assigned to</th>

  </tr>
@foreach($assets as $asset)
  <tr> 
   <td> {{$asset->id}} <br> </td>
  <td> {{$asset->name}} <br> </td>
  <td> {{$asset->asset_tag}} <br>  </td>
  <td> {{$asset->serial}} <br>  </td> 
  <td> <?php if($asset->assigned_to == null){echo "Beschikbaar";}else {echo "Assigned aan user met ID ".$asset->assigned_to;}?> <br>  </td> 
  </tr>
  @endforeach

  </table>