<?php

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<style>
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
</style>
<body>
	<table id="customers">
		<tr>
			<th>id</th>
			<th>Donorname</th>
			<th>Phno</th>
			<th>Actions</th>
</tr>
<?php 
foreach ($view_data as $key => $value) {
	

	 echo "<tr>
	 	<td>".$value['donor_id']."</td>
	 	<td>".$value['donor_name']."</td>
		 <td>".$value['donor_phone']."</td>
		<td>".anchor('donors/update/'.$value['donor_id'], 'edit', '')."</td>

	 </tr>";
	# code...
}
?>

</table>

</body>
</html>

<?php 
// echo "<pre>";
// print_r($user);
// echo "<pre>";
 ?>