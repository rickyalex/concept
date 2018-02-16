<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Concept Photography | Store Management System</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
	<link href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" /> 
	<link href="<?php echo base_url();?>assets/bootstrap-table-develop/dist/bootstrap-table.css" rel="stylesheet" type="text/css" /> 
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />   	
	<link href="<?php echo base_url();?>assets/css/select2.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>assets/css/jquery-ui.css" rel="stylesheet" >
	<link href="<?php echo base_url();?>assets/css/custom.css" rel="stylesheet" >
	
    <!-- FontAwesome 4.3.0 -->
	
	
    <!--link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" /-->
    <!-- Ionicons 2.0.0 -->
    <!--link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" /-->    
    <!-- Theme style -->
    <link href="<?php echo base_url();?>assets/dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo base_url();?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <!--link href="<?php echo base_url();?>assets/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" /-->
    <!-- Morris chart -->
    <link href="<?php echo base_url();?>assets/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="<?php echo base_url();?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Date Picker -->
    <!--<link href="<?php echo base_url();?>assets/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />-->
    <!-- Daterange picker -->
    <!--<link href="<?php echo base_url();?>assets/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />-->
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="<?php echo base_url();?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/jQuery/jQuery-2.1.3.min.js"></script>
	<script src="<?php echo base_url();?>assets/bootstrap-table-develop/dist/bootstrap-table.js"></script>
	<script src="<?php echo base_url();?>assets/bootstrap-table-develop/src/extensions/filter-control/bootstrap-table-filter-control.js"></script>
	<script src="<?php echo base_url();?>assets/bootstrap-table-develop/src/extensions/export/bootstrap-table-export.js"></script>
	<script src="<?php echo base_url();?>assets/export/master_tableExport.js"></script>
	
	
	
	<!--script src="https://apis.google.com/js/plusone.js"></script-->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    
    <?php 
    $css_files = isset($css_files) ? $css_files : "";
    $js_files = isset($js_files) ? $js_files : "";
    if($css_files != "" && $js_files != ""){
		foreach($css_files as $file): ?>
		<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
	 
	<?php endforeach; ?>
	<?php foreach($js_files as $file): ?>
	 
		<script src="<?php echo $file; ?>"></script>
	<?php endforeach; ?>
	<?php
	}
	?>
	
	<style>
		li.dropdown a i.fa{
			margin-right: 7px;
		}
		
		.modal {
			display:    none;
			position:   fixed;
			z-index:    1000;
			top:        0;
			left:       0;
			height:     100%;
			width:      100%;
			background: rgba( 255, 255, 255, .8 ) 
				url('assets/img/FhHRx.gif') 
				50% 50% 
				no-repeat;
		}
	</style>
	
	<?php if($mode=="pos"){ ?>
	<style>
		
		input.form-control{
			width: 200px;
			height: 30px;
		}
		
		img:hover{
			cursor: pointer;
		}
	</style>
	<?php } ?>
	
  </head>
   <body class="skin-blue layout-top-nav">
    <div class="wrapper">
      <header class="main-header">
        
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <!-- Logo -->
		  <a href="<?php echo base_url();?>dashboard" class="logo">Concept Photo</a>
          <?php if($mode!="pos"){ ?>
		  <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              
              <!-- Notifications: style can be found in dropdown.less -->
              <!-- Navbar Right Menu -->
         
              <!-- Tasks: style can be found in dropdown.less -->
             
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="<?php echo base_url();?>profile" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo base_url();?>uploads/<?php echo foto;?>" class="user-image" alt="User Image"/>
                  <span class="hidden-xs"><?php echo USER_NAME;?> </span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <a href="<?php echo base_url();?>profile" style="text-decoration:none;background-color:#3c8dbc"><img src="<?php echo base_url();?>uploads/<?php echo foto;?>" class="img-circle" alt="User Image" width="80"/></a>
                    <p>
                     <?php echo USER_NAME;?> -<?php echo email;?>
                      <small>Member since Mar. 2017</small>
                    </p>
                  </li>
                  <!-- Menu Body -->

                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="<?php echo base_url();?>auth/change_password" class="btn btn-default btn-flat"> <i class="glyphicon glyphicon-edit"> </i>  Change Password</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?php echo base_url();?>auth/logout" class="btn btn-default btn-flat"><i class="glyphicon glyphicon-off"> </i> Sign out</a>
                    </div><br>
					<a href="<?php echo base_url();?>auth/change_confirmation" class="btn btn-default btn-flat"><i class="glyphicon glyphicon-link"> </i> Change Confirmation Code</a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
		  <?php } ?>
          <div class="navbar-custom-menu navbar-left">
            <ul class="nav navbar-nav">
				
				<?php if($mode!="pos"){ ?>
					<li class="active"><a href="<?php echo base_url();?>dashboard">Dashboard <span class="sr-only">(current)</span></a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-database"></i> Master <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
						  <li><a href="<?php echo base_url();?>product"><i class="fa fa-archive"></i>Product</a></li>
						  <li><a href="<?php echo base_url();?>type"><i class="fa fa-list"></i>Type</a></li>
						  <li><a href="<?php echo base_url();?>category"><i class="fa fa-sort-amount-desc"></i>Category</a></li>
						  <li><a href="<?php echo base_url();?>vendor"><i class="fa fa-briefcase"></i>Vendor</a></li>
						  <li><a href="<?php echo base_url();?>package"><i class="fa fa-folder"></i>Package</a></li>
						  <li><a href="<?php echo base_url();?>users"><i class="fa fa-group"></i>Users</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Inquery <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
						  <li><a href="<?php echo base_url();?>inventory"><i class="fa fa-cubes"></i>Inventory</a></li>
						  <li><a href="<?php echo base_url();?>receive_slip"><i class="fa fa-sign-in"></i>Receive Slip</a></li>
						  <?php /*<li><a href="<?php echo base_url();?>purchase_order"><i class="fa fa-dollar"></i>Purchase Order</a></li> */ ?>
						  <li><a href="<?php echo base_url();?>history"><i class="fa fa-search"></i>History</a></li>
						  <li><a href="<?php echo base_url();?>trans_display"><i class="fa fa-bars"></i>Transaction</a></li>
						</ul>
					</li>
					<?php if(access=="admin"){ ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bullhorn"></i> Reports <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?php echo base_url();?>reports/daily_orders"><i class="fa fa-bars"></i>Daily Orders</a></li>
							<li><a href="<?php echo base_url();?>reports/outstanding_report"><i class="fa fa-bars"></i>Outstanding Orders</a></li>
							<li><a href="<?php echo base_url();?>reports/cancel_report"><i class="fa fa-bars"></i>Cancel Orders</a></li>
							<li><a href="<?php echo base_url();?>reports/daily_reports"><i class="fa fa-bars"></i>Daily Reports</a></li>
                            <li><a href="<?php echo base_url();?>reports/monthly_reports"><i class="fa fa-bars"></i>Monthly Reports</a></li>
                            <li><a href="<?php echo base_url();?>reports/monthly_income"><i class="fa fa-bars"></i>Monthly Income</a></li>
						</ul>
					</li>
					<?php } ?> 
				<?php } ?>
				
			</ul>
		  </div>
          
		   <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <span id="time" style="color:#fff;display:block;text-align:center;margin:15px">
              </span>
			</div>
        </nav>
      </header>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
     

        <!-- Main content -->
        <!-- /.content -->
      <!-- /.content-wrapper -->
<script>
	setInterval(function() {
		$('#time').text(new Date(Date.now()).toLocaleString());
	}, 1000);
</script>
