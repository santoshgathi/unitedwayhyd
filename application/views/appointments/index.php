
<div class="row"><div class="col-md-12">
<div class="card">
              <!-- <div class="card-header">
                <h3 class="card-title">Bordered Table</h3>
              </div> -->
              <!-- /.card-header -->
              <div class="card-body">
              <table class="table table-bordered">
		<tr>
			<th>Appointment date</th>
            <th>Name</th>
            <th>Email</th>
            <th>Purpose of visit</th>
           
<?php 
foreach ($view_data as $key => $value) {

	 echo "<tr><td>".date('d-m-Y', strtotime($value['appointment_date']))."</td>
        <td>".$value['appointment_name']."</td>
        <td>".$value['appointment_email']."</td>
        <td>".$value['visit_purpose']."</td></tr>";
    
        
     
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