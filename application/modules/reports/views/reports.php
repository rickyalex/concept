<section class="content-header">
<h1>
<small>Reports </small>
</h1>
</section></br>


<section class="content-header">
	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
		  <li class="active"><a href="#tab_1" data-toggle="tab">Summary Product Sales</a></li>
		  <li><a href="#tab_2" data-toggle="tab">Summary Service Sales</a></li>
		  <li><a href="#tab_3" data-toggle="tab">Summary Package Sales</a></li>
		</ul>
        <div class="tab-content">
			<div class="tab-pane active" id="tab_1">
				<p class="lead">Summary Product Sales</p>
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
					   data-url="<?php echo base_url(); ?>reports/getNonServiceData">
					<thead>
						<tr>
							<th data-field="date_created">Date</th>
							<th data-field="product_id">Product ID</th>
							<th data-field="description">Product Name</th>
							<th data-field="type">Type</th>
							<th data-field="category">Category</th>
							<th data-field="total">Total</th>
						</tr>
					</thead>
				</table>
			</div>
			<div class="tab-pane" id="tab_2">
				<p class="lead">Summary Service Sales</p>
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
					   data-url="<?php echo base_url(); ?>reports/getServiceData">
					<thead>
						<tr>
							<th data-field="date_created">Date</th>
							<th data-field="product_id">Product ID</th>
							<th data-field="description">Product Name</th>
							<th data-field="type">Type</th>
							<th data-field="category">Category</th>
							<th data-field="total">Total</th>
						</tr>
					</thead>
				</table>
			</div>
			<div class="tab-pane" id="tab_3">
				<p class="lead">Summary Package Sales</p>
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
					   data-url="<?php echo base_url(); ?>reports/getPackageData">
					<thead>
						<tr>
							<th data-field="date_created">Date</th>
							<th data-field="package">Package Name</th>
							<th data-field="total">Total</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
</section>