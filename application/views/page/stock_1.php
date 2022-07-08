<div class="row">
<div class="col-sm-12">
	
	 <div class="panel panel-default panel-table">
                <div class="panel-heading">Stock List(s)
                 <div class="tools"><a href="<?php  echo base_url('dashboard/new_stock') ?>" class="btn btn-sm btn-primary"><i class="mdi mdi-plus"></i> New Stock</a></div>
                </div>
				<div class="panel-body">
				 <table id="table3" class="table table-striped table-hover table-fw-widget">
                    <thead>
                      <tr>
					  <th>#</th>
                      <th>Product Name</th>
					  <th>Product Code</th>
					  <th>Model</th>
					  <th>Price</th>
					  <th>Quantity</th>
                      <th>Status</th>
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
						foreach($stocks as $stock){	
					?>
					<tr>
						<td><?php echo $num ?></td>
						<td><?php echo $stock['product_name'] ?></td>
						<td><?php echo $stock['product_code'] ?></td>
						<td><?php echo $stock['model'] ?></td>
						<td><?php echo number_format($stock['price'],2) ?></td>
						<td><?php echo $stock['quantity'] ?></td>
						<td><?php echo $array[$stock['status']] ?></td>
						<td>
							<div class="btn-group btn-space">
                        <button type="button" class="btn btn-default">Action</button>
                        <button type="button" data-toggle="dropdown" class="btn btn-success dropdown-toggle" aria-expanded="false"><span class="mdi mdi-chevron-down"></span><span class="sr-only">Toggle Dropdown</span></button>
                        <ul role="menu" class="dropdown-menu">
                          <li><a href="<?php echo base_url('dashboard/edit_stock/'.$stock['SN'] )  ?>">Edit</a></li>
                          <li><a href="<?php echo base_url('dashboard/view_stock_list/'.$stock['SN'] )  ?>">View Stock List</a></li>
						  <?php if($stock['status']=="1"){  ?>
						  <li><a href="<?php echo base_url('dashboard/set_availability/'.$stock['SN'].'/0' )  ?>">Disable</a></li>
                          <?php }else{ ?>
						   <li><a href="<?php echo base_url('dashboard/set_availability/'.$stock['SN'].'/1' )  ?>">Enable</a></li>
						  <?php } ?>
						   <!--<li><a href="#">Stock Timeline</a></li>-->
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