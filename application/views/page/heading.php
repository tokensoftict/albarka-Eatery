<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo $this->settings->getSettings()['slogo']  ?>">
    <title><?php echo APP_NAME  ?></title>
    <link rel="stylesheet" type="text/css" href="<?php  echo base_url('assets/lib/perfect-scrollbar/css/perfect-scrollbar.min.css')  ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php  echo base_url('assets/lib/material-design-icons/css/material-design-iconic-font.min.css'); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php  echo base_url('assets/lib/jquery.vectormap/jquery-jvectormap-1.2.2.css') ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php  echo base_url('assets/lib/jqvmap/jqvmap.min.css')?>"/>
    <link rel="stylesheet" type="text/css" href="<?php  echo base_url('assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php  echo base_url('assets/lib/summernote/summernote.css') ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php  echo base_url('assets/lib/select2/css/select2.min.css') ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/lib/jquery.gritter/css/jquery.gritter.css')  ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/lib/jquery.gritter/css/jquery.gritter.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/lib/select2/css/select2.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css') ?>" type="text/css"/>
  </head>
  <body>
  <div class="be-wrapper be-nosidebar-left">
	<nav class="navbar navbar-default navbar-fixed-top be-top-header">
        <div class="container-fluid">
          <div class="navbar-header"><a href="<?php echo base_url(base_url('admin/dashboard'))  ?>" class="navbar-brand">
			<img src="<?php echo $this->settings->getSettings()['slogo'];  ?>" height="60"/>
		  </a></div>
          <div class="be-right-navbar"><div class="page-title" >
		  <?php
		  if($this->stock->getBranch_id()!="0"){
		  ?>
		  <span style="margin-left:120px;">
		  Branch :<b style="color:blue;"><?php
			echo $this->stock->getBranch_name($this->stock->getBranch_id());
		  ?></b></span> 
		  <?php
		  }
		  ?>
		  
		  <span style="margin-left:50px;"> User Role :<b style="color:green;"><?php
			echo $this->users->get_user_by_username($this->session->userdata("username"))->role;
		  ?></b></span>
		 </div>
            <ul class="nav navbar-nav navbar-right be-user-nav">
              <li class="dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"><img src="<?php echo base_url('assets/img/avatar.png');  ?>" alt="Avatar"><span class="user-name"><?php echo $this->tank_auth->get_username() ?></span></a>
                <ul role="menu" class="dropdown-menu">
                  <li>
                    <div class="user-info">
					
                      <div class="user-name"><?php echo $this->tank_auth->get_username() ?></div>
                      <div class="user-position online">Available</div>
                    </div>
                  </li>
                  <li><a href="<?php  echo base_url('dashboard/myprofile'); ?>"><span class="icon mdi mdi-face"></span> My Profile</a></li>
                  <li><a href="<?php  echo base_url('auth/logout/'); ?>"><span class="icon mdi mdi-power"></span> Logout</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </nav>
<div class="be-content">

<div class="row">
<?php  
	$this->load->view("page/sidelinks");
?>
<div class="col-lg-9" style="padding-right:43px;">
<br/>
<?php  
	$this->load->view("page/".$page);
?>
</div>
</div>
