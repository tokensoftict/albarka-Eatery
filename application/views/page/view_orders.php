<?php
$in = $this->stock->getOrder($this->uri->segment(3));
				if(is_numeric($in['customer'])){
						$customer = $this->settings->getCustomer($in['customer']);
						$customer = $customer['firstname'].' '.$customer['lastname'];
						}else{
							$customer = $this->settings->getCustomer($in['customer']);
						$customer = $customer['firstname'].' '.$customer['lastname'];
						}
	
						$user =$this->users->get_user_by_id($in['user_id'],1);
?>
<?php
$reservation = $this->stock->getSale($this->uri->segment(3));
$items = json_decode($in['items'],true);
?>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default panel-table">
					<div class="panel-heading"> Order Transaction
					 <div class="tools">
					 <div class="btn-group btn-sm">
												<div class="dropdown">
												  <button class="btn btn-sm btn-success dropdown-toggle" type="button" data-toggle="dropdown">Print
												  <span class="caret"></span></button>
												  <ul class="dropdown-menu">
												  <li><a href="<?php  echo base_url('dashboard/view_orders/'.$this->uri->segment(3)) ?>">View</a></li>
												  <li><a onclick="window.open($(this).attr('href'),'width=400;hieght=400;','400','400'); return false;" href="<?php  echo base_url('dashboard/print_order/'.$in['reciept_id']) ?>" >Print</a></li>
                                                      <?php  if($in['status'] == "0"){  ?>
                                                      <li><a  href="<?php  echo base_url('dashboard/mark_as_paid/'.$in['SN']) ?>?back=dash" >Mark As Paid</a></li>
                                                      <?php  } ?>
												  </ul>
												</div>
								</div>
					 </div>
					</div>
					<div class="panel-body">
						<div class="col-lg-12">
							<div class="col-lg-4">
								<div class="form-group xs-pt-10">
								  <label>Order ID</label>
								  <span class="form-control input-sm"><?php echo $in['reciept_id'] ?> </span>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group xs-pt-10">
								  <label>Customer</label>
								   <span class="form-control input-sm"><?php echo $customer ?> </span>
								 </div>
							</div>
							<div class="col-lg-4">
								<div class="form-group xs-pt-10">
								  <label>Total Amount</label>
								 
								  <span class="form-control input-sm"><?php echo number_format($in['total_amount'],2); ?></span>
								</div>
							</div>
							<h3>Ordered List(s)</h3>
							<table class="table table-condensed table-bordered" id="table3">
												<thead>
													<tr>
														<th class="text-center">Item Name</td>
														<th class="text-center">Qty</td>
														<th class="text-center">Price</td>
														<th class="text-right">Total</th>
													</tr>
												</thead>
												<tbody>
													<?php 
													
													$alltotal=0;
													foreach($items as $item) {
														$info = $item;
														$alltotal+=$info['total'];
													?>
													<tr>
														<td class="text-center"><?php  echo $item['item_name'] ?></td>
														<td class="text-center"><?php  echo $item['item_qty'] ?></td>
														<td class="text-center"><?php  echo number_format($item['item_price'],2) ?></td>
														<td class="text-right"><?php  echo number_format($item['total'],2); ?></td>
														
													</tr>
													<?php } ?>
												</tbody>
													<tfoot>
														<tr>
														
														<td></td>
														<td></td>
														
														<th class="text-right">Sub Total</th>
														<th class="text-right"><?php echo number_format($alltotal,2); ?></th>
														
													</tr>
													<tr>
														
														<td></td>
														<td></td>
														
														<th class="text-right">Discount</th>
														<th class="text-right"><?php echo number_format($reservation['discount'],2)  ?></th>
													</tr>
													<tr>
													
														<td></td>
														<td></td>
														
														<th class="text-right">VAT(<?php echo $reservation['vat'] ?>%)</th>
														<?php $vat = (($reservation['vat']/100) * $alltotal);  ?>
														
														<th class="text-right"><?php echo number_format($vat,2); ?></th>
													</tr>
													<tr>
													
														<td></td>
														<td></td>
														
														<th class="text-right">Charge(<?php echo $reservation['scharge'] ?>%)</th>
														<?php $charge = (($reservation['scharge']/100) * $alltotal);  ?>
														
														<th class="text-right"><?php echo number_format($charge,2); ?></th>
													</tr>
													<tr>
														<?php $alltotal=$alltotal-$reservation['discount']; ?>
														<?php $alltotal=$alltotal+$charge ?>
														<?php $alltotal=$alltotal+$vat ?>
														<td></td>
														
													<td></td>
														<th class="text-right">Total</th>
														<th class="text-right"><?php echo number_format($alltotal,2); ?></th>
													</tr>
													
													</tfoot>
												</table>
						<br/>
							</div>
						
					</div>
		</div>
	</div>
</div>
<script>
function con(msg){
	return confirm(msg);	
}
</script>
