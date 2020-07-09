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
              <?php echo form_open('appointments/create'); ?>
                <div class="card-body">
                <div class="form-group">
                    <label for="expenditure_dt">Date<span class="text-red">*</span></label>
                    <?php echo form_input('appointmentdt', set_value('appointmentdt'), 'class="form-control" id="appointmentdt" placeholder="Select Date" autocomplete="off" required size="10"'); ?>
                    <p class="help-block text-yellow">Date Format:yyyy-mm-dd</p>
                  </div>                  
                  <div class="form-group">
                    <label for="exampleInputPassword1">Purpose<span class="text-red">*</span></label>
                    <?php echo form_textarea('purpose', set_value('purpose'), 'class="form-control" id="purpose" placeholder="Enter Purpose" size="255"'); ?>
                    <p class="help-block text-yellow">min length:5, max length:255</p>
                  </div>
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