<section class="content-header">
	<h1>QMS<small>Audit Internal<?php echo 'divisi'; ?></small></h1>
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
		if(Xcrud.current_task == 'create' || Xcrud.current_task == 'edit')
		{
			//jQuery('#reporter').val('<?php echo USER_NAME; ?>');
			jQuery('#register').val('<?php echo USER_NAME; ?>');//register berdasar yang login
		}
	});
	//=======================================================================================================
	jQuery(document).on("xcrudafterrequest",function(event,container){
		if(Xcrud.current_task == 'create' || Xcrud.current_task == 'edit')
		{
			
		}
	});
	//=======================================================================================================
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