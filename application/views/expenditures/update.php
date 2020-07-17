<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="card card-primary">
              <!-- <div class="card-header">
                <h3 class="card-title">Update Expenditure</h3>
              </div> -->
              <!-- /.card-header -->
              <!-- form start -->
              <?php if(isset($error)): ?>
            <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
            </div>
            <?php endif; ?>
            <?php echo validation_errors(); ?>
              <?php echo form_open('expenditures/update/'.$exp_details->expenditure_id);?>
                <div class="card-body"> 
                <div class="form-group">
                    <label for="exampleInputEmail1">Expenditure Date</label>
                    <?php echo form_input('expenditure_dt', $exp_details->expenditure_dt, 'class="form-control" id="expenditure_dt" autocomplete="off" required'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Donor</label>
                    <?php echo form_dropdown('donor_id',$donor_name, $exp_details->donor_id, 'class="form-control"');?>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Area</label>
                    <?php echo form_dropdown('area_id',$area, $exp_details->area_id, 'class="form-control"');?>
                  </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nutrition Hygiene Kits</label>
                    <?php echo form_input('nutrition_hygiene_kit', $exp_details->nutrition_hygiene_kit, 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Meals</label>
                    <?php echo form_input('meals', $exp_details->meals, 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Medical Equipment</label>
                    <?php echo form_input('medical_equipment',$exp_details->medical_equipment, 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Sanitation Material </label>
                    <?php echo form_input('sanitation_material', $exp_details->sanitation_material, 'class="form-control"'); ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">PPE Kits</label>
                    <?php echo form_input('ppe_kits', $exp_details->ppe_kits, 'class="form-control"'); ?>
                </div> 
                <div class="form-group">
                    <label for="exampleInputEmail1">Amount Spent</label>
                    <?php echo form_input('amount_spent', $exp_details->amount_spent, 'class="form-control"'); ?>
                </div> 
                <div class="form-group">
                    <label for="exampleInputEmail1">UWH Admin Cost</label>
                    <?php echo form_input('admin_cost', $exp_details->uwh_admin, 'class="form-control"'); ?>
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