<section class="content-header">
    <h1><small>Receive Slip</small></h1>
    <ol class="breadcrumb">
</section></br>
<section class="content">
    <div class='row'>
        <div class='col-sm-6'>
            <form class='form_add' class='navbar-form'>
                <dl class='dl-horizontal'>
                    <input id='id' name='id' class='form-control' type='hidden' value="<?php if ($mode == 'update') echo $result['id']; ?>">
                    <dt>Product</dt>
                    <dd>
                        <select id="product_id" name="product_id" class="form-control" style="width:300px" data-placeholder="Select Product">
                            <?php if ($mode == 'update') echo $result['product_id'];
                            else echo "<option></option>"; ?>
                        </select>
                    </dd>
					<dt>Qty</dt>
                    <dd>
                        <input id='qty' name='qty' class='form-control' type='text' placeholder='The received quantity' value="<?php if ($mode == 'update') echo $result['qty']; ?>">
                    </dd>
					<dt>Receive Price</dt>
                    <dd>
                        <input id='receive_price' name='receive_price' class='form-control' type='text' placeholder='The received price' value="<?php if ($mode == 'update') echo $result['receive_price']; ?>">
                    </dd>
					<dt>Selling Price</dt>
                    <dd>
                        <input id='selling_price' name='selling_price' class='form-control' type='text' placeholder='The selling quantity' value="<?php if ($mode == 'update') echo $result['selling_price']; ?>">
                    </dd>
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
		$("#product_id").select2({
			data : <?php echo $all_product; ?>
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
			url: "<?php echo base_url();?>receive_slip/saveData/mode/detail/id_header/<?php echo $id; ?>",
				success: function(response) {
					alert(response);
					window.open("<?php echo base_url(); ?>receive_slip/view_detail/id/<?php echo $id; ?>",'_parent');
				},
				error: function(response){
					alert(response);
				}
		});
		return false;
	});
</script>
