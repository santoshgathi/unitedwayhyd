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
              <!-- <div class="card-header">
                <h3 class="card-title">Update 80G</h3>
              </div> -->
              <!-- /.card-header -->
              <!-- form start -->              
            <?php echo validation_errors(); ?>
              <?php echo form_open('eightyg/delete/'.$eightyg_details->id, array('role' => 'form'));?>
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
                <dt>Receipt No</dt>
                <dd><?php echo $eightyg_details->receipt_no; ?></dd>
                <dt>Donor Name</dt>
                <dd><?php echo $eightyg_details->donor_name; ?></dd>
                <dt>Email</dt>
                <dd><?php echo $eightyg_details->email; ?></dd>
                <dt>Sum Monthly Contribution</dt>
                <dd><?php echo $eightyg_details->sum_monthly_contribution; ?></dd>
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