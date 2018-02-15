
<section class="content-header">
    <div class="row">
		<div class="col-xs-4 col-sm-4 col-md-4">
			<h4>Display Transaction</h4>
		</div>
	</div>
    <ol class="breadcrumb">
</section>
<section class="content">
    <table id="table"
           data-toolbar="#toolbar"
           data-toggle="table"
           data-search="true"
           data-show-refresh="true"
           data-show-toggle="true"
           data-show-columns="true"
           data-show-export="true"
           data-minimum-count-columns="2"
           data-show-pagination-switch="true"
           data-pagination="true"
           data-page-list="[10, 25, 50, 100, ALL]"
           data-show-footer="false"
           data-export-data-type="all"
           data-export-types="['excel']"
           data-height="500"
           data-url="<?php echo base_url(); ?>trans_display/getData">
        <thead>
            <tr>
                <th data-field="id">ID</th>
                <th data-field="order_no">Order No</th>
                <th data-field="customer_name">Customer Name</th>
				<th data-field="status">Status</th>
				<th data-field="date">Date</th>
				<th data-field="receive_date">Receive Date</th>
				<th data-field="total">Total</th>
                <th data-field="action">Action</th>
            </tr>
        </thead>
    </table><br><br>
	<div class="modal"><!-- Place at bottom of page --></div>
</section>
<script>
	var $table = $('#table');
    $table.on('click-row.bs.table', function (row, $element) {
		
	});
	
	$('body').keydown(function(event) {
		
	});

    $(document).on('click', '.remove', function (e){
      //if(field=='action'){
      var id = $(this).parent().siblings(":first").text();
      var r = confirm("Are you sure Delete this data?");
      if (r == true) {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url();?>trans_display/remove/id/"+id,
          success: function(res){
            alert(res);
            // if (s.match(/.*Success/)) {
              location.reload();
            // }
          }
          ,
          error: function(e){
            alert('Delete Error');
          }
        });
      }
    });
</script>
