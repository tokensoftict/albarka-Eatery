<?php
$branch_id = $this->stock->getBranch_id();

$total_stock = count($this->stock->getSellable(array("status"=>'0')));
$total_out_of_stock =count($this->stock->getStocksToRecieved()) - $total_stock;


$last_month = date('Y-m', strtotime('last month'));
$from= $last_month.'-'.date('27');
$to = date('Y').'-'.date('m').'-'."26";

$transfer= $this->stock->getStocktransfersBetween($from,$to);
$received= $this->stock->getStockrecievedBetween($from,$to);

//$total_in_stock = 
//constructing line chart from here
$months = array("January"=>"1", "February"=>"2", "March"=>"3", "April"=>"4", "May"=>"5", 
"June"=>"6", "July"=>"7",
"August"=>"8","September"=>"9","October"=>"10","November"=>"11","December"=>"12");
$data = array();
foreach($months as $key=>$month){
$current_month = date('Y').'-'.$month.'-'.'01';
$start_ = date("Y-m",strtotime($current_month.' last month')).'-27';
$stop_ = date("Y-".$month).'-26';
$in = $this->stock->inReport($start_,$stop_);
$out = $this->stock->outReport($start_,$stop_);
$data['in'][] = $in;	
$data['out'][] = $out;
$data['labels'][] = $key;
}

$data['color1'] = "#006400";
$data['color2'] = "#FF4500";

?>
<script>
var data_in = JSON.parse('<?php  echo json_encode($data) ?>');
</script>
<?php
$from = date('Y').'-'.date('m').'-'.date('01');
$to = date('Y').'-'.date('m').'-'.date('t');
$yealy_produced = array();
$data_sales = array();
$labelsales = array();
foreach($months as $key=>$month){
	$payment = $this->invoice->getTotalIncome($month);
	$data_sales['payment'][] =$payment;
	$data_sales['labels'][] = $key;
}


?>
<script>
var sales = JSON.parse('<?php  echo json_encode($data_sales) ?>');
</script>
<div class="row">
            <div class="col-xs-12 col-md-6 col-lg-3">
                        <div class="widget widget-tile">
                          <div id="spark1" class="chart sparkline"><canvas width="85" height="35" style="display: inline-block; width: 85px; height: 35px; vertical-align: top;"></canvas></div>
                          <div class="data-info">
                            <div class="desc" title="Stock">Stock</div>
                            <div class="value"><span class="indicator indicator-equal mdi mdi-chevron-right"></span><span data-toggle="counter" data-end="<?php  echo $total_stock; ?>" class="number"><?php  echo $total_stock; ?></span>
                            </div>
                          </div>
                        </div>
            </div>
			 <div class="col-xs-12 col-md-6 col-lg-3">
                        <div class="widget widget-tile">
                          <div id="spark4" class="chart sparkline"><canvas width="85" height="35" style="display: inline-block; width: 85px; height: 35px; vertical-align: top;"></canvas></div>
                          <div class="data-info">
						  <?php
						  $total_sales = $this->invoice->getTotalIncome(date('Y-m-d'));
						  ?>
                            <div class="desc">Sales Report</div>
                            <div class="value"><span class="indicator indicator-negative mdi mdi-chevron-down"></span><span data-toggle="counter" data-end="<?php echo $total_sales ?>" class="number"><?php echo $total_sales ?></span>
                            </div>
                          </div>
                        </div>
            </div>
			 <div class="col-xs-12 col-md-6 col-lg-3">
                        <div class="widget widget-tile">
                          <div id="spark2" class="chart sparkline"><canvas width="85" height="35" style="display: inline-block; width: 85px; height: 35px; vertical-align: top;"></canvas></div>
                          <div class="data-info">
                            <div class="desc" title="Out of Stock">Out of Stock</div>
                            <div class="value"><span class="indicator indicator-equal mdi mdi-chevron-right"></span><span data-toggle="counter" data-end="<?php  echo $total_out_of_stock ; ?>" class="number"><?php  echo $total_out_of_stock; ?></span>
                            </div>
                          </div>
                        </div>
            </div>
			 <div class="col-xs-12 col-md-6 col-lg-3">
                        <div class="widget widget-tile">
                          <div id="spark2" class="chart sparkline"><canvas width="85" height="35" style="display: inline-block; width: 85px; height: 35px; vertical-align: top;"></canvas></div>
                          <div class="data-info">
                            <div class="desc" title="Out of Stock">Expired Product</div>
							<?php
								$exp = $this->stock->numberofgetexpiredproduct();
							?>
                            <div class="value"><span class="indicator indicator-equal mdi mdi-chevron-right"></span><span data-toggle="counter" data-end="<?php  echo $exp ; ?>" class="number"><?php  echo $exp; ?></span>
                            </div>
                          </div>
                        </div>
            </div>
</div>

<div class="row">
	<div class="col-xs-12 col-md-12 col-lg-12">
              <div class="widget be-loading">
                <div class="widget-head">
                  <div class="tools"><span class="icon mdi mdi-refresh-sync toggle-loading"></span></div>
                  <div class="title">Sales Chart Report (Year : <?php echo date('Y') ?>)</div>
                </div>
				<div class="widget-chart-container">
					<canvas id="sales_bar-chart"></canvas>
				</div>
                <div class="be-spinner">
                  <svg width="40px" height="40px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                    <circle fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30" class="circle"></circle>
                  </svg>
                </div>
              </div>
            </div>
</div>			
	
<?php
$loadmodal = false;
$stocks =  $this->stock->getStocks();
$st = array();
foreach($stocks as $stock){
	if($stock['expired_date']!="0000-00-00"){
		$now = time(); // or your date as well
		$your_date = strtotime($stock['expired_date']);
		$datediff = $your_date - $now ;
		$number_of_days = round($datediff / (60 * 60 * 24));
		$extra_charges=$this->db->from("others")->where("SN","1")->get()->result_array()[0];
	if($number_of_days <= $extra_charges['expire_count']){
		$loadmodal = true;
		$st[] = $stock;
	}
	}
}
?>

<?php
if($loadmodal == true){
?>
  <div class="modal fade colored-header colored-header-primary" id="form-bp1" tabindex="-1" role="dialog">
<div class="modal-dialog">
        <div class="modal-content modal-lg">
          <div class="modal-header modal-header-colored">
            <h3 class="modal-title">Stock Expired Alert</h3>
            <button class="close md-close" type="button" data-dismiss="modal" aria-hidden="true"><span class="mdi mdi-close"></span></button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered table-striped">
				<thead>
                       <tr>
					  <th>#</th>
                      <th>Product Name</th>
					  <th>Price</th>
					  <th>Quantity</th>
					  <th>Manufacturer</th>
					  <th>Expiry Date</th>
					  <th>Expired in</th>
                      </tr>
                    </thead>
				<tbody>
					
					<?php
						$num = 1;
						foreach($st as $stoc){
					?>
					<tr>
						<tr>
						<td><?php echo $num ?></td>
						<td><?php echo $stoc['product_name'] ?></td>
						<td><?php echo number_format($stock['price'],2) ?></td>
						<td><?php echo $stoc['quantity'] ?></td>
						<td><?php
							if($stoc['manufacturer'] == "0"){
								echo "No Manufacturer"; 
							}else{
								$m = $this->stock->getManufacturer($stoc['manufacturer']);
								if(count($m) == 0){
									echo "No Manufacturer";
								}else{
									echo $m[0]['manufacturer'];
								}
							}
						?></td>
						<td><?php echo $stoc['expired_date'] ?></td>
						<td>
						<?php 
								if($number_of_days < 0){
									echo -$number_of_days ." Days ago";
								}else{
									echo  "In ".$number_of_days." Days";
								}
						?> 
						</td>
					
					</tr>
					</tr>
					<?php
						$num++;
						}
					?>
				</tbody>
			</table>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary md-close" type="button" data-dismiss="modal">Close</button>
          </div>
       </div>
      </div>
	  </div>
	  <button style="display:none;" id="mod" class="btn btn-space btn-primary" data-toggle="modal" data-target="#form-bp1" type="button">Bootstrap Modal</button>

<?php
}
?>