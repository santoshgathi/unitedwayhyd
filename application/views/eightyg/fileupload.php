<div class="row">
    <!-- col column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
              <!-- <div class="card-header">
                <h3 class="card-title">Upload 80G</h3>
              </div> -->
              <!-- /.card-header -->
              <!-- form start -->
              <?php if(isset($error)): ?>
            <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
            </div>
            <?php endif; ?>
            <?php if(isset($receipts_error)): ?>
            <div class="alert alert-danger" role="alert">
            <?php echo $receipts_error; ?>
            </div>
            <?php endif; ?>
            <?php echo validation_errors(); ?>
              <?php echo form_open_multipart('eightyg/do_upload');?>
                <div class="card-body"> 
                 <!-- row -->
                <div class="row">
                  <!-- left column -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputFile">80G file</label>
                    <input type="file" class="form-control-file" name="userfile" required>
                  </div>
                  </div>
                  <!--/.col (left) -->
                  <!-- left column -->
                <div class="col-md-6">
                <table class="table table-sm">
                <thead>
                  <tr>
                    <th scope="col">Excel Coulmn</th>
                    <th scope="col">Respective Field</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">Col A <span class="text-red">*</span></th>
                    <td>Receipt Number</td>
                  </tr>
                  <tr>
                    <th scope="row">Col C <span class="text-red">*</span></th>
                    <td>Name of the person</td>
                  </tr>
                  <tr>
                    <th scope="row">Col D</th>
                    <td>Address 1</td>
                  </tr>
                  <tr>
                    <th scope="row">Col E</th>
                    <td>Address2</td>
                  </tr>
                  <tr>
                    <th scope="row">Col F</th>
                    <td>City-Place</td>
                  </tr>
                  <tr>
                    <th scope="row">Col G</th>
                    <td>PAN_NUMBER_C</td>
                  </tr>
                  <tr>
                    <th scope="row">Col H <span class="text-red">*</span></th>
                    <td>EMAIL_ID_C</td>
                  </tr>
                  <tr>
                    <th scope="row">Col I <span class="text-red">*</span></th>
                    <td>Sum of MONTHLY CONTRIBUTION</td>
                  </tr>
                  <tr>
                    <th scope="row">Col J <span class="text-red">*</span></th>
                    <td>Date</td>
                  </tr>
                  <tr>
                    <th scope="row">Col K <span class="text-red">*</span></th>
                    <td>Refdetails</td>
                  </tr>
                  <tr>
                    <th scope="row">Col L</th>
                    <td>Bank</td>
                  </tr>
                  <tr>
                    <th scope="row">Col M <span class="text-red">*</span></th>
                    <td>Purpose of Donation</td>
                  </tr>
                </tbody>
              </table>
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
    <!--/.col -->
</div>
<!-- /.row -->