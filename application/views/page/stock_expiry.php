<div class="row">
<div class="col-sm-12">
	
	 <div class="panel panel-default panel-table">
                <div class="panel-heading">Stock Expiry List(s)
                 <div class="tools"><a href="<?php  echo base_url('dashboard/new_stock') ?>" class="btn btn-sm btn-primary"><i class="mdi mdi-plus"></i> New Stock</a></div>
                </div>
				<div class="panel-body">
				 <table id="table3" class="table table-striped table-hover table-fw-widget">
                    <thead>
                       <tr>
					  <th>#</th>
                      <th>Product Name</th>
					  <th>Price</th>
					  <th>Quantity</th>
					  <th>Manufacturer</th>
					  <th>Expiry Date</th>
					  <th>Expired in</th>
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
						if($stock['expired_date']!="0000-00-00"){
								$now = time(); // or your date as well
								$your_date = strtotime($stock['expired_date']);
								$datediff = $your_date - $now ;
								$number_of_days = round($datediff / (60 * 60 * 24));
								$extra_charges=$this->db->from("others")->where("SN","1")->get()->result_array()[0];
						
					//if($number_of_days < $extra_charges['track_expiry_date']){
					if($number_of_days <= $extra_charges['expire_count']){
					?>
					<tr>
						<td><?php echo $num ?></td>
						<td><?php echo $stock['product_name'] ?></td>
						<td><?php echo number_format($stock['price'],2) ?></td>
						<td><?php echo $stock['quantity'] ?></td>
						<td><?php
							if($stock['manufacturer'] == "0"){
								echo "No Manufacturer"; 
							}else{
								$m = $this->stock->getManufacturer($stock['manufacturer']);
								if(count($m) == 0){
									echo "No Manufacturer";
								}else{
									echo $m[0]['manufacturer'];
								}
							}
						?></td>
						<td><?php echo $stock['expired_date'] ?></td>
						<td><?php echo $number_of_days ?> Days</td>
						<td>
							<div class="btn-group btn-space">
                        <button type="button" class="btn btn-default">Action</button>
                        <button type="button" data-toggle="dropdown" class="btn btn-success dropdown-toggle" aria-expanded="false"><span class="mdi mdi-chevron-down"></span><span class="sr-only">Toggle Dropdown</span></button>
                        <ul role="menu" class="dropdown-menu">
                   			<li><a href="<?php echo base_url('dashboard/edit_stock/'.$stock['SN'] )  ?>">Edit</a></li>                    
                        </ul>
                      </div>
						</td>
					</tr>
					<?php
						$num++;
						}
						}
						}
					?>
					</tbody>
				</table>
				</div>
	
</div>
</div>