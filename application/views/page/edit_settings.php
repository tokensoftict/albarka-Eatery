<div class="row">
	<div class="col-sm-12">
		
		<div class="panel panel-default">
                <div class="panel-heading">Application Settings</div>
                <div class="tab-container">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="<?php  echo base_url('dashboard/user_manager') ?>">User Management</a></li>
					<li><a href="<?php  echo base_url('dashboard/extra_charges') ?>">Extra Charges</a></li>
                  </ul>
				  <div class="tab-content">
                    <div id="home" class="tab-pane active cont">
					<div class="row">
						<?php 
							$user =$this->users->get_user_by_id($this->uri->segment(3),1);
						?>
						<div class="col-lg-12">
								<div class="panel">
								<div class="panel panel-heading">Update User(s)</div>
								<?php 
									
								?>
								<div class="panel-body">
									<form action="<?php  echo base_url('dashboard/settings');  ?>" method="post" accept-charset="utf-8">
											<div class="form-group">
											<label>Username</label>
												<input type="text" name="username" value="<?php echo $user->username ?>" autocomplete="OFF" value="" id="username" maxlength="20" size="30" required="" placeholder="Username" autocomplete="off" class="input-sm form-control">
											 </div>
											<div class="form-group">
												 <input type="text" name="email" value="<?php echo $user->email?>" autocomplete="OFF"  id="email" maxlength="80" size="30" required="" placeholder="E-mail" autocomplete="off" class="input-sm form-control">
											</div>
											<?php
										if($user->role!="0"){
										?>
												<div class="form-group">
														<label>Role</label>
														 <select required class="form-control input-sm" required name="role">
															<option <?php echo ($user->role=="Sales Representative" ? 'selected' : '');  ?> value="Sales Representative">Sales Representative</option>
															<option <?php echo ($user->role=="Administrator" ? 'selected' : '');  ?> value="Administrator">Administrator</option>
														 </select>
													</div>
										<?php
										}
										?>
								
													  <div class="form-group xs-pt-10">
														<input type="submit" value="Update User" class="btn btn-block btn-primary btn-xl">
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
              </div>
		
	</div>
</div>