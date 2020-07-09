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
              <!-- <div class="card-header">
                <h3 class="card-title">Update 80G</h3>
              </div> -->
              <!-- /.card-header -->
              <!-- form start -->              
            <?php echo validation_errors(); ?>
              <?php echo form_open('users/updateuserpwd/'.$user_details->id, array('role' => 'form'));?>
                <div class="card-body"> 
                <div class="row">
<!-- left column -->
<div class="col-md-6">

                <div class="form-group">
                <label>New Password <span class="text-danger">*</span></label>
                        <?php echo form_input('newpwd','', 'size="50" required class="form-control" id="newpwd"'); ?>
                        <p class="help-block text-yellow">min length:5, max length:50</p>
                </div>               

                </div>
                <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">
            <dl>
                <dt>Username</dt>
                <dd><?php echo $user_details->username; ?></dd>
                <dt>Email</dt>
                <dd><?php echo $user_details->email; ?></dd>
              </dl>
</div>
    <!--/.col (right) -->
    </div>
<!-- /.row -->

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <?php echo anchor('users', 'Cancel', 'class="btn btn-default"'); ?>
                </div>
              </form>
            </div>
            <!-- /.card -->
    </div>
    <!--/.col (left) -->
</div>
<!-- /.row -->