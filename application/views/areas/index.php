
<div class="row"><div class="col-md-12">
<div class="card">
              <!-- <div class="card-header">
                <h3 class="card-title">Bordered Table</h3>
              </div> -->
              <!-- /.card-header -->
              <div class="card-body">
	<table class="table table-bordered">
		<tr>
			<th>Areas</th>
			<th>Action</th>
        </tr>
<?php 
foreach ($areas as $are) {
	 echo "<tr>
	 	<td>".$are['area_name']."</td>
		<td>".anchor('areas/edit/'.$are['area_id'], 'edit', 'class="btn btn-primary btn-sm mr-1"')."</td>
	    </tr>";
}
?>	
</table>
</div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                
              </div>
            </div>
            </div>    </div>