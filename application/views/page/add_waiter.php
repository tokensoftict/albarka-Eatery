<div class="row">
	<div class="col-sm-12">
		<form action="" enctype="multipart/form-data" method="post" >
		<div class="panel">
			 <div class="panel-heading">Add New Server
                 <div class="tools"><button type="submit" class="btn btn-lg btn-primary"><i class="mdi mdi-save"></i> Save Waiter</button></div>
              </div>
			  <div class="tab-container">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#home" data-toggle="tab">Data</a></li>
                  </ul>
                  <div class="tab-content">
                    <div id="home" class="tab-pane active cont">
					<div class="form-horizontal">
					
					<div class="form-group xs-mt-10">
                      <label for="product_name" class="col-sm-2 control-label">Name</label>
                      <div class="col-sm-10">
                        <input id="name" name="name" type="text" required  max="255" placeholder="Full Name" class="form-control input-sm">
                      </div>
                    </div>
					
					<div class="form-group xs-mt-10">
                      <label for="price" class="col-sm-2 control-label">Date of Birth</label>
                      <div class="col-sm-10">
                        <input id="date_of_birth" type="text" value="<?php echo date('Y-m-d'); ?>" name="date_of_birth" data-min-view="2" data-date-format="yyyy-mm-dd"  placeholder="Date of Birth" class="date form-control input-sm">
                      </div>
                    </div>
					<div class="form-group xs-mt-10">
                      <label for="price" class="col-sm-2 control-label">Joined Date</label>
                      <div class="col-sm-10">
                        <input id="joined_date" type="text" value="" name="joined_date" data-min-view="2" data-date-format="yyyy-mm-dd"  placeholder="Joined Date" class="date form-control input-sm">
                      </div>
                    </div>
					<div class="form-group xs-mt-10">
                      <label for="price" class="col-sm-2 control-label">Gender</label>
                      <div class="col-sm-10">
							<select class="form-control input-sm" name="gender">
								<option value="">Seleect One</option>
								<option value="Female">Female</option>
								<option value="Male">Male</option>
							</select>
                      </div>
                    </div>
                        <input id="salary" type="hidden" value="0" required name="salary"  placeholder="Salary" class="form-control input-sm">
					<!--
                        <div class="form-group xs-mt-10">
                      <label for="price" class="col-sm-2 control-label">Salary</label>
                      <div class="col-sm-10">
                        <input id="salary" type="number" required name="salary"  placeholder="Salary" class="form-control input-sm">
                      </div>
                    </div>
					   -->
					
					</div>
					
					</div>
                    

                    
                  </div>
                </div>
		</div>
		</form>
	</div>
</div>
