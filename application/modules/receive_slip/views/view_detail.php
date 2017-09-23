<section class="content-header">
    <h1><small>Receive Slip</small></h1>
    <ol class="breadcrumb">
</section></br>
<section class="content">
	<div class="row">
		<div class="col-xs-4 col-sm-4 col-md-4">
			<dl class="dl-horizontal">
				<dt>Receive Slip No</dt>
				<dd><input id="document_no" name="document_no" class="form-control" type="text" placeholder="Payroll ID" value="<?php echo $result['document_no']; ?>" readonly></dd>
				<dt>Date</dt>
				<dd><input id="date" name="date" class="form-control" type="text" placeholder="Nama Karyawan" value="<?php echo $result['date']; ?>" readonly></dd>
				<dt>Vendor</dt>
				<dd><input id="vendor" name="vendor" class="form-control" data-placeholder="Select Title" value="<?php echo $result['vendor']; ?>" readonly></dd>
			</dl>
		</div>
	</div>
    <div id="toolbar">
        <button id="add" class="btn btn-success">
            <i class="glyphicon glyphicon-add"></i> Add
        </button>
    </div>
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
           data-height="600"
           data-url="<?php echo base_url(); ?>receive_slip/getDetailData/id/<?php echo $id; ?>">
        <thead>
            <tr>
                <th data-field="id">ID</th>
                <th data-field="product_id">Product</th>
                <th data-field="qty">Qty</th>
                <th data-field="qty_on_hand">Qty On Hand</th>
				<th data-field="receive_price">Receive Price</th>
				<th data-field="selling_price">Selling Price</th>
				<th data-field="action">Action</th>
            </tr>
        </thead>
    </table>
	<div class="modal"><!-- Place at bottom of page --></div>
</section>
<script>
    var $table = $('#table');
    var $add = $('#add');
    $table.on('dbl-click-row.bs.table', function (row, $element) {
	window.open("<?php echo base_url(); ?>receive_slip/form/mode/update/id/"+$element.id,'_parent');
    });
    $add.on('click',function(){
  window.open("<?php echo base_url(); ?>receive_slip/form/mode/add/id/<?php echo $id; ?>",'_parent');
    });
</script>
