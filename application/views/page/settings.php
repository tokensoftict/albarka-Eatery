<div class="row">
	<div class="col-sm-12">
		
		<div class="panel panel-default">
                <div class="panel-heading">Application Settings</div>
                <div class="tab-container">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="<?php  echo base_url('dashboard/user_manager') ?>">User Management</a></li>
					<li><a href="<?php  echo base_url('dashboard/extra_charges') ?>">Store Settings</a></li>
                  </ul>
				  <div class="tab-content">
                    <div id="home" class="tab-pane active cont">
					<div class="row">
					<div class="col-lg-12">
					<div class="panel">
								<div class="panel panel-heading">User List(s)</div>
								<div class="panel-body">
						<table class="table table-bordered">
						<thead>
							<tr>
								<th>SN</th>
								<th>Username</th>
								<th>Email</th>
								<th>Role</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						<thead>
						<?php
						$num =1;
						$status = array(
										'0'=>'<span class="label label-danger">Disabled</span>',
										'1'=>'<span class="label label-success">Enabled</span>'
									);
						$num = 1;
						$users = $this->db->from("users")->get();
						foreach($users->result_array() as $user){
						?>
						<tr>
							<td><?php  echo $num; ?></td>
							<td><?php echo $user['username'] ?></td>
							<td><?php echo $user['email'] ?></td>
							<td><?php echo $user['role'] ?></td>
							<td><?php echo $status[$user['activated']] ?></td>
							<td>
							<?php  if($user['activated']=="1"){ ?>
							<a href="<?php echo base_url('dashboard/settings/'.$user['id'].'?del=0') ?>" class="btn btn-sm btn-danger">Disable</a>
							<?php }else{ ?>
							<a href="<?php echo base_url('dashboard/settings/'.$user['id'].'?del=1') ?>" class="btn btn-sm btn-success">Enable</a>
							<?php } ?>
							<a href="<?php echo base_url('dashboard/edit_settings/'.$user['id']) ?>" class="btn btn-sm btn-primary">Edit User</a>
							</td>
						</tr>
						
						<?php
						$num++;
						}
						?>
						</table>
						</div>
						</div>
						</div>
						<div class="col-lg-12">
								<div class="panel">
								<div class="panel panel-heading">Add User(s)</div>
								<div class="panel-body">
									<form action="<?php  echo base_url('dashboard/settings');  ?>" method="post" accept-charset="utf-8">
											<div class="form-group">
											<label>Username</label>
												<input type="text" name="username" autocomplete="OFF" value="" id="username" maxlength="20" size="30" required="" placeholder="Username" autocomplete="off" class="input-sm form-control">
											 </div>
											<div class="form-group">
											<label>Email Address</label>
												 <input type="text" name="email" value="" autocomplete="OFF"  id="email" maxlength="80" size="30" required="" placeholder="E-mail" autocomplete="off" class="input-sm form-control">
											</div>
												<div class="form-group">
														<label>Password</label>
														  <input type="password" name="password" value="" id="password" maxlength="20" size="30" required="" class="input-sm form-control" placeholder="Password">
													  </div>
												<div class="form-group">
														<label>Role</label>
														 <select required class="form-control input-sm" required name="role">
															<option>-Select Role-</option>
															<option value="Sales Representative">Sales Representative</option>
															<option value="Administrator">Administrator</option>
														 </select>
													</div>	  
									
													  <div class="form-group xs-pt-10">
														<input type="submit" value="Add User" class="btn btn-block btn-primary btn-xl">
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