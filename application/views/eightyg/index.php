<div class="row"><div class="col-md-12">
<div class="card">
              <!-- <div class="card-header">
                <h3 class="card-title">Bordered Table</h3>
              </div> -->
              <!-- /.card-header -->
              <?php echo $email_status; ?>
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
                      <th>bank</th>
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
                    echo '<td>'.$data->bank.'</td>';
                    $file_status = 'NA';
                    if(get_file_info('80g_certificates/'.$data->pdf_80g)) {
                      $file_status = '<a href="'.base_url('80g_certificates/'.$data->pdf_80g).'" target="_blank">80G Pdf</a>';
                    }
                    echo '<td>'.$file_status.'</td>';
                    echo '<td>'.$data->sent_email.'</td>';
                    echo '<td>'.anchor('eightyg/update/'.$data->id, 'edit', 'class="btn btn-primary btn-sm mr-1"');
                    echo '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#eightyg_'.$data->id.'">Details</button>';
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