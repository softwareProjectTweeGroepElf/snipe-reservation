
{{$succes or ""}}{{$failed or ""}}
<h1>Request a loan:</h1>
Only use legitimate asset ID's
<br>
<br>
<br>
<form method="POST" action="students">
     {{ csrf_field() }}
  <label>Asset ID</label>
  <input type="text" name="asset_id">
  <br>
  <br>
  <input type="submit" name="submit" value="Submit">
</form>
<hr>
<h1>List of your requests: </h1>
<table>
<tr>
  <th>User ID</th>
  <th>Asset ID</th>
  <th>User name</th>
   <th>Asset name</th>
  </tr>
@foreach($Rassets as $asset)
  <tr> 
   <td> {{$asset->user_id}} <br> </td>
   <td> {{$asset->asset_id}} <br> </td>
   <td> {{$asset->name}} <br> </td>
  <td> {{$asset->Aname}} <br> </td>
  </tr>
  @endforeach

  </table>
<br>
<hr>
<h1>List of available assets: </h1>
<table>
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
  <td> <?php if($asset->assigned_to == null){echo "available";}else {echo "Assigned to user with ID ".$asset->assigned_to;}?> <br>  </td> 
  </tr>
  @endforeach

  </table>