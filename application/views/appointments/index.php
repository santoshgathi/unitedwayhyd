
<div class="row"><div class="col-md-12">
<div class="card">
<div class="card-header">
			  <?php echo anchor('appointments/create','<i class="fas fa-plus-square nav-icon"></i> Add New Appointment', 'class="btn btn-default btn-sm"'); ?>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table class="table table-bordered">
		<tr>
			<th>Appointment date</th>
            <th>Name</th>
            <th>Purpose of visit</th>
            <th>Approval Status</th>
            <th>created on</th>
            <?php if($user_role == "admin") {echo '<th>Actions</th>';} ?>
            </tr>
<?php 
foreach ($view_data as $key => $value) {

	 echo "<tr><td>".date('d-m-Y', strtotime($value['appointment_date']))."</td>";
   echo "<td>".$value['username']."</td>";
   echo "<td>".$value['visit_purpose']."</td>";
   echo "<td>".$value['approval']."</td>";
   echo "<td>".$value['created_on']."</td>";   
   if($user_role == "admin") {echo "<td>".anchor('appointments/approve/'.$value['appointment_id'], '<i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="Edit Appointment"></i>', 'class="mr-1"')."</td>";}
   echo "</tr>"; 
}
?>

</table>
</div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                <?php echo $this->pagination->create_links();?>
                </ul>
              </div>
            </div>
            </div>    </div>