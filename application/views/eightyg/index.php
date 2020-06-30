<div class="row"><div class="col-md-12">
<div class="card">
    <div class="card-header">
    <form action="<?php echo $current_url;?>" method="get">
  <div class="form-row">
    <div class="col">
      <input type="text" class="form-control" placeholder="Donor name" name="donor" value="<?php echo $donor;?>">
    </div>
    <div class="col">
    <button type="submit" class="btn btn-primary">Submit</button>
    <?php echo anchor('eightyg','<i class="fas fa-redo-alt nav-icon"></i> Reset', 'class="btn btn-default"'); ?>
    <?php echo anchor('eightyg/create','<i class="fas fa-plus-square nav-icon"></i> Add New', 'class="btn btn-default"'); ?>
  <?php echo anchor('eightyg/fileupload','<i class="fas fa-upload nav-icon"></i> Upload', 'class="btn btn-default"'); ?>
    </div>
  </div>
</form>
  
        </div>
              <!-- /.card-header -->
              <?php echo form_open($current_url); echo form_hidden('eightysubmit', 'yes');?>
              <div class="card-body">
              
                <table class="table table-bordered table-sm">
                  <thead>                  
                    <tr>
                    <th></th>
                      <th>receipt</th>
                      <th>donor</th>
                      <th>email</th>
                      <th>date</th>
                      <th>Amount</th>
                      <th>80G File</th>
                      <th>Email Sent</th>
                      <th>actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach($eightyg_data as $k => $data) {
                      echo '<tr>';
                      echo '<td><input type="checkbox" name="eightyg_ids[]" value="'.$k.'"></td>';
                    echo '<td>'.$data->receipt_no.'</td>';
                    echo '<td>'.$data->donor_name.'</td>';
                    echo '<td>'.$data->email.'</td>';
                    echo '<td>'.date('d-m-Y', strtotime($data->trns_date)).'</td>';
                    echo '<td>'.$data->sum_monthly_contribution.'</td>';
                    $file_status = 'NA';
                    if($data->pdf_80g != '') {
                      if(get_file_info('80g_certificates/'.$data->pdf_80g)) {
                        $file_status = '<a href="'.base_url('80g_certificates/'.$data->pdf_80g).'" target="_blank">80G Pdf</a>';
                      }
                    }                    
                    echo '<td>'.$file_status.'</td>';
                    echo '<td>'.$data->sent_email.'</td>';
                    echo '<td>'.anchor('eightyg/update/'.$data->id, '<i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="Edit 80g"></i>', 'class="mr-1"');
                    //echo anchor('#', '<i class="fas fa-list" data-toggle="modal" data-target="#eightyg_'.$data->id.'"></i>', 'class=""');
                    echo '<span style="cursor: pointer;" data-toggle="modal" data-target="#eightyg_'.$data->id.'"><i class="fas fa-list" data-toggle="tooltip" title="80g Details" data-placement="top"></i></span>';
                  echo   '<div class="modal fade" id="eightyg_'.$data->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">                      
                      <div class="modal-body">
                      <table class="table table-sm">
                      <tbody>
                      <tr>
                          <th scope="row">receipt no</th>
                          <td>'.$data->receipt_no.'</td>
                        </tr>
                        <tr>
                          <th scope="row">donor name</th>
                          <td>'.$data->donor_name.'</td>
                        </tr>
                        <tr>
                          <th scope="row">PAN No</th>
                          <td>'.$data->pan_no.'</td>
                        </tr>
                        <tr>
                          <th scope="row">Email</th>
                          <td>'.$data->email.'</td>
                        </tr>
                        <tr>
                          <th scope="row">sum monthly contribution</th>
                          <td>'.$data->sum_monthly_contribution.'</td>
                        </tr>
                        <tr>
                          <th scope="row">Date</th>
                          <td>'.date('d-m-Y', strtotime($data->trns_date)).'</td>
                        </tr>
                        <tr>
                          <th scope="row">Ref Details</th>
                          <td>'.$data->ref_details.'</td>
                        </tr>
                        <tr>
                          <th scope="row">Bank</th>
                          <td>'.$data->bank.'</td>
                        </tr>
                        <tr>
                          <th scope="row">Cause for donation</th>
                          <td>'.$data->donation_cause.'</td>
                        </tr>
                        <tr>
                          <th scope="row">Address</th>
                          <td>'.$data->address1.'</td>
                        </tr>
                        <tr>
                          <th scope="row">Address 2</th>
                          <td>'.$data->address2.'</td>
                        </tr>
                        <tr>
                          <th scope="row">City</th>
                          <td>'.$data->city.'</td>
                        </tr>
                      </tbody>
                    </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div></td>';
                    echo '</tr>';
                  } ?>
                  </tbody>
                </table>
                
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
              <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="eightyg_action" id="inlineRadio1" value="gen80g" checked>
  <label class="form-check-label" for="inlineRadio1">Generate 80G</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="eightyg_action" id="inlineRadio2" value="sendemail">
  <label class="form-check-label" for="inlineRadio2">Send Email</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="eightyg_action" id="inlineRadio3" value="gen80gsendemail">
  <label class="form-check-label" for="inlineRadio3">Generate 80G + Send Email</label>
</div>
              <button type="submit" name="insert" value="Insert" class="btn btn-primary">Submit</button>
                <ul class="pagination pagination-sm m-0 float-right">
                  <?php echo $this->pagination->create_links();?>
                </ul>
              </div><!-- /.card-footer -->
              </form>
            </div>
            </div>    </div>