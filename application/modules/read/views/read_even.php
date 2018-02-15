	<div class="no-border">
<?php foreach($results as $data) { ?>
 <section class="content-header"><h1><?php echo $data->judul;?><small></small></h1><ol class="breadcrumb"></section>  </br>
          <!--div class="callout callout-info">
            <h4>Warning!</h4>
            <p>This documentation is under development. Some information may change as the progress of creating the documentation continues.</p>
          </div--> 
          <!-- Default box -->
		
		 <div  class="col-md-8">
          <div class="box box-info ">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $data->judul;?></h3> 
				<div>
					<small style="text-align:right">Author :<cite title="Source Title"> <?php echo $data->author;?> </cite>  <cite title="Source Title"></cite></small></div>
              <div class="box-tools pull-right" >
				
			   <!--button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button-->
               <?php if(access == "admin" ){ ?>  <button id="id_artikel" value="<?php echo $data->id;?>" onclick="edit_post()" class="btn btn-box-tool" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button> <?php } ?>
              </div>
			   <div class="box-body"> <span><img src="<?php echo base_url();?>uploads/<?php echo $data->gambar;?>" align="left" class="thumbnail" alt="User Image"/></span>
		<?php echo $data->artikel;?> 
           </div> <!-- /.box-body -->
		
            </div>
			<!--testbuka -->
<div class="box box-solid">
                <div class="box-body">
                  <div class="box-group" id="accordion">
                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                    <div class="panel box box-primary">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a class="" aria-expanded="true" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                           Master Schedule
                          </a>
                        </h4>
                      </div>
                      <div style="" aria-expanded="true" id="collapseOne" class="panel-collapse collapse in">
                        <div class="box-body">
	<!--schedule  -->
						<span><a href="<?php echo base_url();?>uploads/<?php echo $data->schedule;?>" target="_blank" ><img src="<?php echo base_url();?>uploads/<?php echo $data->schedule;?>" class="thumbnail" align="left" width="250" height="150" alt="User Image"/></a></span>  
						<span><a href="<?php echo base_url();?>uploads/<?php echo $data->schedule2;?>" target="_blank" ><img src="<?php echo base_url();?>uploads/<?php echo $data->schedule2;?>" class="thumbnail" align="left"   width="250" height="150" alt="User Image"/></a></span> <div></div>
						<span><a href="<?php echo base_url();?>uploads/<?php echo $data->schedule3;?>" target="_blank" ><img src="<?php echo base_url();?>uploads/<?php echo $data->schedule3;?>" class="thumbnail" align="none"   width="250" height="150" alt="User Image"/></a></span> 
						<?php echo $data->des_schedule;?> 
						</div>
                      </div>
                    </div>
                    <div class="panel box box-danger">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a aria-expanded="false" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                            Team & Schedule Audit
                          </a>
                        </h4>
                      </div>
                      <div style="height: 0px;" aria-expanded="false" id="collapseTwo" class="panel-collapse collapse">
                        <div class="box-body">
                        <span><img src="<?php echo base_url();?>uploads/<?php echo $data->pelaksanaan;?>" class="thumbnail"  width="900" height="1100" alt="User Image"/></span>
						<?php echo $data->des_pelaksanaan;?> 
						</div>
                      </div>
                    </div>
                    <div class="panel box box-success">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a aria-expanded="false" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                            Pemberitahuan Audit
                          </a>
                        </h4>
                      </div>
                      <div style="height: 0px;" aria-expanded="false" id="collapseThree" class="panel-collapse collapse">
                        <div class="box-body">
                          <span><img src="<?php echo base_url();?>uploads/<?php echo $data->sp_audit;?>" class="thumbnail"  width="900" height="1100" alt="User Image"/></span>
						 </div>
                      </div>
                    </div>
					 <div class="panel box box-success">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a aria-expanded="false" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                           Internal Audit Ceklis
                          </a>
                        </h4>
                      </div>
                      <div style="height: 0px;" aria-expanded="false" id="collapseFive" class="panel-collapse collapse">
                        <div class="box-body">
                          <span><img src="<?php echo base_url();?>uploads/<?php echo $data->ceklis;?>" class="thumbnail"  width="900" height="1100" alt="User Image"/></span>
						 </div>
                      </div>
                    </div>
					 <div class="panel box box-success">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a aria-expanded="false" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
                           NCR
                          </a>
                        </h4>
                      </div>
                      <div style="height: 0px;" aria-expanded="false" id="collapseSix" class="panel-collapse collapse">
                        <div class="box-body">
                        <span><a href="<?php echo base_url();?>uploads/<?php echo $data->ncr;?>" target="_blank" ><img src="<?php echo base_url();?>uploads/<?php echo $data->ncr;?>" align="left" class="thumbnail"  width="400" height="250" alt="User Image"/></a></span>  
						<span><a href="<?php echo base_url();?>uploads/<?php echo $data->ncr2;?>" target="_blank" ><img src="<?php echo base_url();?>uploads/<?php echo $data->ncr2;?>"  align="none"  class="thumbnail"  width="400" height="250" alt="User Image"/></a></span> 
						<span><a href="<?php echo base_url();?>uploads/<?php echo $data->ncr3;?>" target="_blank" ><img src="<?php echo base_url();?>uploads/<?php echo $data->ncr3;?>"  align="left" class="thumbnail" width="400" height="250" alt="User Image"/></a></span> 
						<span><a href="<?php echo base_url();?>uploads/<?php echo $data->ncr4;?>" target="_blank" ><img src="<?php echo base_url();?>uploads/<?php echo $data->ncr4;?>"  align="none" class="thumbnail"  width="400" height="250" alt="User Image"/></a></span>  
						<span><a href="<?php echo base_url();?>uploads/<?php echo $data->ncr5;?>" target="_blank" ><img src="<?php echo base_url();?>uploads/<?php echo $data->ncr5;?>"  align="left" class="thumbnail"  width="400" height="250" alt="User Image"/></a></span>  
						<span><a href="<?php echo base_url();?>uploads/<?php echo $data->ncr6;?>" target="_blank" ><img src="<?php echo base_url();?>uploads/<?php echo $data->ncr6;?>"  align="none" class="thumbnail"  width="400" height="250" alt="User Image"/></a></span>  
						<span><a href="<?php echo base_url();?>uploads/<?php echo $data->ncr7;?>" target="_blank" ><img src="<?php echo base_url();?>uploads/<?php echo $data->ncr7;?>"  align="left"  class="thumbnail"  width="400" height="250" alt="User Image"/></a></span>  
						<span><a href="<?php echo base_url();?>uploads/<?php echo $data->ncr8;?>" target="_blank" ><img src="<?php echo base_url();?>uploads/<?php echo $data->ncr8;?>"   align="none"  class="thumbnail"  width="400" height="250" alt="User Image"/></a></span>  
						<span><a href="<?php echo base_url();?>uploads/<?php echo $data->ncr9;?>" target="_blank" ><img src="<?php echo base_url();?>uploads/<?php echo $data->ncr9;?>"  align="left" class="thumbnail"  width="400" height="250" alt="User Image"/></a></span>  
						<span><a href="<?php echo base_url();?>uploads/<?php echo $data->ncr10;?>" target="_blank" ><img src="<?php echo base_url();?>uploads/<?php echo $data->ncr10;?>"  align="none"class="thumbnail"  width="400" height="250" alt="User Image"/></a></span>  
						  </div>
                      </div>
                    </div>
					 <div class="panel box box-success">
                      <div class="box-header with-border">
                        <h4 class="box-title">
                          <a aria-expanded="false" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">
                           Rangkuman
                          </a>
                        </h4>
                      </div>
                      <div style="height: 0px;" aria-expanded="false" id="collapseSeven" class="panel-collapse collapse">
                        <div class="box-body">
                        <span ><a href="<?php echo base_url();?>uploads/<?php echo $data->rangkuman;?>" target="_blank" ><img src="<?php echo base_url();?>uploads/<?php echo $data->rangkuman;?>" class="thumbnail" align="left" width="300" height="150" alt="User Image"/></a></span>  
						<span><a href="<?php echo base_url();?>uploads/<?php echo $data->rangkuman2;?>" target="_blank" ><img src="<?php echo base_url();?>uploads/<?php echo $data->rangkuman2;?>" class="thumbnail" align="left"  width="300" height="150" alt="User Image"/></a></span> 
						<span><a href="<?php echo base_url();?>uploads/<?php echo $data->rangkuman3;?>" target="_blank" ><img src="<?php echo base_url();?>uploads/<?php echo $data->rangkuman3;?>" class="thumbnail"  width="300" height="150" alt="User Image"/></a></span> 
						<span><a href="<?php echo base_url();?>uploads/<?php echo $data->rangkuman4;?>" target="_blank" ><img src="<?php echo base_url();?>uploads/<?php echo $data->rangkuman4;?>" class="thumbnail"  width="300" height="150" alt="User Image"/></a></span> 
						<?php echo $data->des_rangkuman;?> 
						</div>
                      </div>
                    </div>
                  </div>
                </div><!-- /.box-body -->
           </div>	<?php }?> 		
			<!--test tutup --> 
            <!-- /.box-body 490118BC15-->
            <div class="box-footer">
             <small style="text-align:center">Author :<cite title="Source Title"> <?php echo $data->author;?> </cite></small>
            </div>
			<div class="box-header with-border">
			<!-- Posicione esta tag no cabeçalho ou imediatamente antes da tag de fechamento do corpo. -->
			<script src="https://apis.google.com/js/platform.js" async defer>
			  {lang: 'id'}
			</script>

			<!-- Posicione esta tag onde você deseja que o botão +1 apareça. -->
			<div class="g-plusone" data-size="medium" data-annotation="inline" data-width="300"></div>
			</div>
			<!--div class="box-footer">
			<!--script src="https://apis.google.com/js/plusone.js"></script-->
			<!--div class="g-comments" data-href="http://<?php
															//$request_url = apache_getenv("HTTP_HOST") . apache_getenv("REQUEST_URI");
															//echo $request_url;
															?>" data-width="900" data-first_party_property="BLOGGER" data-view_type="FILTERED_POSTMOD">
			</div-->
			 <!--div class="fb-comments" data-href="http://<?php
															// $request_url = apache_getenv("HTTP_HOST") . apache_getenv("REQUEST_URI");
															// echo $request_url;
															?>" data-width="100%" data-numposts="5">
			  </div-->
			</div>
		
			 
          </div><!-- /.box -->
        </div>
	  <!-- quick email widget -->
	
	<!-- /Widget-->
	
	
	 <div class="col-md-4">
              <!-- PRODUCT LIST -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"> Info Terkait</h3>
                  <div class="box-tools pull-right">
                    <!--button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button-->
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <ul class="products-list product-list-in-box">
				  <?php		foreach ($test->result() as $row)
							{ ?>                           <!-- loop artikel terbaru-->
                    <li class="item">
                      <div class="product-img">
                        <img src="<?php echo base_url();?>uploads/<?php echo  $row->gambar; ?>" alt="Bcs Art Image"/>
                      </div>
                      <div class="product-info"> 	
                        <a href="<?php echo base_url();?>read/baca_artikel?news_id=<?php echo $row->id; ?>" class="product-title"><?php echo  $row->judul_widget; ?><span class="label label-warning pull-right"><?php echo  $row->tanggal; ?></span></a>
                        <span class="product-description">
                <?php 			$str =$row->artikel;
								$length = strlen($str);
								if ($length < 200) {
									$str .= str_repeat('&nbsp', 500 - $length);
								} else {
									$str = substr($str, 0,300);
								}
								echo htmlspecialchars_decode ($str)."...."; ?> 
                        </span>
                      </div>
                    </li><!-- /.item -->
				   <?php    } ?>											 <!-- endloop artikel terbaru-->
                  </ul>
                </div><!-- /.box-body -->
                
              </div><!-- /.box -->
            </div><!-- /.col -->
			 <!-- Calendar -->
		 <!-- end carousoul botstrap  -->
<!-- /end calender-->		  
		 <div class="row">
          
            </div><!-- ./col -->
	
	</div><!-- ./col --> 
</section>

<script type="text/javascript">

function edit_post(){       	
	var y = document.getElementById("id_artikel").value;
	//alert(y);  
	window.location = "<?php echo base_url();?>news_even/edit_post/"+y;
	}  
</script>