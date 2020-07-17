<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
              <!-- /.card-header -->
              <!-- form start -->              
            <?php echo validation_errors(); ?>
              <?php echo form_open('expenditures/delete/'.$exp_details->expenditure_id, array('role' => 'form'));?>
                <div class="card-body"> 
                <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                <div class="form-group">
                <label>Confirm <span class="text-danger">*</span></label>
                        <select class="form-control" name="confirm">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                </div> 
                </div>
                <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">
            <dl>
                <dt>Date</dt>
                <dd><?php echo $exp_details->expenditure_dt; ?></dd>
                <dt>Donor Name</dt>
                <dd><?php echo $exp_details->donor_name; ?></dd>
                <dt>Area</dt>
                <dd><?php echo $exp_details->area_name; ?></dd>
              </dl>
</div>
    <!--/.col (right) -->
    </div>
<!-- /.row -->

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <?php echo anchor('eightyg', 'Cancel', 'class="btn btn-default"'); ?>
                </div>
              </form>
            </div>
            <!-- /.card -->
    </div>
    <!--/.col (left) -->
</div>
<!-- /.row -->