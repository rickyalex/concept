
<section class="content-header">
    <h1><small>Transaction History</small></h1>
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
           data-url="<?php echo base_url(); ?>history/getData">
        <thead>
            <tr>
                <th data-field="id">ID</th>
                <th data-field="document_no">Document No</th>
                <th data-field="product_id">Product</th>
				<th data-field="qty">Qty</th>
				<th data-field="mode">Mode</th>
				<th data-field="created_by">Created By</th>
				<th data-field="date_created">Date Created</th>
            </tr>
        </thead>
    </table>
	<div class="modal"><!-- Place at bottom of page --></div>
</section>
<script>
</script>
