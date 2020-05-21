
<div class="row">
    <!-- left column -->
  <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add New Area </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
			  
              <?php echo form_open('areas/create'); ?>
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Area Name</label>
                    <input type="text" name="newArea" class="form-control" id="exampleInputEmail1" placeholder="Enter Area Name">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="insert" value="Insert" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
    </div>
    <!--/.col (left) -->
</div>
<!-- /.row -->
