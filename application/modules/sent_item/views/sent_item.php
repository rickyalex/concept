<section class="content-header"><h1>Sent Item<small>Sent Item</small></h1><ol class="breadcrumb"></section> 
<section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <!--div class="box-header">
                  <!--h3 class="box-title">News & Event</h3-->
                <!--/div--><!-- /.box-header -->
                <div class="box-body">
				
<?php    	
	echo $content; 
		?>	
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
jQuery(document).on("xcrudafterrequest",function(event,container){
    if(Xcrud.current_task == 'remove')
    {
        Xcrud.show_message(container,'Message deleted ','error');
    }
});

</script>