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
              <?php echo form_open('eightyg/update/'.$eightyg_details->id, array('autocomplete' => 'off'));?>
                <div class="card-body"> 
                <div class="row">
<!-- left column -->
<div class="col-md-6">

                <div class="form-group">
                    <label for="exampleInputEmail1">Receipt No<span class="text-red">*</span></label>
                    <?php echo form_input('receipt_no', $eightyg_details->receipt_no, 'class="form-control" required'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Donor Name<span class="text-red">*</span></label>
                    <?php echo form_input('donor_name', $eightyg_details->donor_name, 'class="form-control" required'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">PAN No<span class="text-red">*</span></label>
                    <?php echo form_input('pan_no', $eightyg_details->pan_no, 'class="form-control" required'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email<span class="text-red">*</span></label>
                    <?php echo form_input('email', $eightyg_details->email, 'class="form-control" required'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Sum Monthly Contribution<span class="text-red">*</span></label>
                    <?php echo form_input('sum_monthly_contribution', $eightyg_details->sum_monthly_contribution, 'class="form-control" required'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Transaction Date<span class="text-red">*</span></label>
                    <?php echo form_input('trns_date', date('Y-m-d', strtotime($eightyg_details->trns_date)), 'class="form-control" id="trns_date" autocomplete="off" required'); ?>
                </div>
                    <p class="help-block text-yellow">Date Format:yyyy-mm-dd</p>
                <div class="form-group">
                    <label for="exampleInputEmail1">Ref details</label>
                    <?php echo form_input('ref_details', $eightyg_details->ref_details, 'class="form-control"'); ?>
                </div>

                </div>
                <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">

           
                <div class="form-group">
                    <label for="exampleInputEmail1">Bank</label>
                    <?php echo form_input('bank', $eightyg_details->bank, 'class="form-control"'); ?>
                </div> 
               
                <div class="form-group">
                    <label for="exampleInputEmail1">Address 1</label>
                    <?php echo form_input('address1', $eightyg_details->address1, 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Address 2</label>
                    <?php echo form_input('address2', $eightyg_details->address2, 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">City</label>
                    <?php echo form_input('city', $eightyg_details->city, 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Donation Cause<span class="text-red">*</span></label>
                    <?php echo form_input('donation_cause', $eightyg_details->donation_cause, 'class="form-control" required'); ?>
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