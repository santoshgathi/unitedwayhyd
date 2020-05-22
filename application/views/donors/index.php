
<div class="row"><div class="col-md-12">
<div class="card">
              <!-- <div class="card-header">
                <h3 class="card-title">Bordered Table</h3>
              </div> -->
              <!-- /.card-header -->
              <div class="card-body">
	<table class="table table-bordered">
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
</div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
               
              </div>
            </div>
            </div>    </div>