<section class="content-header">
<h1>
QMS
<small>News & Event</small>
</h1>
<ol class="breadcrumb">
</section></br>
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
    if(Xcrud.current_task == 'save')
    {
        Xcrud.show_message(container,'News Published ','success');
    }
});

</script>
<script type="text/javascript">
jQuery(document).on("xcrudafterrequest",function(){	
	jQuery("#youtube_url").change(function() {
		var youtube_url = jQuery("#youtube_url").val();
		console.log(youtube_url);
		jQuery.ajax({
			type: "POST",
			dataType: "text",
			data: { youtube_url:youtube_url },
			url: "<?php echo base_url();?>news/get_icon/",
			success: function(response) {
				jQuery('#icon').val(response);
			},
			error: function(response){
			}
		});	
	});
	jQuery("#youtube_url").change(function() {
		var youtube_url = jQuery("#youtube_url").val();
		console.log(youtube_url);
		jQuery.ajax({
			type: "POST",
			dataType: "text",
			data: { youtube_url:youtube_url },
			url: "<?php echo base_url();?>news/get_frame/",
			success: function(response) {
				jQuery('#frame').val(response);
			},
			error: function(response){
			}
		});	
	});
});	
</script>