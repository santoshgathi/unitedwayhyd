<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">
              <!-- <div class="card-header">
                <h3 class="card-title">Update Donors</h3>
              </div> -->
              <!-- /.card-header -->
              <!-- form start -->
              <?php if(isset($error)): ?>
            <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
            </div>
            <?php endif; ?>
            <?php echo validation_errors(); ?>
              <?php echo form_open('users/update/'.$user_details->id);?>
                <div class="card-body">
                <div class="form-group">
                    <label for="donor_name">Username</label>
                    <?php echo form_input('username',$user_details->username, 'class="form-control" disabled'); ?>
                </div>
                <div class="form-group">
                    <label for="donor_name">Full Name</label>
                    <?php echo form_input('full_name',$user_details->full_name, 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Email</label>
                    <?php echo form_input('email',$user_details->email, 'class="form-control" required'); ?>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Status</label>
                    <?php echo form_dropdown('status',array('0'=>'Inactive','1'=>'Active' ), $user_details->status, 'class="form-control"');?>
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