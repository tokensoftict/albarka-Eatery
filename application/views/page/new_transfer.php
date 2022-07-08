<div class="row">
<div class="col-sm-12">
			<form action="" method="post">
				<div class="panel panel-default">
					<div class="panel-heading">New Stock Transfer
					<div class="tools"> 
					</div>
					</div>
					<div class="panel-body">
					  <div class="be-content">
						<div class="main-content container-fluid">
          <div class="row wizard-row">
            <div class="col-md-12 fuelux">
              <div class="block-wizard panel panel-default">
                <div id="wizard1" class="wizard wizard-ux">
                  <ul class="steps">
                    <li data-step="1" class="active">Step 1<span class="chevron"></span></li>
                    <li data-step="2">Step 2<span class="chevron"></span></li>
                  </ul>
                  <div class="actions">
                    <button type="button" class="btn btn-xs btn-prev btn-default"><i class="icon mdi mdi-chevron-left"></i>Prev</button>
                    <button type="button" data-last="Finish" class="btn btn-xs btn-next btn-default">Next<i class="icon mdi mdi-chevron-right"></i></button>
                  </div>
                  <div class="step-content">
                    <div data-step="1" class="step-pane active">
                     <h3>Transfer Information</h3>
					 <div class="row">
							<div class="col-lg-3">
								<div class="form-group xs-pt-10">
								  <label>Transfer Date</label>
								  <input id="transfer_date" required type="text" value="<?php echo date('Y-m-d'); ?>" name="transfer_date" data-min-view="2" data-date-format="yyyy-mm-dd"  placeholder="Date Available" class="date form-control input-sm">
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group xs-pt-10">
								  <label>Transfer To</label>
								  <input type="text" name="branch" class="form-control input-sm" placeholder="Branch Or Supplier"/>
								 </div>
							</div>
							<div class="col-lg-3">
								<div class="form-group xs-pt-10">
								  <label>Transfer User</label>
								  <input type="text" readonly required value="<?php  echo $this->tank_auth->get_username(); ?>" placeholder="Transfer User" class="form-control input-sm">
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group xs-pt-10">
								  <label>Received User</label>
								  <input type="text" placeholder="Received User Fullname" name="reciever_userfullname" class="form-control input-sm">
								 </div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group xs-pt-10">
								  <label>Transfer Note</label>
								  <textarea placeholder="Detailed not about the transfer if any?.." style="height:150px" class="form-control col-lg-12" name="transfer_note"></textarea>
								 </div>
							
							</div>
						</diV>
					 <div class="form-group">
                        <br/><br/>
                            <button data-wizard="#wizard1" class="btn btn-default btn-space wizard-previous">Previous</button>
                            <button data-wizard="#wizard1" class="btn btn-primary btn-space wizard-next">Next Step</button>
                          
                        </div>
					 
					 
                    </div>
                    <div data-step="2" class="step-pane">
						<h3>Product List(s)</h3>
						<table class="table table-bordered">
										<thead>
											<tr>
												<th style="min-width:40%;">Product</th>
												<th style="width:25%;">Quantity</th>
												<th style="width:5%;">Remark</th>
												<th style="width:5%;">Action</th>
											</tr>
										</thead>
										<tbody id="produt_list">
										</tbody>
										<tfoot>
											<tr>
												<th></th>
												<th></th>
												<th></th>
											
												<th>
													 <button onclick="addTemp();" type="button" class="btn btn-lg btn-rounded btn-primary"><i class="mdi mdi-plus"></i></button>
				 
												</th>
											</tr>
										</tfoot>
						</table>
						
					 <div class="form-group">
							<br/><br/>
                            <button data-wizard="#wizard1" class="btn btn-default btn-space wizard-previous">Previous</button>
                            <button data-wizard="#wizard1" class="btn btn-success btn-space" type="submit"><i class="mdi mdi-plus"></i> Complete</button>
                          
                        </div>
						
						
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
		</div>
					</div>
					<div class="panel-footer">
					</div>
			
</div>
</form>
</div>
