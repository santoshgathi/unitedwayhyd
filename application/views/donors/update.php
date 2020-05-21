<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Update Donors</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php if(isset($error)): ?>
            <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
            </div>
            <?php endif; ?>
            <?php echo validation_errors(); ?>
              <?php echo form_open('donors/update/'.$donor_details->donor_id);?>
                <div class="card-body"> 
                <div class="form-group">
                    <label for="exampleInputEmail1">Donor Name</label>
                    <?php echo form_input('donor_name',$donor_details->donor_name, 'class="form-control"'); ?>
                </div>
              
              
                <div class="form-group">
                    <label for="exampleInputEmail1">Phone number</label>
                    <?php echo form_input('phone_number', $donor_details->donor_phone, 'class="form-control"'); ?>
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