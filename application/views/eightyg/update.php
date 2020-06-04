<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Update 80G</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php if(isset($error)): ?>
            <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
            </div>
            <?php endif; ?>
            <?php echo validation_errors(); ?>
              <?php echo form_open('eightyg/update/'.$eightyg_details->id);?>
                <div class="card-body"> 
                <div class="form-group">
                    <label for="exampleInputEmail1">receipt no</label>
                    <?php echo form_input('receipt_no', $eightyg_details->receipt_no, 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">donor name</label>
                    <?php echo form_input('donor_name', $eightyg_details->donor_name, 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">PAN No</label>
                    <?php echo form_input('pan_no', $eightyg_details->pan_no, 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <?php echo form_input('email', $eightyg_details->email, 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">sum monthly contribution</label>
                    <?php echo form_input('sum_monthly_contribution', $eightyg_details->sum_monthly_contribution, 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">trns date</label>
                    <?php echo form_input('trns_date', date('Y-m-d', strtotime($eightyg_details->trns_date)), 'class="form-control" id="trns_date"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Ref details</label>
                    <?php echo form_input('ref_details', $eightyg_details->ref_details, 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Bank</label>
                    <?php echo form_input('bank', $eightyg_details->bank, 'class="form-control"'); ?>
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