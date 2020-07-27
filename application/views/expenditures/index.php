
<div class="row"><div class="col-md-12">
<div class="card">
<div class="card-header">
  <?php echo anchor('expenditures/create','<i class="fas fa-plus-square nav-icon"></i> Add New Expenditure', 'class="btn btn-default btn-sm"'); ?>
        </div>
              <!-- /.card-header -->
              <div class="card-body">
              <table class="table table-bordered">
		<tr>
			<th>Expenditure Date</th>
            <th>Donor</th>
            <th>Area</th>
            <th>Nutrition Hygiene Kits</th>
            <th>Meals</th>
            <th>Medical Equipment</th>
            <th>Sanitation Material</th>
            <th>PPE Kits</th>
            <th>Amount Spent</th>
            <th>Actions</th>
</tr>
<?php 
foreach ($view_data as $key => $value) {
	 echo "<tr><td>".date('d-m-Y', strtotime($value['expenditure_dt']))."</td>
        <td>".$value['donor_name']."</td>
        <td>".$value['area_name']."</td>
        <td>".$value['nutrition_hygiene_kit']."</td>
        <td>".$value['meals']."</td>
        <td>".$value['medical_equipment']."</td>
        <td>".$value['sanitation_material']."</td>
        <td>".$value['ppe_kits']."</td>
        <td>".$value['amount_spent']."</td>
        <td>".anchor('expenditures/update/'.$value['expenditure_id'], '<i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="Edit Expenditure"></i>', 'class="mr-1"'). anchor('expenditures/delete/'.$value['expenditure_id'], '<i class="fas fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Delete Expenditure"></i>', '')."</td></tr>";
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