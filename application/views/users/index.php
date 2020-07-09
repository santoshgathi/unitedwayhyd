
<div class="row">
<div class="col-md-12">
<div class="card">
              <div class="card-header">
			  <?php echo anchor('users/create','<i class="fas fa-plus-square nav-icon"></i> Add New User', 'class="btn btn-default btn-sm"'); ?>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
	<table class="table table-bordered table-sm">
		<tr>
			<th>Username</th>
			<th>Full Name</th><th>Email</th>
			<th>Status</th><th>Created On</th>
			<th>Actions</th>
</tr>
<?php 
foreach ($view_data as $key => $value) {
	

	 echo "<tr>
	 	<td>".$value['username']."</td><td>".$value['full_name']."</td><td>".$value['email']."</td>
		 <td>".(($value['status'])?'Active':'Inactive')."</td>
		 <td>".$value['created_on']."</td>
		<td>".anchor('users/update/'.$value['id'], '<i class="fas fa-edit" data-toggle="tooltip" title="Edit User"></i>', 'class="mr-1"').anchor('users/updateuserpwd/'.$value['id'], '<i class="fas fa-key" data-toggle="tooltip" title="Update Password"></i>', 'class="mr-1"')."</td>

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