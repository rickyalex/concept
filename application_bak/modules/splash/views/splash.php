<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Concept Photography | Welcome</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url();?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?php echo base_url();?>assets/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
	<!-- Custom -->
    <link href="<?php echo base_url();?>assets/css/custom.css" rel="stylesheet" type="text/css" />
  </head>
  
  
  

    
  <body class="login-page">
	<div class="splash-box">
      <div class="login-logo">

		<div class="login-box-body">
	  
			<div style="display: block;margin: 0 auto;"><img src ="<?php echo base_url();?>assets/img/login_logo.png" width="300" height="77" style="display: block;margin: 0 auto;" >
				<h3>Select Your Login</h3>
			</div>
			
			<div id='contents' style="margin: 10% 0;">
				<div class='row'>
					<div class='col-sm-12'>
						<img id="pos" onclick="window.open('<?php echo base_url(); ?>auth/login/mode/pos','_parent');" src ="<?php echo base_url();?>assets/img/pos.png" width="150" height="150" style="border: #fff solid 1px" >
						<img id="bo" onclick="window.open('<?php echo base_url(); ?>auth/login/mode/bo','_parent');" src ="<?php echo base_url();?>assets/img/bo.png" width="150" height="150" style="border: #fff solid 1px" >
					</div>
				</div>
			</div>
		</div>   

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.3 -->
    <script src="<?php echo base_url();?>assets/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url();?>assets/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script>
    </script>
  </body>
</html>