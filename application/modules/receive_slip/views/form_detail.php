<?php //echo $mode . '<br/>';
	  // echo '<PRE>';
	  // print_r($result);
	  // echo '</PRE>';
	  // echo $result[0]['id'];
	  // echo $result[0]['product_id']
// echo $result['id'];
?>
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
                        <select id="product_id" name="product_id" class="form-control" style="width:300px" onChange="get_Price()" data-placeholder="Select Product">
                            <?php if ($mode == 'update') echo $result['sel_product'];
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
			</form>
        </div>
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

		if ($mode != 'update')  $("#qty").val('');
	});

	function get_Price() {
	    var prod_selected = $('select[name=product_id]').val();
	    $.ajax({
	        data: {
	            prod_selected: prod_selected,
	        },
	        type: 'POST',
	        url: '<?php echo base_url();?>receive_slip/get_Price',
	        success: function(data){
        		var data = eval('('+data+')');
        		// alert(data.length);

	            $('#receive_price').val('');
	            $('#selling_price').val('');
        		if(data.length > 0){
	        		// alert(JSON.stringify(data));
	        		// alert(data[0].receive_price);
	        		// alert(data[0].selling_price);
		            // console.log(data);
		            $('#receive_price').val(data[0].receive_price);
		            $('#selling_price').val(data[0].selling_price);
	            }
	        }
	    })
	}
	
	//form submit menggunakan FormData harus menggunakan browser versi IE 10+, Firefox 4.0+, Chrome 7+, Safari 5+, Opera 12+
	$('#button_submit').on('click',function(e){
		var selling = $('#selling_price').val();
		var receive = $('#receive_price').val();
		var qty = $('#qty').val();

		if(qty == 0){
			alert('Please fill qty!');
			return false;
		}

		if(eval(selling) < eval(receive)){
			alert('Selling price lower than receive price!');
			return false;
		}

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
					if (response.match(/This product .*/)) {
						alert(response);
					}else{
						alert(response);
						window.open("<?php echo base_url(); ?>receive_slip/view_detail/id/<?php echo $id; ?>",'_parent');
					}
				},
				error: function(response){
					alert(response);
				}
		});
		return false;
	});
</script>
