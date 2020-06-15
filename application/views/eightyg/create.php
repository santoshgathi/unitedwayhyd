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
                    <label for="exampleInputEmail1">receipt no</label>
                    <?php echo form_input('receipt_no', set_value('receipt_no'), 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">donor name</label>
                    <?php echo form_input('donor_name', set_value('donor_name'), 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">PAN No</label>
                    <?php echo form_input('pan_no', set_value('pan_no'), 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <?php echo form_input('email', set_value('email'), 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">sum monthly contribution</label>
                    <?php echo form_input('sum_monthly_contribution', set_value('sum_monthly_contribution'), 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">trns date</label>
                    <?php echo form_input('trns_date', set_value('trns_date'), 'class="form-control" id="trns_date" autocomplete="off" required'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Ref details</label>
                    <?php echo form_input('ref_details', set_value('ref_details'), 'class="form-control"'); ?>
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
                    <label for="exampleInputEmail1">amount in words</label>
                    <?php echo form_input('amount_in_words', set_value('amount_in_words'), 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">address 1</label>
                    <?php echo form_input('address1', set_value('address1'), 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">address 2</label>
                    <?php echo form_input('address2', set_value('address2'), 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">City</label>
                    <?php echo form_input('city', set_value('city'), 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Donation Cause</label>
                    <?php echo form_input('donation_cause', set_value('donation_cause'), 'class="form-control"'); ?>
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