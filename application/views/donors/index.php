
<div class="row"><div class="col-md-12">
<div class="card">
<div class="card-header">
  <?php echo anchor('donors/create','<i class="fas fa-plus-square nav-icon"></i> Add New Donor', 'class="btn btn-default btn-sm"'); ?>
        </div>
              <!-- /.card-header -->
              <div class="card-body">
	<table class="table table-bordered table-sm">
		<tr>
			<th>Donor Name</th>
			<th>Phone</th><th>Email</th><th>Address</th>
			<th>Actions</th>
</tr>
<?php 
foreach ($view_data as $key => $value) {
	

	 echo "<tr>
	 	<td>".$value['donor_name']."</td>
		 <td>".$value['donor_phone']."</td><td>".$value['email']."</td><td>".$value['address']."</td>
		<td>".anchor('donors/update/'.$value['donor_id'], '<i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="Edit Donor"></i>', 'class="mr-1"')."</td>

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