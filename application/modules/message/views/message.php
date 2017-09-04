<section class="content-header"><h1>Message<small>write</small></h1><ol class="breadcrumb"></section>  </br>
<?php    	
	echo $content; 
		?>	
<script type="text/javascript">



jQuery(document).on("xcrudafterrequest",function(event,container){
	
    if(Xcrud.current_task == 'save')
    { 
		// var message = jQuery("#message").val();
		// var from = jQuery("#from").val();
		// var subject = jQuery("#subject").val();
		// var to = jQuery("#to").val();
		// //alert(subject); 
		// $.ajax({
         // type: "POST",
         // url: "<?php echo base_url();?>message/email",
         // data: {subject: $("#subject").val() , message: $("#message").val() ,from: $("#from").val() ,to: $("#to").val() },
		 
		 
         // dataType: "text",  
         // cache:false,
         // success: 
              // function(data){
               // alert(to);  //as a debugging message.
              // }
          // });// you have missed this bracket
	 Xcrud.show_message(container,'Message Send ','success');
    }
});
 
</script>