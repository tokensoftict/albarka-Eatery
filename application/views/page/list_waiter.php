<div class="row">
<div class="col-sm-12">
	
	 <div class="panel panel-default panel-table">
                <div class="panel-heading">
                 <div class="tools"><a href="<?php  echo base_url('dashboard/new_waiter') ?>" class="btn btn-sm btn-primary"><i class="mdi mdi-plus"></i> New Server</a></div>
                </div>
				<div class="panel-body">
				 <table id="table3" class="table table-striped table-hover table-fw-widget">
                    <thead>
                       <tr>
					  <th>#</th>
                      <th>Waiter Name</th>
					  <th>Gender</th>
					  <th>Date of Birth</th>
					  <th>Joined Date</th>
					  <th>Salary</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
						$num=1;
						$stocks = $this->db->get("waiter_name")->result_array();
						foreach($stocks as $stock){
					
					?>
					<tr>
						<td><?php echo $num ?></td>
						<td><?php echo $stock['name'] ?></td>
						<td><?php echo $stock['gender'] ?></td>
						<td><?php echo $stock['date_of_birth'] ?></td>
						<td><?php echo $stock['joined_date']; ?></td>
						<td>
							<div class="btn-group btn-space">
                        <button type="button" class="btn btn-default">Action</button>
                        <button type="button" data-toggle="dropdown" class="btn btn-success dropdown-toggle" aria-expanded="false"><span class="mdi mdi-chevron-down"></span><span class="sr-only">Toggle Dropdown</span></button>
                        <ul role="menu" class="dropdown-menu">
                   			<li><a href="<?php echo base_url('dashboard/delete_waiter/'.$stock['SN'] )  ?>">Delete</a></li>                    
                        </ul>
                      </div>
						</td>
					</tr>
					<?php
						$num++;
						}
					?>
					</tbody>
				</table>
				</div>
	
</div>
</div>
