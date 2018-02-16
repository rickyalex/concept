<section class="content-header">
    <h1><small>Master Product</small></h1>
    <ol class="breadcrumb">
</section></br>
<section class="content">
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
           data-url="<?php echo base_url(); ?>product/getData">
        <thead>
            <tr>
                <th data-field="id">ID</th>
                <th data-field="product_id">Product ID</th>
                <th data-field="description">Description</th>
                <th data-field="type">Type</th>
                <th data-field="brand">Brand</th>
                <th data-field="lokasi">Location</th>
				<th data-field="active">Active</th>
                <th data-field="created_by">Created By</th>
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
		window.open("<?php echo base_url(); ?>product/form/id/"+$element.id,'_parent');
    });
    $add.on('click',function(){
		window.open("<?php echo base_url(); ?>product/form",'_parent');
    });
	
	$(document).on('click', '.remove', function (e){
		//if(field=='action'){
		var id = $(this).parent().siblings(":first").text();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>product/remove/id/"+id,
			success: function(s){
				alert("Delete Success")
				location.reload();
			}
			,
			error: function(e){
				alert('Delete Error');
			}
		});
	});
</script>
