
<section class="content-header">
    <div class="row">
		<div class="col-xs-4 col-sm-4 col-md-4">
			<h4>Billed Transaction</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4 col-sm-4 col-md-4">
			<span style="display:inline-block;">Cashier</span><br>
			<input id="username" name="username" class="form-control input-sm" style="display:inline-block" type="text" placeholder="Payroll ID" value="<?php echo $username; ?>" readonly><br>
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
           data-height="300"
           data-url="<?php echo base_url(); ?>billed_transaction/getData">
        <thead>
            <tr>
                <th data-field="id">ID</th>
                <th data-field="order_no">Order No</th>
                <th data-field="customer_name">Customer Name</th>
				<th data-field="status">Status</th>
				<th data-field="date">Date</th>
				<th data-field="receive_date">Receive Date</th>
				<th data-field="total">Total</th>
				<th data-field="payment">Cash</th>
				<th data-field="down_payment">DP</th>
				<th data-field="outstanding">Outstanding</th>
            </tr>
        </thead>
    </table><br><br>
	<div class='row'>
		<div class='col-sm-12'>
			<img id="add" onclick="window.open('<?php echo base_url(); ?>transaction/form','_parent');" src ="<?php echo base_url();?>assets/img/add_header.png" width="70" height="70" style="border: #fff solid 1px" >
			<img id="logout" onclick="window.open('<?php echo base_url(); ?>auth/logout','_parent');" src ="<?php echo base_url();?>assets/img/logout.png" width="70" height="70" style="border: #fff solid 1px" >
		</div>
	</div>
	<div class="modal"><!-- Place at bottom of page --></div>
</section>
<script>
	var $table = $('#table');
    $table.on('click-row.bs.table', function (row, $element) {
		window.open("<?php echo base_url(); ?>transaction/form/id/"+$element.id,'_parent');
	});
	
	$('body').keydown(function(event) {
		if(event.which == 113) { //F2
			window.open('<?php echo base_url(); ?>transaction/form','_parent');
			return false;
		}
	});
</script>
