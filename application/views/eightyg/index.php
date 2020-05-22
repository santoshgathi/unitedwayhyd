<div class="row"><div class="col-md-12">
<div class="card">
              <!-- <div class="card-header">
                <h3 class="card-title">Bordered Table</h3>
              </div> -->
              <!-- /.card-header -->
              <?php echo form_open($current_url); echo form_hidden('eightysubmit', 'yes');?>
              <div class="card-body">
              
                <table class="table table-bordered table-sm">
                  <thead>                  
                    <tr>
                    <th></th>
                      <th>receipt</th>
                      <th>donor</th>
                      <th>pan no</th>
                      <th>email</th>
                      <th>sum monthly</th>
                      <th>date</th>
                      <th>ref details</th>
                      <th>bank</th>
                      <th>actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach($eightyg_data as $k => $data) {
                      echo '<tr>';
                      echo '<td><input type="checkbox" name="eightyg_ids[]" value="'.$k.'"></td>';
                    echo '<td>'.$data->receipt_no.'</td>';
                    echo '<td>'.$data->donor_name.'</td>';
                    echo '<td>'.$data->pan_no.'</td>';
                    echo '<td>'.$data->email.'</td>';
                    echo '<td>'.$data->sum_monthly_contribution.'</td>';
                    echo '<td>'.date('d-m-Y', strtotime($data->trns_date)).'</td>';
                    echo '<td>'.$data->ref_details.'</td>';
                    echo '<td>'.$data->bank.'</td>';
                    echo '<td>'.anchor('eightyg/update/'.$data->id, 'edit', '').'</td>';
                    echo '</tr>';
                  } ?>
                  </tbody>
                </table>
                
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
              <button type="submit" name="insert" value="Insert" class="btn btn-primary">Submit</button>
                <ul class="pagination pagination-sm m-0 float-right">
                  <?php echo $this->pagination->create_links();?>
                </ul>
              </div><!-- /.card-footer -->
              </form>
            </div>
            </div>    </div>