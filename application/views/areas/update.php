<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Area</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php if(isset($error)): ?>
            <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
            </div>
            <?php endif; ?>
			<?php echo validation_errors(); ?>
              <?php echo form_open('areas/edit/'.$area->area_id);?>
                <div class="card-body"> 
                <div class="form-group">
                    <label for="exampleInputEmail1">Area Name<span class="text-red">*</span></label>
                    <?php echo form_input('area_name',$area->area_name, 'class="form-control" required size="100"'); ?>
                    <p class="help-block text-yellow">Unique, only alpha spaces allowed, min length:3, max length:100</p>
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