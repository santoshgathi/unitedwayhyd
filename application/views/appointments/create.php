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
                    <label for="expenditure_dt">Date</label>
                    <input type="text" class="form-control" id="appointmentdt" placeholder="Select Date" name="appointmentdt" autocomplete="off" required>
                  </div>                  
                  <div class="form-group">
                    <label for="exampleInputPassword1">Purpose</label>
                    <input type="text" class="form-control" id="purpose" placeholder="Enter Purpose" name="purpose">
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