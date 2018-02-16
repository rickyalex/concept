<section class="content-header">
	<h1>QMS<small>Audit Internal</small></h1>
	<ol class="breadcrumb">
</section></br>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-body">
					<?php echo $content; ?>	
				</div>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
	jQuery(document).on("xcrudafterrequest",function(event,container){
		// if(Xcrud.current_task == 'edit')
		// {
			// var id = jQuery("#id").val();
			// jQuery.ajax({
				// type: "POST",
				// dataType: "text",
				// data: { id:id },
				// url: "<?php echo base_url();?>audit_internal/check_deadline/",
				// success: function(response) {
					// console.log(response);
					// if(response==1){
						// jQuery('#action_recommendation').prop('disabled',true);
					// }
					// else{
						// jQuery('#action_recommendation').prop('disabled',false);
					// }
				// },
				// error: function(response){
				// }
			// });
		// }
	});
	jQuery(document).on("xcrudafterrequest",function(event,container){
		if(Xcrud.current_task == 'save')
		{
			Xcrud.show_message(container,'Record berhasil disimpan ','success');
		}
	});
</script>

<script type="text/javascript">
	jQuery(document).on("xcrudafterrequest",function(){	
		//alert(jQuery('#lead_auditor').val());
		//alert(<?php echo USER_ID; ?>);
		var access_group = '<?php echo access_group; ?>';
		if(access_group!="D_18"){
			if(jQuery('#lead_auditor').val()!=<?php echo USER_ID; ?>)  jQuery('#action_recommendation').attr('disabled','disabled');
		}
		
		// jQuery("#youtube_url").change(function() {
			// var youtube_url = jQuery("#youtube_url").val();
			// console.log(youtube_url);
			// jQuery.ajax({
				// type: "POST",
				// dataType: "text",
				// data: { youtube_url:youtube_url },
				// url: "<?php echo base_url();?>news/get_icon/",
				// success: function(response) {
					// jQuery('#icon').val(response);
				// },
				// error: function(response){
				// }
			// });	
		// });
		// jQuery("#youtube_url").change(function() {
			// var youtube_url = jQuery("#youtube_url").val();
			// console.log(youtube_url);
			// jQuery.ajax({
				// type: "POST",
				// dataType: "text",
				// data: { youtube_url:youtube_url },
				// url: "<?php echo base_url();?>news/get_frame/",
				// success: function(response) {
					// jQuery('#frame').val(response);
				// },
				// error: function(response){
				// }
			// });	
		// });
	});	
</script>