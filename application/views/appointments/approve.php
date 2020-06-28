<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">
              <!-- <div class="card-header">
                <h3 class="card-title">Add New Donor</h3>
              </div> -->
         
              <!-- /.card-header -->
              <!-- form start -->
              <?php echo validation_errors(); ?>
              <?php echo form_open('appointments/approve/'.$appointment_details->appointment_id); ?>
                <div class="card-body">
                <div class="form-group">
                    <label for="donor_name">Date</label>
                    <?php echo form_input('appointment_date',$appointment_details->appointment_date, 'class="form-control" disabled'); ?>
                </div>
                <div class="form-group">
                    <label for="donor_name">User</label>
                    <?php echo form_input('username',$appointment_details->username, 'class="form-control" disabled'); ?>
                </div>   
                <div class="form-group">
                    <label for="donor_name">Purpose</label>
                    <?php echo form_input('visit_purpose',$appointment_details->visit_purpose, 'class="form-control" disabled'); ?>
                </div>           
                <div class="form-group">
                    <label for="exampleInputEmail1">Approve</label>
                    <?php echo form_dropdown('approve',array('yes'=>'Yes'), '', 'class="form-control"');?>
                  </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
    </div>
    <!--/.col (left) -->
</div>
<!-- /.row -->