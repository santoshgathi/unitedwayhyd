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
                    <label for="exampleInputEmail1">Username<span class="text-red">*</span></label>
                    <?php echo form_input('username','', 'class="form-control" required size="25"'); ?>
                    <p class="help-block text-yellow">Unique, only alpha numeric allowed, min length:5, max length:25</p>
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password<span class="text-red">*</span></label>
                    <?php echo form_input('password','', 'class="form-control" required size="50"'); ?>
                    <p class="help-block text-yellow">min length:5, max length:50</p>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Full Name<span class="text-red">*</span></label>
                    <?php echo form_input('full_name','', 'class="form-control" required size="150"'); ?>
                    <p class="help-block text-yellow">Unique, only alpha spaces allowed, min length:5, max length:150</p>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Email<span class="text-red">*</span></label>
                    <?php echo form_input('email','', 'class="form-control" required size="150"'); ?>
                    <p class="help-block text-yellow">Unique, Valid Email address, min length:5, max length:150</p>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Role<span class="text-red">*</span></label>
                    <?php echo form_dropdown('user_role',array('admin'=>'admin','employee'=>'employee' ), '', 'class="form-control" required');?>
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