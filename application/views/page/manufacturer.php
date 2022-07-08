<div class="row">
	<div class="col-sm-12">
		
		<div class="panel panel-default">
                <div class="panel-heading">Application Settings</div>
                <div class="tab-container">
                  <ul class="nav nav-tabs">
                    <li><a href="<?php  echo base_url('dashboard/user_manager') ?>">User Management</a></li>
                    <li class="active"><a href="<?php  echo base_url('dashboard/manufacturer') ?>" >Category</a></li>
					<li><a href="<?php  echo base_url('dashboard/branch') ?>">Branch</a></li>
					<li><a href="<?php  echo base_url('dashboard/extra_charges') ?>">Store Settings</a></li>
                  </ul>
				  <div class="tab-content">
                    <div id="home" class="tab-pane active cont">
					<div class="row">
						<div class="col-lg-6">
							<div class="panel">
								<div class="panel panel-heading">Category List(s)</div>
								<div class="panel-body">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>SN</th>
												<th>Category</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$num = 1;
											$manufac = $this->stock->getManufacturers();
											foreach($manufac as $manu){
											?>
											<tr>
												<td><?php echo $num; ?></td>
												<td><?php echo $manu['manufacturer'] ?></td>
												<td><a href="<?php echo base_url('dashboard/manufacturer/'.$manu['SN'].'?del=true') ?>" class="btn btn-danger">Delete</a></td>
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
						
						<div class="col-lg-6">
						<div class="panel">
								<div class="panel panel-heading">Add New Category</div>
								<div class="panel-body">
						<form action=""  method="post">
						
							<div class="form-group">
							  <label for="manufacturer" class="col-sm-12 control-label">Category</label>
							  <div class="col-sm-12">
								<input id="manufacturer" type="text" required name="manufacturer" placeholder="Manufacturer" class="form-control input-sm">
							  </div>
							</div>
							
							<div class="col-sm-12">
								<br/>
								<button class="btn btn-primary" type="submit">Add Category</button>
							</div>

						</form>
						
						</div>
							</div>
						</div>
					</div>
                  </div>
                </div>
              </div>
		
	</div>
