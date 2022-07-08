<!DOCTYPE html><html class=''>
<head>
<link rel="stylesheet" href="<?php echo base_url('application/posfont/stylesheet.css'); ?>"/>
<style class="cp-pen-styles">
#invoice-POS {
  box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
  padding: 2mm;
  margin: 0 auto;
  width: 80mm;
  background: #FFF;
  font-family: 'MyWebFont', Arial, sans-serif;
}
#invoice-POS ::selection {
  background: #f31544;
  color: #000;
}
#invoice-POS ::moz-selection {
  background: #f31544;
  color: #000;
  font-family: 'MyWebFont', Arial, sans-serif;
}
#invoice-POS h1 {
  font-size: 1.2em;
  color: #000;
  font-family: 'MyWebFont', Arial, sans-serif;
}
#invoice-POS h2 {
  font-size: 0.9em;
  font-family: 'MyWebFont', Arial, sans-serif;
  padding:0px;
  margin-top:0px;
  margin-bottom:6px;
}
#invoice-POS h3 {
  font-size: 1.2em;
  font-weight: 300;
  line-height: 2em;
  font-family: 'MyWebFont', Arial, sans-serif;
}
#invoice-POS p {
  font-size: 1.2em;
  color:#000;
  line-height: 1.2em;
  font-family: 'MyWebFont', Arial, sans-serif;
}
#invoice-POS #top, #invoice-POS #mid, #invoice-POS #bot {
  /* Targets all id with 'col-' */

  font-family: 'MyWebFont', Arial, sans-serif;
}
#invoice-POS #top {

  font-family: 'MyWebFont', Arial, sans-serif;
}
#invoice-POS #mid {
  min-height: 80px;
  font-family: 'MyWebFont', Arial, sans-serif;
}
#invoice-POS #bot {
  min-height: 50px;
  font-family: 'MyWebFont', Arial, sans-serif;
}
#invoice-POS #top .logo {

  width: 60px;
  background: url(images/head.png) no-repeat;
  background-size: 60px 60px;
  font-family: 'MyWebFont', Arial, sans-serif;
}
#invoice-POS .clientlogo {
  float: left;
  height: 60px;
  width: 60px;
  background: url(images/head.png) no-repeat;
  background-size: 60px 60px;
  border-radius: 50px;
  font-family: 'MyWebFont', Arial, sans-serif;
}
#invoice-POS .info {
  display: block;
  margin-left: 0;
  font-family: 'MyWebFont', Arial, sans-serif;
}
#invoice-POS .title {
  float: right;
  font-family: 'MyWebFont', Arial, sans-serif;
}
#invoice-POS .title p {
  text-align: right;
  font-family: 'MyWebFont', Arial, sans-serif;
}
#invoice-POS table {
  width: 100%;
  border-collapse: collapse;
  font-family: 'MyWebFont', Arial, sans-serif;
}
#invoice-POS .tabletitle {
  font-size: .90em;
  font-family: 'MyWebFont', Arial, sans-serif;
  margin:0px;
  padding:0px;
}
#invoice-POS .service {
  font-family: 'MyWebFont', Arial, sans-serif;
 
}
#invoice-POS .item {
  width: 24mm;
  font-family: 'MyWebFont', Arial, sans-serif;
}
#invoice-POS .itemtext {
  font-size: 0.50em;
  font-weight: 300;
  text-align:left;
  padding-bottom:10px;
  font-family: 'MyWebFont', Arial, sans-serif;
}
#invoice-POS #legalcopy {
  margin-top: 5mm;
  font-family: 'MyWebFont', Arial, sans-serif;
}
</style></head><body>

  <div id="invoice-POS" align="center">
     <div class="logo" style="margin-bottom:10px;"><center><img style="width:48mm;" src="<?php echo $this->settings->getSettings()['slogo'] ?>" alt="" width="60" /></center></div>
    
	  <div class="info" style="margin-top:-26px;margin-bottom:3px;">
		 <span style="font-size:10px;;margin-bottom:10px;"><?php echo $this->settings->getSettings()['saddress_1']  ?>
		<?php
		if(!empty($this->settings->getSettings()['saddress_2'])){
		?><br/><?php echo $this->settings->getSettings()['saddress_2']  ?>
		<?php
		}
		?>
		<?php
		if(!empty($this->settings->getSettings()['scontact_no'])){
		?><br/><?php echo $this->settings->getSettings()['scontact_no']  ?>
		<?php
		}
		?>
	  </span>
	  </div>
      <div align="center">
          <span style="font-size:12px;;margin-bottom:6px;">Receipt ID : <?php echo $payment['reciept_id']  ?></span> <br/>
          <span style="font-size:12px;;margin-bottom:6px;">Date & Time  : <?php echo $payment['date'];  ?>  <?php echo $payment['time_']; ?></span><br/>
          <span style="font-size:12px;;margin-bottom:6px;">Sales Rep  : <?php echo $this->users->get_user_by_id($payment['user_id'],1)->username; ?></span><br/>
          <span style="font-size:11px;">Payment Method: <?php echo $payment['payment_method']=="SPLIT" ? "SPLIT PAYMENT" : $this->db->get_where("payment_method",array("SN"=>$payment['payment_method']))->row()->payment_method;  ?></span><br/>
          <span style="font-size:11px;">Server : <?php echo $this->db->get_where("waiter_name",array("SN"=>$payment['waiter_id']))->row()->name  ?></span>
          <br/>
          <b style="font-family:MyWebFont; padding: 0; font-size:22px; margin-top: 0px;"><?php echo $payment['order_type']=="" ? "NOT AVAILABLE" : $payment['order_type'];  ?></b>
          <hr/>
      </div>
	  <br/>
	  <div class="info" align="center">
        <span style="font-weight:bolder;font-size:15px;margin-bottom:10px; margin-top: -15px; display:block;">Payment Receipt.</span>
    </div>
	<h6 style="font-family:MyWebFont; font-size:14px;"align="center">Item(s) Bought</h6>

		<div id="table" style="margin-top:-5px;">
						<table>
													<?php
								$items = json_decode($payment['items'],true);
								foreach($items as $item){
							?>
							<tr class="service">
								<td class="tableitem itemtext"  style="max-width:1%;width:1%;text-align:left;font-size:0.9em;font-weight:100;"><?php echo $item['item_qty'];   ?></td>
								<td class="tableitem itemtext" style="max-width:54%;width:54%;text-align:left;font-size:0.9em;font-weight:100;"><?php echo ucwords(strtolower($item['item_name']))  ?></td>
								<td class="tableitem itemtext"  style="max-width:17%;width:17%;text-align:left;font-size:0.9em;font-weight:100;"><?php echo number_format($item['item_price'],1);   ?></td>
								<td class="tableitem itemtext" style="max-width:10%;width:10%;text-align:right;font-size:0.9em;font-weight:100;">&#8358;<?php echo number_format($item['total'],1); ?></td>
							</tr>
							<?php
								}
							?>
							<tr class="tabletitle">
								<td></td>
								<td class="Rate"><h2>Sub Total</h2></td>
								<td></td>
								<td class="payment"><h2>&#8358;<?php echo number_format(($payment['total_amount']),2); ?></h2></td>
								
							</tr>
							<tr class="tabletitle">
								<td></td>
								<td class="Rate"><h2>


							
						<!--
							<tr class="tabletitle">
								<td></td>
								<td class="Rate"><h2>S.Charge(<?php echo $payment['scharge'] ?>%)</h2></td>
								<?php $scharge =($payment['scharge']/100)*$payment['total_amount']; ?>
								<td></td>
								<td class="payment"><h2>&#8358;<?php echo number_format($scharge,2); ?></h2></td>
								
							</tr>
						-->	
							<tr class="tabletitle">
								<td></td>
								<td class="Rate"><h2>Total</h2></td>
								<td></td>
								<?php //$to_pay = ($payment['total_amount']-$payment['discount'])+($scharge+$vat);
										$to_pay = ($payment['total_amount']-$payment['discount']);
								?>
								<td class="payment" style="font-size:15px;"><h2>&#8358;<?php echo number_format($to_pay,2); ?></h2></td>
								
							</tr>
						</table>	
	</div>
	</div>
  </div>
</body>
<script>
window.onload = function(){
window.print();
setTimeout(function(){
    window.close()
},5000)
}
</script>

</html>
