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
                        <select id="product_id" name="product_id" class="form-control" onChange="get_Price()" data-placeholder="Select Product">
                            <?php if ($mode == 'update') echo $result['sel_product'];
                            else echo "<option></option>"; ?>
                        </select>
                    </dd>
					<dt>Qty</dt>
                    <dd>
                        <input id='qty' name='qty' class='form-control' type='text' placeholder='The received quantity' value="">
                    </dd>
					<dt>Receive Price</dt>
                    <dd>
                        <input id='receive_price' name='receive_price' class='numeric form-control' type='text' placeholder='The received price' value="">
                    </dd>
					<dt>Selling Price</dt>
                    <dd>
                        <input id='selling_price' name='selling_price' class='numeric form-control' type='text' placeholder='The selling quantity' value="">
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

		<?php if($mode=="update") { ?>
			$("#product_id").focus();
			$("#qty").val(numberFormat('<?php echo $result['qty']; ?>',"."));

			$('#receive_price').val(numberFormat('<?php echo $result['receive_price']; ?>',"."));
			$('#selling_price').val(numberFormat('<?php echo $result['selling_price']; ?>',"."));
		<?php }else{ ?>
			$("#qty").val('');
			$("#receive_price").val('');
			$("#selling_price").val('');
		<?php } ?>

	});

	function numberFormat(_number, _sep) {
		// alert(_number);
		_number = _number.toString();
		var ket = "tambah";
		if(_number < 0 && _number != ""){
			_number = _number.replace("-","");
			ket = "kurang";
		}else if(_number == 0){
			ket = "nol";
		}
		// alert(_number);
	    _number = typeof _number != "undefined" && _number > 0 ? _number : "";
	    _number = _number.replace(new RegExp("^(\\d{" + (_number.length%3? _number.length%3:0) + "})(\\d{3})", "g"), "$1 $2").replace(/(\d{3})+?/gi, "$1 ").trim();
	    
	    if(typeof _sep != "undefined" && _sep != " ") {
	        _number = _number.replace(/\s/g, _sep);
	    }
	    if(ket == "kurang")
	    	return "-"+_number;
    	else if(ket == "nol")
    		return "0"
    	else
    		return _number;
	}

	function replaceChar(Char){
		// Char = Char.replace(/,/g , "");
		// Char = Char.replace(/.00/g , "");
		if(Char != "0.00" || Char != ""){
			Char = Char.split(".").join("");
			// Char = Char.split(".00").join("");
		}
		return Char;
	}

    $('#receive_price').on('keyup', function(){
        var receive_price = replaceChar($('#receive_price').val());
		$('#receive_price').val(numberFormat(receive_price,"."));
	});
	
    $('#selling_price').on('keyup', function(){
        var selling_price = replaceChar($('#selling_price').val());
		$('#selling_price').val(numberFormat(selling_price,"."));
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
		            $('#receive_price').val(numberFormat(data[0].receive_price,"."));
		            $('#selling_price').val(numberFormat(data[0].selling_price,"."));
	            }
	        }
	    })
	}
	
	//form submit menggunakan FormData harus menggunakan browser versi IE 10+, Firefox 4.0+, Chrome 7+, Safari 5+, Opera 12+
	$('#button_submit').on('click',function(e){
		var selling = $('#selling_price').val();
		var receive = $('#receive_price').val();
		var qty = $('#qty').val();

		if(qty == 0 || qty == ''){
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
