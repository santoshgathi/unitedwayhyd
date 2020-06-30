<?php if($user_role == "admin"): ?>
<!-- Info boxes -->
<div class="row">
          
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Donors</span>
                <span class="info-box-number"><?php echo $total_donors; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
     <!-- /.Info boxes -->   
     <?php endif; ?>



         <!-- Main row -->
         <div class="row">
         <?php if($user_role == "admin"): ?>
            <!-- Left col -->
            <div class="col-md-8">
                <!-- TABLE: today_appointments -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">today appointments</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Date</th>
                      <th>User</th>
                      <th>Visit Purpose</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
foreach ($today_appointments as $key => $value) {
	 echo "<tr><td>".date('d-m-Y', strtotime($value->appointment_date))."</td>
        <td>".$value->username."</td>
        <td>".$value->visit_purpose."</td></tr>";
}
?>
                  
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
             
            </div>
            <!-- /.card -->
            </div>
          <!-- /.left col -->
          <?php endif; ?>

          <!-- right col -->
          <div class="col-md-4">
              <!-- PRODUCT LIST -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Week appointments</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">


              <table class="table table-bordered">
		<tr>
			<th>date</th>
            <th>Count</th>
</tr>
<?php 
foreach ($week_appointments as $key => $value) {
	 echo "<tr><td>".date('d-m-Y', strtotime($key))."</td>
        <td>".$value."</td></tr>";
}
?>

</table>
               
              </div>
              <!-- /.card-body -->
             
            </div>
            <!-- /.card -->
          </div>
          <!-- /.right col -->
</div>
        <!-- /.row -->
     <!-- /.Main boxes --> 
	  