<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php if(isset($error)): ?>
    <div class="alert alert-danger" role="alert">
    <?php echo $error; ?>
    </div>
<?php endif; ?>
<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">              
              <!-- form start -->              
            <?php echo validation_errors(); ?>
              <?php echo form_open('users/updatemypwd/', array('role' => 'form'));?>
                <div class="card-body"> 
                <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <div class="form-group">
                <label>Current Password <span class="text-danger">*</span></label>
                        <?php echo form_password('oldpassword', '', 'class="form-control" required maxlength="50"') ?>
                        <p class="help-block text-yellow">min length:5, max length:50</p>
                </div>
                <div class="form-group">
                <label>New Password <span class="text-danger">*</span></label>
                        <?php echo form_password('password', '', 'class="form-control" required maxlength="50"') ?>
                        <p class="help-block text-yellow">min length:5, max length:50</p>
                </div>               
                <div class="form-group">
                <label>Confirm New Password <span class="text-danger">*</span></label>
                <?php echo form_password('confirmpassword', '', 'class="form-control" required maxlength="50"') ?>
                <p class="help-block text-yellow">min length:5, max length:50</p>
                </div> 
                </div> 
                <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">
           
            </div>
    <!--/.col (right) -->
    </div>
<!-- /.row -->

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <?php echo anchor('welcome', 'Cancel', 'class="btn btn-default"'); ?>
                </div>
              </form>
            </div>
            <!-- /.card -->
    </div>
    <!--/.col (left) -->
</div>
<!-- /.row -->