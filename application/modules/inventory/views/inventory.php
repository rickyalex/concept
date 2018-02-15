
<section class="content-header">
    <h1><small>Inventory</small></h1>
    <ol class="breadcrumb">
</section></br>
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
           data-height="600"
           data-url="<?php echo base_url(); ?>inventory/getData">
        <thead>
            <tr>
                <th data-field="product_id" data-cell-style="cellStyle">ID</th>
				<th data-field="product" data-cell-style="cellStyle">Product</th>
				<th data-field="min_stock" data-cell-style="cellStyle">Min Stock</th>
        <th data-field="qty_on_hand" data-cell-style="cellStyle">Qty</th>
				<th data-field="last_updated" data-cell-style="cellStyle">Last Updated</th>
            </tr>
        </thead>
    </table>
	<div class="modal"><!-- Place at bottom of page --></div>
</section>
<script>
  function cellStyle(value, row, index) {
    console.log(row);

    if (row.qty_on_hand  < parseInt(row.min_stock) ) {
        return {
            classes: 'danger'
        };
    }
    return {};
}
</script>
