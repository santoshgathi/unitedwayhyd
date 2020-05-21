<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add New Expenditure</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php echo validation_errors(); ?>
              <?php echo form_open('Expenditures/save'); ?>
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Date</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Select Date" name="date">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Donor</label>
                    <!-- <select class="form-control" name="donor">
                    <option value="donor1">donor1</option><option value="donor2">donor2</option>
                    </select> -->
                    <?php echo form_dropdown('donor_name',$donor_name, '', 'class="form-control"');?>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Area</label>
                    <!-- <select class="form-control" name="donor">
                    <option value="donor1">area1</option><option value="area2">donor2</option>
                    </select> -->
                    <?php echo form_dropdown('area',$area, '', 'class="form-control"');?>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Nutrition + Hygiene kit</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter Nutrition No" name="nutrition">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Meals</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter Meals No" name="meals">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">medical equipment</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter medical_equipment" name="medical_equipment">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">sanitation material</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="sanitation_material" name="sanitation_material">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">ppe kits</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="ppe_kits" name="ppe_kits">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">amount spent</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter amount_spent" name="amount_spent">
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