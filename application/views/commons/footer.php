
        
    </div><!-- ./wrapper -->
<footer class="main-footer">
<div class="pull-right hidden-xs">
          <b>Version</b> 1.0
        </div>
       <strong>Copyright &copy; 2017 Concept Photography.</strong> All rights reserved.
</footer>
    <!-- jQuery 2.1.3 -->
	<!--script src="<?php //echo base_url();?>assets/plugins/jQuery/jQuery-2.1.3.min.js"></script-->
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/js/select2.js"></script>
	<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
	<!--<script src="<?php echo base_url();?>assets/js/jquery-1.10.2.js"></script>-->
   <!-- Bootstrap WYSIHTML5 -->
	 <!-- Morris.js charts -->
    <script src="<?php echo base_url();?>assets/plugins/morris/morris.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/plugins/raphael-min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url();?>assets/dist/js/app.min.js" type="text/javascript"></script>
	<script>
      $body = $("body");

		$(document).on({
			ajaxStart: function () {
				$body.addClass("loading");
			},
			ajaxStop: function () {
				$body.removeClass("loading");
			}
		});
    </script>
	
<style>
	svg text{
      font-size:9px!important;
	}
</style>
  </body>
</html>
