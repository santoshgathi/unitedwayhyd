<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">
              <!-- <div class="card-header">
                <h3 class="card-title">Add New Expenditure</h3>
              </div> -->
              <!-- /.card-header -->
              <!-- form start -->
              <?php echo validation_errors(); ?>
              <?php echo form_open('expenditures/create', array('autocomplete' => 'off')); ?>
                <div class="card-body">
                  <div class="form-group">
                    <label for="expenditure_dt">Date</label>
                    <input type="text" class="form-control" id="expenditure_dt" placeholder="Select Date" name="expenditure_dt" autocomplete="off" required>
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
                    <label for="exampleInputPassword1">Nutrition + Hygiene Kit</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" value="0" name="nutrition_hygiene_kit">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Meals</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" value="0" name="meals">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Medical Equipment</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" value="0" name="medical_equipment">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Sanitation Material</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" value="0" name="sanitation_material">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">PPE Kits</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" value="0" name="ppe_kits">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Amount Spent</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" value="0" name="amount_spent">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">UWH Admin Cost</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" value="0" name="admin_cost">
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