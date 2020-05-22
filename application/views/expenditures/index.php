
<div class="row"><div class="col-md-12">
<div class="card">
              <!-- <div class="card-header">
                <h3 class="card-title">Bordered Table</h3>
              </div> -->
              <!-- /.card-header -->
              <div class="card-body">
              <table class="table table-bordered">
		<tr>
			<th>Expenditure date</th>
            <th>Donor</th>
            <th>Area</th>
            <th>nutrition hygiene kit</th>
            <th>meals</th>
            <th>medical equipment</th>
            <th>sanitation material</th>
            <th>ppe kits</th>
            <th>amount spent</th>
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
        <td>".anchor('expenditures/update/'.$value['expenditure_id'], 'edit', '')."</td></tr>";
}
?>

</table>
</div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">«</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">»</a></li>
                </ul>
              </div>
            </div>
            </div>    </div>