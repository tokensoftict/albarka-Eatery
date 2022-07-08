	<div class="col-lg-3" style="position:relative; ">
		<div class="showcase" style="display:block;position:fixed; width:20%; left:15px; top:120px;box-shadow:1px 1px 1px 0.5px #CCC;">
                      <div class="dropdown" >
                        <ul style="display: block; width:100%;" class="dropdown-menu dropdown-menu-primary">
                          <li> <a href="<?php echo base_url(); ?>"><span class="icon mdi mdi-home"></span>Dashboard</a></li>
						     <li><a href="<?php echo base_url('dashboard/pos')  ?>"><span class="icon mdi mdi-shopping-cart-plus"></span>Open POS</a></li>
							 <li><a href="<?php echo base_url('dashboard/sales')  ?>"><span class="icon mdi mdi-shopping-cart"></span>Today's Sales List</a></li>
						   <li> <a href="<?php echo base_url('dashboard/stock'); ?>"><span class="icon mdi mdi-edit"></span>Manage Stock</a></li>
						   <li> <a href="<?php echo base_url('dashboard/stock_recieved');  ?>"><span class="icon mdi mdi-plus"></span>Receive Stocks</a></li>

						   <li> <a href="<?php echo base_url('dashboard/sales_report'); ?>"><span class="icon mdi mdi-chart"></span>Monthly Sales Report</a></li>
							<li> <a href="<?php echo base_url('dashboard/report_sales_rep'); ?>"><span class="icon mdi mdi-chart"></span>Report By Sales Rep</a></li>	
							<li> <a href="<?php echo base_url('dashboard/report_by_waiter'); ?>"><span class="icon mdi mdi-chart"></span>Report By Waiter</a></li>


                            <li> <a href="<?php echo base_url('dashboard/order'); ?>"><span class="icon mdi mdi-chart"></span>Today's Order</a></li>
                            <li> <a href="<?php echo base_url('dashboard/order_report'); ?>"><span class="icon mdi mdi-chart"></span>Monthly Order Report</a></li>
                            <li> <a href="<?php echo base_url('dashboard/order_report_sales_rep'); ?>"><span class="icon mdi mdi-chart"></span>Order By Report By Sales Rep</a></li>
                            <li> <a href="<?php echo base_url('dashboard/order_report_by_waiter'); ?>"><span class="icon mdi mdi-chart"></span>Order Report By Waiter</a></li>

						 <li><a href="<?php echo base_url('dashboard/backup')  ?>"><span class="icon mdi mdi-dns"></span>Database BackUp</a></li>
							<li> <a href="<?php echo base_url('dashboard/list_waiter'); ?>"><span class="icon mdi mdi-chart"></span>Servers List</a></li>
						  <li><a href="<?php echo base_url('dashboard/settings')  ?>"><span class="icon mdi mdi-settings"></span>Settings</a></li>			  
							<li>
                            <div class="dropdown-tools">
                              <div class="btn-group xs-mt-5 xs-mb-10">
                                <a href="<?php  echo base_url('auth/logout') ?>"   class="btn btn-default"><span class="mdi mdi-power"></span></a>
                                <a href="<?php  echo base_url('dashboard/myprofile') ?>"  class="btn btn-default active"><span class="mdi mdi-face"></span></a>
                              </div>
                            </div>
                          </li>
						</ul>
                      </div>
                    </div>
	</div>
