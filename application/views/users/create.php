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
              <?php echo form_open('users/create'); ?>
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <?php echo form_input('username','', 'class="form-control"'); ?>
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <?php echo form_input('password','', 'class="form-control"'); ?>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Full Name</label>
                    <?php echo form_input('full_name','', 'class="form-control"'); ?>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Role</label>
                    <?php echo form_dropdown('user_role',array('admin'=>'admin','employee'=>'employee' ), '', 'class="form-control"');?>
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