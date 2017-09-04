<section class="content-header"><h1>Message<small>Draft</small></h1><ol class="breadcrumb"></section>  </br>
<span class="help-block"> <?php echo form_error('penerima');  echo form_error('subject');  ?> </span>
<span class="help-block"> <?php echo form_error('success');?> </span>
 <form name="form-validate" class="form-validate" method="post" action="<?php echo site_url(); ?>pesan/add">
 <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Compose New Message</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="form-group">
   	<?php $attrib = array('class' => 'form-horizontal'); echo form_open("pesan", $attrib);?>
		      <?php foreach($results as $data) { //get data dari draft?>
						<select class="form-control" name="penerima" value="<?php echo set_value('penerima'); ?>"id="penerima">
							<option value="">Choose a Receive</option>
 <?php		foreach ($view_users->result() as $a) { ?>  
							<option value="<?php echo $data->to; ?><?php echo  $a->id; ?>"><?php echo  $a->nama; ?></option> <?php } ?>	
						</select>
                  </div>
                  <div class="form-group">
			<input type="text" name="subject" value="<?php echo $data->subject; ?>" class="form-control" placeholder="Subject:">
                  </div>
                  <div class="form-group">
                    <textarea name="message" id="message" value="<?php echo $data->message; ?><?php echo set_value('message'); ?>"id="compose-textarea" class="form-control" style="height: 300px">
                     
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
						</form><?php } ?>
 <div class="row">
          
            </div><!-- ./col -->	<?php echo form_close(); ?>	
