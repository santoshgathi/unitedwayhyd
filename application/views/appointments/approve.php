<div class="row">
    <!-- left column -->
    <div class="col-md-12">
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
                <div class="row">
                 <!-- left column -->
                <div class="col-md-6">
                <div class="form-group">
                    <label for="donor_name">Date</label>
                    <?php echo form_input('appointment_date',$appointment_details->appointment_date, 'class="form-control" readonly'); ?>
                </div>          
                <div class="form-group">
                    <label for="exampleInputEmail1">Approve<span class="text-red">*</span></label>
                    <?php echo form_dropdown('approval_status',array('yes'=>'Yes','no'=>'No'), '', 'class="form-control"');?>
                  </div>
                  <div class="form-group">
                    <label for="donor_name">Comment</label>
                    <?php echo form_textarea('approval_comment','', 'class="form-control"'); ?>
                    <p class="help-block text-yellow">max length:255</p>
                    </div>
                    </div>
                  <!--/.col (left) -->
                  <!-- right column -->
                <div class="col-md-6">
                        <dl>
                            <dt>Date</dt>
                            <dd><?php echo $appointment_details->appointment_date; ?></dd>
                            <dt>Username</dt>
                            <dd><?php echo $appointment_details->username; ?></dd>
                            <dt>Purspose</dt>
                            <dd><?php echo $appointment_details->visit_purpose; ?></dd>
                            <dt>Created On</dt>
                            <dd><?php echo $appointment_details->created_on; ?></dd>
                          </dl>
                </div>
                <!--/.col (right) -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
    </div>
    <!--/.col 12 -->    

</div>
<!-- /.row -->