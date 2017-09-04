
<!-- h1>
<?php// echo GROUPDESC ?>
<small><?php //echo USER_NAME;?> </small>
</h1-->


<!-- Content Wrapper. Contains page content -->
        <!-- Content Header (Page header) -->
         

        <!-- Main content -->
        <section class="content">
		 
		            	<?php
		foreach($results as $data) {
		?>
		  <!-- row -->
          <div class="row">
            <div class="col-md-12">
              <!-- The time line -->
              <ul class="timeline  box-info ">
                <!-- timeline time label -->
                <li class="time-label">
                  <span class="bg-red">
				 <?php echo $data->tanggal; ?>
                  </span>
                </li>
	
		
				
                <!-- /.timeline-label //  -->
                <!-- timeline item //fa fa-envelope bg-blue -->
                <li>
                  <i class="<?php echo $data->icon; ?>"></i>
                  <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i>    </span>
                    <h3 class="timeline-header"><a href="#"><?php echo $data->nama_divisi; ?></a> <?php echo $data->judul; ?></h3>
					
                    <div class="timeline-body" >
                     <?php 		$str =$data->artikel;
								$length = strlen($str);
								if ($length < 200) {
									$str .= str_repeat('&nbsp', 500 - $length);
								} else {
									$str = substr($str, 0,500);
								}
								echo $str."...."; ?> 
                    </div>
			
					<?php 	//	$dataframe = $data->frame;
								//echo htmlspecialchars_decode($dataframe); ?>
						<div class='timeline-footer'>
                      <a href="<?php echo base_url();?>read/baca_artikel?news_id=<?php echo $data->id; ?>" class="btn btn-primary btn-xs">Read more</a>
                      <!--a href="#" class="btn btn-danger btn-xs">Delete</a--> 
                    </div>
                  </div>
                </li>
                <!-- END timeline item -->
                <li>
                  <i class="fa fa-clock-o bg-gray"></i>
                </li>
              </ul>
			  
            </div><!-- /.col -->
          </div><!-- /.row -->
		  
	<?php
		}		?>
		<div style="text-align:center"><?php echo $pagination; ?></div>
		<div  style="text-align:right">Total Artikel: <?php echo $result_amount; ?></div>
        </section><!-- /.content -->
		
<script type="text/javascript">

function edit_post(){       	
	var y = document.getElementById("id_artikel").value;
	//alert(y);  
	window.location = "<?php echo base_url();?>news/edit_post/"+y;
	}  
</script>