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
              <?php echo form_open('eightyg/create', array('autocomplete' => 'off'));?>
                <div class="card-body"> 
                <div class="row">
            <!-- left column -->
            <div class="col-md-6">

                <div class="form-group">
                    <label for="exampleInputEmail1">Receipt No<span class="text-red">*</span></label>
                    <?php echo form_input('receipt_no', set_value('receipt_no'), 'class="form-control" required'); ?>
                    <p class="help-block text-yellow">Unique</p>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Donor Name<span class="text-red">*</span></label>
                    <?php echo form_input('donor_name', set_value('donor_name'), 'class="form-control" required'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">PAN No<span class="text-red">*</span></label>
                    <?php echo form_input('pan_no', set_value('pan_no'), 'class="form-control" required'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email<span class="text-red">*</span></label>
                    <?php echo form_input('email', set_value('email'), 'class="form-control" required'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Sum Monthly Contribution<span class="text-red">*</span></label>
                    <?php echo form_input('sum_monthly_contribution', set_value('sum_monthly_contribution'), 'class="form-control" required'); ?>
                    <p class="help-block text-yellow">Number with decimal Eg 250.00, 34.70</p>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Transaction Date<span class="text-red">*</span></label>
                    <?php echo form_input('trns_date', set_value('trns_date'), 'class="form-control" id="trns_date" autocomplete="off" required'); ?>
                    <p class="help-block text-yellow">Date Format:yyyy-mm-dd</p>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Ref details<span class="text-red">*</span></label>
                    <?php echo form_input('ref_details', set_value('ref_details'), 'class="form-control" required'); ?>
                </div>

                </div>
                <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">

           
                <div class="form-group">
                    <label for="exampleInputEmail1">Bank</label>
                    <?php echo form_input('bank', set_value('bank'), 'class="form-control"'); ?>
                </div> 
                
                <div class="form-group">
                    <label for="exampleInputEmail1">Address 1</label>
                    <?php echo form_input('address1', set_value('address1'), 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Address 2</label>
                    <?php echo form_input('address2', set_value('address2'), 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">City</label>
                    <?php echo form_input('city', set_value('city'), 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Donation Cause<span class="text-red">*</span></label>
                    <?php echo form_input('donation_cause', set_value('donation_cause'), 'class="form-control" required'); ?>
                </div> 
</div>
    <!--/.col (right) -->
    </div>
<!-- /.row -->

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