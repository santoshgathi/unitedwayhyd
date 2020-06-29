<div class="row">
    <!-- left column -->
    <div class="col-md-6">
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
                  
                  <div class="form-group">
                    <label for="exampleInputFile">80G file</label>
                    <input type="file" class="form-control-file" name="userfile" required>
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