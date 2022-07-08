<div class="row">
<div class="col-sm-12">
	
	 <div class="panel panel-default panel-table">
                <div class="panel-heading">Stock Received List(s)
                 <div class="tools">
				 <a class="btn btn-primary" href="<?php  echo base_url('dashboard/new_recieved_supplier') ?>">New Stock Received <span class="icon-dropdown mdi mdi-chevron-down"></span></a>				 
				 </div>
                </div>
				<div class="panel-body">
				 <table id="table3" class="table table-striped table-hover table-fw-widget">
                    <thead>
                      <tr>
					  <th>#</th>
					  <th>Received ID</th>
					  <th>Received Date</th>
					  <th>Branch/Supplier</th>
					  <th>Receiver</th>
					  <th>Transfer User</th>
					  <th>Command</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php
						$num=1;
						$array = array(
										'0'=>'<span class="label label-danger">Disabled</span>',
										'1'=>'<span class="label label-success">Enabled</span>'
									);
						$recievers = $this->stock->getStockrecieved();
						foreach($recievers as $transfer){
							
							
							
							$user = $this->users->get_user_by_id($transfer['reciever_userfullname'],1);
					?>
						<tr>
							<td><?php  echo $num ?></td>
							<td><?php  echo $transfer['recieved_id'] ?></td>
							<td><?php  echo $transfer['recieved_date'] ?></td>
							<td><?php  echo $transfer['branch'] ?></td>
							<td><?php  echo $user->username ?></td>
							<td><?php  echo $transfer['transfer_user'] ?></td>
							<td><a href="<?php echo base_url('dashboard/view_received/'.$transfer['recieved_id']) ?>" class="btn btn-sm btn-primary">View Received</a></td>
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