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
			<th>Areas</th>
			<th>Action</th>
        </tr>
		
		
<?php 
foreach ($areas as $are) {
	

	 echo "<tr>
	 	<td>".$are['area_name']."</td>
		<td>".anchor('areas/edit/'.$are['area_id'], 'edit', '')."</td>
	    </tr>";
}
?>	
</table>

</body>
</html>

