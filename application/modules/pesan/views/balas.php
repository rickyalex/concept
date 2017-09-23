<section class="content-header"><h1>Message<small>Reply</small></h1><ol class="breadcrumb"></section>  </br>
<span class="help-block"> <?php echo form_error('penerima');  echo form_error('subject');  ?> </span>
<span class="help-block"> <?php echo form_error('success');?> </span>
 <form name="form-validate" class="form-validate" method="post" action="<?php echo site_url(); ?>pesan/balas">
 <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Compose New Message</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="form-group">
   	<?php $attrib = array('class' => 'form-horizontal'); echo form_open("pesan", $attrib);?>
						<select class="form-control" name="penerima" value="<?php echo set_value('penerima'); ?>"id="penerima">
							<option value="">Choose a Receive</option>
 <?php		foreach ($view_users->result() as $data) { ?>  
							<option value="<?php echo  $data->id; ?>"><?php echo  $data->nama; ?></option> <?php } ?>	
						</select>
                  </div>
                  <div class="form-group">
			<input type="text" name="subject" value="<?php echo set_value('subject'); ?>" class="form-control" placeholder="Subject:">
                  </div>
                  <div class="form-group">
                    <textarea name="message" value="<?php echo set_value('message'); ?>"id="compose-textarea" class="form-control" style="height: 300px">
                     
                    </textarea>
                  </div>
                  <div class="form-group">
                    <div class="btn btn-default btn-file">
                      <i class="fa fa-paperclip"></i> Attachment
                      <input type="file" name="attachment"/>
                    </div>
                    <p class="help-block">Max. 32MB</p>
                  </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">
                    <button class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button>
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-envelope-o"></i> Send</button>
                  </div>
                  <button class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                </div><!-- /.box-footer -->
              </div><!-- /. box -->
            </div><!-- /.col -->
</form>
 <div class="row">
          
            </div><!-- ./col -->	<?php echo form_close(); ?>	
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#po_item_id").change(function() {
		var po_item_id = jQuery("#po_item_id").val();
		console.log(po_item_id);
		jQuery.ajax({
			type: "POST",
			dataType: "text",
			data: { po_item_id:po_item_id },
			url: "<?php echo base_url();?>grn/get_unit/",
			success: function(response) {
				jQuery('#unit').val(response);
			},
			error: function(response){
			}
		});	
	});
});
</script>