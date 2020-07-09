<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">
              <!-- form start -->
              <?php echo validation_errors(); ?>
              <?php echo form_open('donors/create'); ?>
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Donor Name<span class="text-red">*</span></label>
                    <?php echo form_input('Donorname', set_value('Donorname'), 'class="form-control" required placeholder="Enter Donor Name" size="100"'); ?>
                    <p class="help-block text-yellow">Unique, only alpha spaces allowed, min length:3, max length:100</p>
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputPassword1">Phone</label>
                    <?php echo form_input('Pho', set_value('Pho'), 'class="form-control"  placeholder="Enter Phone No" size="50"'); ?>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Email</label>
                    <?php echo form_input('email', set_value('email'), 'class="form-control"  placeholder="Enter Email" size="150"'); ?>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Address</label>
                    <?php echo form_textarea('address', set_value('address'), 'class="form-control" id="address" placeholder="Enter Address" size="255"'); ?>
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