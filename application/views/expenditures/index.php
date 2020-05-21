
<div class="row"><div class="col-md-12">
<div class="card">
              <!-- <div class="card-header">
                <h3 class="card-title">Bordered Table</h3>
              </div> -->
              <!-- /.card-header -->
              <div class="card-body">
	<table id="customers">
		<tr>
            
		
			<th>Expenditure date</th>
            <th>Donor_id</th>
            <th>Area_id</th>
            <th>nutrition_hygiene_kit</th>
            <th>meals</th>
            <th>medical_equipment</th>
            <th>sanitation_material</th>
            <th>ppe_kits</th>
            <th>amount_spent</th>
            <th>Actions</th>
</tr>
<?php 
foreach ($view_data as $key => $value) {
	

	 echo "<tr>
	 	
	 	<td>".date('d-m-Y', strtotime($value['expenditure_dt']))."</td>
        <td>".$value['donor_id']."</td>
        <td>".$value['area_id']."</td>
        <td>".$value['nutrition_hygiene_kit']."</td>
        <td>".$value['meals']."</td>
        <td>".$value['medical_equipment']."</td>
        <td>".$value['sanitation_material']."</td>
        <td>".$value['ppe_kits']."</td>
        <td>".$value['amount_spent']."</td>
        <td>".anchor('expenditures/update/'.$value['expenditure_id'], 'edit', '')."</td>

      



	 </tr>";
	# code...
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