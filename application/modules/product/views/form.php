<section class="content-header">
    <h1><small>Form Master Product</small></h1>
    <ol class="breadcrumb">
</section></br>
<section class="content">
    <div class='row'>
        <div class='col-sm-6'>
            <form class='form_add' class='navbar-form'>
                <dl class='dl-horizontal'>
                    <input id='id' name='id' class='form-control' type='hidden' value="<?php if ($mode == 'update') echo $result['id']; ?>">
                    <dt>Product ID</dt>
                    <dd>
                        <input id='product_id' name='product_id' class='form-control' type='text' placeholder='Generated Automatically' value="<?php if ($mode == 'update') echo $result['product_id']; ?>" readonly>
                    </dd>
					<dt>Name</dt>
                    <dd>
                        <input id='description' name='description' class='form-control' type='text' placeholder='Name of the product' value="<?php if ($mode == 'update') echo $result['description']; ?>">
                    </dd>
                    <dt>Type</dt>
                    <dd>
                        <select id="id_type" name="id_type" class="form-control" style="width:300px" data-placeholder="Select Type">
                            <?php if ($mode == 'update') echo $result['sel_type'];
                            else echo "<option></option>"; ?>
                        </select>
                    </dd>
                    <dt>Brand</dt>
                    <dd>
                        <input id='brand' name='brand' class='form-control' type='text' placeholder='Brand, ex : Samsung, Nike, Honda, etc' value="<?php if ($mode == 'update') echo $result['brand']; ?>">
                    </dd>
                    <dt>Spec</dt>
                    <dd>
                        <input id='spec' name='spec' class='form-control' type='text' placeholder='Brief Specification, ex : 12 Litres Capacity, 5400 dpi, etc' value="<?php if ($mode == 'update') echo $result['spec']; ?>">
                    </dd>
                </dl>
        </div>
        <div class='col-sm-6'>
            <dl class='dl-horizontal'>
                <dt>Location</dt>
                <dd>
					<input id='lokasi' name='lokasi' class='form-control' type='text' placeholder='Location of storage, ex : Warehouse A, Building 1, etc' value="<?php if ($mode == 'update') echo $result['lokasi']; ?>">
                </dd>
				<dt>UoM</dt>
                <dd>
                    <input id='uom' name='uom' class='form-control' type='text' placeholder='Unit of Measurement, ex : pcs, pack, etc' value="<?php if ($mode == 'update') echo $result['uom']; ?>">
                </dd>
                <dt>Max Stock</dt>
                <dd>
                    <input id='max_stock' name='max_stock' class='form-control' type='text' placeholder='Max Stock' value="<?php if ($mode == 'update') echo $result['max_stock']; ?>">
                </dd>
                <dt>Min Stock</dt>
                <dd>
                    <input id='min_stock' name='min_stock' class='form-control' type='text' placeholder='Min Stock' value="<?php if ($mode == 'update') echo $result['min_stock']; ?>">
                </dd>
                <dt>Active</dt>
				<dd><input id="active1" name="active" type="radio" value="Y" <?php if($mode=="update") { if($result['active']=="Y") echo "checked"; } ?>>Yes<input id="active2" name="active" type="radio" value="N" <?php if($mode=="update") { if($result['active']=="N") echo "checked"; } ?>>No</dd>
            </dl>
        </div>
</form>
    </div>
    <div class='row'>
		<div class='col-sm-6'>
			<button id="button_submit" class="btn btn-success" type="submit">Save</button>
        </div>
    </div>
	<div class="modal"><!-- Place at bottom of page --></div>
</section>
<script>
	$(window).bind("load", function() {
		$("#id_type").select2({
			data : <?php echo $all_type; ?>
		});
	});
	
	//form submit menggunakan FormData harus menggunakan browser versi IE 10+, Firefox 4.0+, Chrome 7+, Safari 5+, Opera 12+
	$('#button_submit').on('click',function(e){
		e.preventDefault();
		var form = $(".form_add")[0];
		var formData = new FormData(form);
		$.ajax({
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			url: "<?php echo base_url();?>product/saveData",
				success: function(response) {
					alert(response);
					window.open("<?php echo base_url(); ?>product",'_parent');
				},
				error: function(response){
					alert(response);
				}
		});
		return false;
	});
</script>
