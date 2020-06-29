<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">
              <!-- <div class="card-header">
                <h3 class="card-title">Add New Donor</h3>
              </div> -->
         
              <!-- /.card-header -->
              <!-- form start -->
              <?php echo validation_errors(); ?>
              <?php echo form_open('donors/create'); ?>
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Donor Name</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Donor Name" name="Donorname">
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputPassword1">Phone</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter Phone No" name="Pho">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Email</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter Email" name="email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Address</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter Address" name="address">
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