<style>
	#container {
		width: 100%;
		height: 100%;
		top: 0;
		position: fixed;
		visibility: hidden;
		display: none;
		background-color: rgba(22,22,22,0.5); /* complimenting your modal colors */
		overflow: hidden;
		z-index:999;
	}
	
	#container2 {
		width: 100%;
		height: 100%;
		top: 0;
		position: fixed;
		visibility: hidden;
		display: none;
		background-color: rgba(22,22,22,0.5); /* complimenting your modal colors */
		overflow: hidden;
		z-index:999;
	}
	
	.reveal-modal {
		width: 50%;
		background-color: #fff;
		position: relative;
		margin: 0 auto;
		top: 25%;
	}
	
	.modal-content{
		padding: 20px;
	}
	
	#payment_details input, #transaction_header input{
		margin: 0;
		width: 200px;
	}
	
	#payment_details input dd{
		margin-top: 2px;
	}
</style>

<section class="content-header">
	<div id="transaction_header" class="row">
		<div class="col-xs-4 col-sm-4 col-md-4">
			<form class='form_header' class='navbar-form'>
			<input id="id" name="id" type="hidden" value="<?php if($mode=="update") echo $result['id']; ?>">
			<span style="display:inline-block;">Order No</span><br>
			<input id="order_no" name="order_no" class="form-control input" style="display:inline-block" type="text" placeholder="Order No" value="<?php if($mode=="update") echo $result['order_no'];else echo $order_no; ?>" readonly><br>
			<span style="display:inline-block;">Cust Name</span><br>
			<input id="customer_name" name="customer_name" class="form-control input" style="display:inline-block" type="text" placeholder="Customer Name" value="<?php if($mode=="update") echo $result['customer_name']; ?>" <?php if($mode=="update") echo "readonly"; ?>><br>
			<span style="display:inline-block;">HP No</span><br>
			<input id="customer_name" name="customer_phone" class="form-control input" style="display:inline-block" type="text" placeholder="Customer Phone" value="<?php if($mode=="update") echo $result['customer_phone']; ?>" <?php if($mode=="update") echo "readonly"; ?>><br>
		</div>
		<div class="col-xs-4 col-sm-4 col-md-4">
			<span style="display:inline-block;">Date</span><br>
			<input id="date" name="date" class="form-control input" style="display:inline-block" type="text" placeholder="Date" value="<?php if($mode=="update") echo $result['date'];else echo date('Y-m-d'); ?>" readonly><br>
			<?php /*<span style="display:inline-block;">Package</span><br>
			<select id="package" name="package" class="form-control input-sm" style="width:300px" data-placeholder="Select Package" <?php if ($mode == 'update') echo "readonly"; ?>><br>
				<?php if ($mode == 'update') echo $result['package'];
				else echo "<option></option>"; ?>
            </select>*/ ?>
            <span style="display:inline-block;">Discount Percentage</span><br>
            <div class="input-group">
				<span class="input-group-addon">%</span>
				<input id='discount' name='discount' class='form-control input' style="display:inline-block" type='text' <?php if ($mode == 'update') echo 'readonly'; ?> placeholder='If no discount, leave blank' value="<?php if ($mode == 'update') echo $result['discount']; ?>">
			</div>
		</div>
		<div class="col-xs-4 col-sm-4 col-md-4">
			<span style="display:inline-block;">Down Payment</span><br>
			<div class="input-group">
				<span class="input-group-addon">Rp.</span>
				<input id="down_payment" name="down_payment" class="numeric form-control input" style="display:inline-block" type="text" placeholder="Down Payment" value=""><br>
			</div>
			<span style="display:inline-block;">Receive Date</span><br>
			<input id="receive_date" name="receive_date" class="dp form-control input" style="display:inline-block" type="text" placeholder="Received Date" value="<?php echo $result['receive_date']; ?>"><br>
			
			
		</div>
	</div>
    <ol class="breadcrumb">
</section>
<section class="content">
    <table id="table"
           data-toggle="table"
           data-minimum-count-columns="2"
           data-pagination="true"
		   data-show-refresh="true"
           data-page-list="[10, 25, 50, 100, ALL]"
           data-show-footer="false"
           data-export-data-type="all"
           data-export-types="['excel']"
           data-height="250"
           data-url="<?php if($mode=="update") { echo base_url(); ?>transaction/getData/id_header/<?php echo $result['id']; } ?>">
        <thead>
            <tr>
                <th data-field="id">ID</th>
                <th data-field="product_id">Product ID</th>
                <th data-field="package">Package</th>
                <th data-field="product">Description</th>
				<th data-field="qty">Qty</th>
				<th data-field="price">Price</th>
				<th data-field="subtotal">Sub Total</th>
				<th data-field="action">Action</th>
            </tr>
        </thead>
    </table>
	<div class='row'>
		<div class='col-xs-4 col-sm-4 col-md-4'>
			<img id="back" onclick="window.open('<?php echo base_url(); ?>billed_transaction','_parent');" src ="<?php echo base_url();?>assets/img/back.png" width="70" height="70" style="border: #fff solid 1px" >
			<img id="logout" onclick="window.open('<?php echo base_url(); ?>auth/logout','_parent');" src ="<?php echo base_url();?>assets/img/logout.png" width="70" height="70" style="border: #fff solid 1px" >
			<?php if($mode=="insert"){ ?>
			<img id="add" onclick="showForm()" src ="<?php echo base_url();?>assets/img/add_detail.png" width="70" height="70" style="border: #fff solid 1px" >
			<img id="cancel" onclick="cancelData()" src ="<?php echo base_url();?>assets/img/cancel.png" width="70" height="70" style="border: #fff solid 1px" >
			<img id="checkout" onclick="checkout1()" src ="<?php echo base_url();?>assets/img/checkout.png" width="70" height="70" style="border: #fff solid 1px" >
			<?php }elseif($mode=="update" && $result['status']=="OPEN"){ ?>
			<img id="add" onclick="showForm()" src ="<?php echo base_url();?>assets/img/add_detail.png" width="70" height="70" style="border: #fff solid 1px" >
			<img id="cancel" onclick="cancelData()" src ="<?php echo base_url();?>assets/img/cancel.png" width="70" height="70" style="border: #fff solid 1px" >
			<img id="checkout" onclick="checkout1()" src ="<?php echo base_url();?>assets/img/checkout.png" width="70" height="70" style="border: #fff solid 1px" >
			<?php } ?>
		
		</div>
		<div class='col-xs-4 col-sm-4 col-md-4'>
		</div>
		<div id="payment_details" class='col-xs-4 col-sm-4 col-md-4'>
			<dl class='dl-horizontal'>
                <dt>Subtotal</dt>
                <dd>
					<div class="input-group">
						<span class="input-group-addon">Rp.</span>
						<input id='subtotal2' class='numeric form-control input' type='text' readonly>
					</div>
                </dd>
                <dt>Discount</dt>
                <dd>
					<div class="input-group">
						<span class="input-group-addon">Rp.</span>
						<input id='discount2' class='numeric form-control input' type='text' readonly>
					</div>
                </dd>
                <dt></dt>
                <dd>*****************************************************</dd>
                <dt>Total</dt>
                <dd>
					<div class="input-group">
						<span class="input-group-addon">Rp.</span>
						<input id='total' name='total' class='numeric form-control input' type='text' readonly>
					</div>
                </dd>
				<dt>Cash</dt>
                <dd>
					<div class="input-group">
						<span class="input-group-addon">Rp.</span>
						<input id='payment' name='payment' class='numeric form-control input' type='text' value="">
					</div>
                </dd>
                <dt>Change</dt>
                <dd>
					<div class="input-group">
						<span class="input-group-addon">Rp.</span>
						<input id='return' name='return' class='form-control input' type='text' value="" readonly>
					</div>
                </dd>
            </dl>
			</form>
		</div>
	</div>
	<div class="modal"><!-- Place at bottom of page --></div>
	
</section>
<div id="container">
	<div class="reveal-modal">
		<div style="display:block;background-color:#04a9af;width:100%;height:30px;padding:10px;color:#fff">ADD PRODUCT</div>
		<div class="modal-content">
			<div class="row">
				<div class='col-xs-12 col-sm-12 col-md-12'>
					<form class='form_detail' class='navbar-form'>
					<dl class='dl-horizontal'>
						<dt>Product</dt>
						<dd>
							<select id="product_id" name="product_id" class="form-control input-sm" style="width:400px" data-placeholder="Select Product"><br>
								<option></option>
							</select>
						</dd>
						<dt>Qty</dt>
						<dd>
							<input id='qty' name='qty' class='form-control input-sm' type='text' value="">
						</dd>
						<dt>Price</dt>
						<dd>
							<input id='price' name='price' class='form-control input-sm' type='text' value="" readonly>
						</dd>
						<dt>Subtotal</dt>
						<dd>
							<input id='subtotal' name='subtotal' class='form-control input-sm' type='text' value="" readonly>
						</dd>
					</dl>
					</form>
				</div>
				<a id="add_item" href="#" class="btn btn-sm btn-success" style="margin:5px">Add</a>
				<a href="#" onClick="hideForm()" class="btn btn-sm btn-default" style="margin:5px">Back</a>
			</div>
		</div>
	</div>
</div>
<div id="container2">
	<div class="reveal-modal">
		<div style="display:block;background-color:#04a9af;width:100%;height:30px;padding:10px;color:#fff">Confirmation</div>
		<div class="modal-content">
			<div class="row">
				<div class='col-xs-12 col-sm-12 col-md-12'>
					<form class='form_confirm' class='navbar-form'>
						<dl class='dl-horizontal'>
							<dt>Password</dt>
							<dd>
								<input type="hidden" name="idDelete" id="idDelete">
								<input id='password' name='password' class='form-control input-sm' type='password' value="">
							</dd>
						</dl>
					</form>
				</div>
				<a id="confirm" href="#" class="btn btn-sm btn-success" style="margin:5px">Confirm</a>
				<a href="#" onClick="hideConfirmation()" class="btn btn-sm btn-default" style="margin:5px">Back</a>
			</div>
		</div>
	</div>
</div>
<script type="application/javascript">
	// $(".numeric").lazzynumeric({aSep: ","});

	$(window).bind("load", function() {
		$('.dp').datepicker({ changeMonth: true, changeYear: true, yearRange: "-100:+10" });
		$('.dp').datepicker("option", "dateFormat", "yy-mm-dd" );

		// $(".numeric").numeric({ decimal : ".",  negative : false, scale: 3 });
		
		<?php if($mode=="update") { ?>
			$("#order_no").focus();
			$('#receive_date').val('<?php echo $result["receive_date"]; ?>');
			$('#down_payment').val(numberFormat('<?php echo $result["down_payment"]; ?>', "."));
			$('#subtotal2').val(numberFormat('<?php echo $result["subtotal2"]; ?>', "."));
			$('#discount2').val(numberFormat('<?php echo $result["discount2"]; ?>', "."));
			$('#total').val(numberFormat('<?php echo $result["total"]; ?>', "."));
			$('#payment').val(numberFormat('<?php echo $result["payment"]; ?>',"."));
			$('#return').val(numberFormat('<?php echo ($result["payment"]+$result["down_payment"]) - $result["total"]; ?>', "."));
		<?php }else{ ?>
			$("#customer_name").val('');
			$("#total").val('');
			$("#payment").val(0);
			$("#down_payment").val(0);
			$("#return").val('');
			$("#discount").val(0);
			$("#subtotal2").val(0);
			$("#order_no").focus();
		<?php } ?>
		
		$("#package").select2({
			data : [{id: 1, text: 'package 1'},{id: 2, text: 'package 2'},{id: 3, text: 'package 3'}]
		});
		
		$("#product_id").select2({
			data : <?php echo $all_product; ?>
		});
		
		$('body').keydown(function(event) {
			if(event.which == 113) { //F2
				showForm();
				return false;
			}
		});
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

	function changeFormat(id){
		var value = $('#'+id).val();
		alert(value);
		$('#'+id).val(numberFormat(value, '.'));
	}

	$('#confirm').on('click',function(e){
		//if(field=='action'){
		e.preventDefault();
		var id = $('#idDelete').val();
		var form_confirm = $(".form_confirm")[0];
		var formConfirm = new FormData(form_confirm);

		$.ajax({
			type: "POST",
			data: formConfirm,
			contentType: false,
			processData: false,
			url: "<?php echo base_url();?>transaction/remove/id/"+id,
			success: function(response){
				if (response.match(/Error: .*/)) {
					alert('Delete Error!');
				}else{
					var data = JSON.parse(response);
					$('#table').bootstrapTable('load', data);
					getTotal();
				}
				
			}
			,
			error: function(e){
				alert('Delete Error');
			}
		});
		hideConfirmation();
		return false;
	});
	
	$('#product_id').on('change', function(){
		var receive_id = $('#product_id').val();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>transaction/getPrice2/receive_id/"+receive_id,
				success: function(response) {
					var response = eval('('+response+')');
	        		// alert(data.length);
	        		$('#qty').val('');
					$('#subtotal').val('');
	        		if(response.length > 0){
			            $('#price').val(response[0].selling_price);
		            }
				},
				error: function(response){
					$('#price').val(0);
	        		$('#qty').val('');
					$('#subtotal').val('');
				}
		});
		return false;
	});
	
	$('#qty').on('change', function(){
		$('#subtotal').val($('#price').val()*$('#qty').val());
	});
        
    $('#down_payment').on('keyup', function(e){
		// $('#payment').val($('#down_payment').val());
        // $('#return').val($('#payment').val()-$('#down_payment').val()-$('#total').val());
        if(e.which == 13) { //F2
			checkout1();
		}else{
			changeTotal();
		}
	});
	
	$('#payment').on('keyup', function(e){
		// $('#return').val($('#payment').val()-$('#down_payment').val()-$('#total').val());
		if(e.which == 13) { //F2
			checkout1();
		}else{
			changeTotal();
		}
        
	});
	

	$('#discount').on('change', function(){
		// alert($('#subtotal').val());
		changeTotal();
	});

	function replaceChar(Char){
		// Char = Char.replace(/,/g , "");
		// Char = Char.replace(/.00/g , "");
		if(Char != "0.00" || Char != ""){
			Char = Char.split(".").join("");
			// Char = Char.split(".00").join("");
		}
		return Char;
	}

	function changeTotal(){
		var discount = ($('#discount').val()/100);
		var subtotal2 = replaceChar($('#subtotal2').val());
		$('#discount2').val(numberFormat(subtotal2*discount,"."));

		var discount2 = replaceChar($('#discount2').val());
		
		$('#total').val(numberFormat(subtotal2-discount2,"."));

		var payment = parseInt(replaceChar($('#payment').val()));
        var down_payment = parseInt(replaceChar($('#down_payment').val()));
        var total = parseInt(replaceChar($('#total').val()));
        $('#return').val(numberFormat((payment+down_payment)-total,"."));
        $('#payment').val(numberFormat(payment,"."));
        $('#down_payment').val(numberFormat(down_payment,"."));

        // $(".numeric").lazzynumeric({aSep: ","});
	}
	
	function showForm(){
		if(checkData()==true){
			$('#container').css('visibility','visible');
			$('#container').css('display','block');
			$('#qty').val('');
			$('#price').val('');
			$('#subtotal').val('');
			$("#product_id").focus();
		}
		else alert('Order No/Customer Name/Date/Discount Empty');
	}
	
	function hideForm(){
		$('#container').css('visibility','hidden');
		$('#container').css('display','none');
	}
	
	function showConfirmation(idDelete){
		// if(checkConfirmation()==true){
			$('#container2').css('visibility','visible');
			$('#container2').css('display','block');
			$('#idDelete').val(idDelete);
			$('#password').val('');
			$('#password').focus();
		// }
		// else alert('Password Empty');
	}
	
	$('#password').on('keydown',function(e){
		//e.preventDefault();
		if(e.which == 13) { //F2
			e.preventDefault();
			var id = $('#idDelete').val();
			var form_confirm = $(".form_confirm")[0];
			var formConfirm = new FormData(form_confirm);
	
			$.ajax({
				type: "POST",
				data: formConfirm,
				contentType: false,
				processData: false,
				url: "<?php echo base_url();?>transaction/remove/id/"+id,
				success: function(response){
					if (response.match(/Error: .*/)) {
						alert('Delete Error!');
					}else{
						var data = JSON.parse(response);
						$('#table').bootstrapTable('load', data);
						getTotal();
					}
					
				}
				,
				error: function(e){
					alert('Delete Error');
				}
			});
			hideConfirmation();
			return false;
		}
	});
	
	function hideConfirmation(){
		$('#container2').css('visibility','hidden');
		$('#container2').css('display','none');
	}
	
	function clearData(){
		$('#table').bootstrapTable('removeAll');
		//tambah hapus data
	}

	function cancelData(){
		var form_header = $(".form_header")[0];
		var formData = new FormData(form_header);
		
		var result = confirm("Want to cancel order?");
		if (result) {
		    $.ajax({
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				url: "<?php echo base_url();?>transaction/cancelorder/order_no/<?php echo $result['order_no']; ?>",
				success: function(response) {
					if (response.match(/Error: .*/)) {
						alert(response);
					}else{
						window.open('<?php echo base_url(); ?>billed_transaction','_parent');
						// alert(response);
					}
				},
				error: function(response){
					alert('cakcel data error');
				}
			});
		}
		
	}
	
	function checkData(){
		if($('#order_no').val()=='') return false;
		else if($('#customer_name').val()=='') return false;
		else if($('#date').val()=='') return false;
		else if($('#discount').val()=='') return false;
		else return true;
	}
	
	function checkConfirmation(){
		if($('#password').val()=='') return false;
		else return true;
	}
	
	function checkDataDetail(){
		if($('#product_id').val()=='') return false;
		else if($('#qty').val()=='') return false;
		else if($('#price').val()=='') return false;
		else if($('#subtotal').val()=='' || $('#subtotal').val()==0) return false;
		else return true;
	}
	
	function checkout1(){
		var payment = parseInt($('#payment').val());
        var down_payment = parseInt($('#down_payment').val());
        if(payment == 0 && down_payment == 0){
        	alert('DP/Cash empty!');
        	return false;
        }

		var form_header = $(".form_header")[0];
		var formData = new FormData(form_header);
		// if($('#payment').val() == '' || $('#payment').val() == '0'){
		// 	alert('Please fill Cash!')
		// 	return false;
		// }
		$.ajax({
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			url: "<?php echo base_url();?>transaction/checkout/order_no/<?php if($mode=="update") echo $result['order_no']; else echo $order_no; ?>",
			success: function(response) {
				if (response.match(/Error: .*/)) {
					alert(response);
				}else{
					window.open('<?php echo base_url(); ?>transaction/print_out/order_no/<?php if($mode=="update") echo $result['order_no']; else echo $order_no; ?>','_blank');
					window.open('<?php echo base_url(); ?>billed_transaction','_parent');
					// alert(response);
				}
			},
			error: function(response){
				alert('save header error');
			}
		});
	}

	function getTotal(){
		var order_no = $('#order_no').val();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>transaction/getTotal/order_no/"+order_no,
				success: function(response) {
					// $('#total').val(response);
					$('#subtotal2').val(numberFormat(response,"."));
					changeTotal();
				},
				error: function(response){
					$('#total').val(0);
				}
		});
		return false;
	}
	
	//form submit menggunakan FormData harus menggunakan browser versi IE 10+, Firefox 4.0+, Chrome 7+, Safari 5+, Opera 12+
	$('#add_item').on('click',function(e){
		e.preventDefault();
		var order_no = $('#order_no').val();
		var form_header = $(".form_header")[0];
		var formData = new FormData(form_header);
		var form_detail = $(".form_detail")[0];
		var formData2 = new FormData(form_detail);
		
		//$table.bootstrapTable('append', data);
		
		$.ajax({
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			<?php if($mode=="update") { ?>
				url: "<?php echo base_url();?>transaction/saveHeader/id/<?php echo $result['id']; ?>",
			<?php }else{ ?>url: "<?php echo base_url();?>transaction/saveHeader/",<?php } ?>
				success: function(response) {
					if(checkDataDetail()==true){
						$.ajax({
							type: "POST",
							data: formData2,
							contentType: false,
							processData: false,
							url: "<?php echo base_url();?>transaction/saveDetail/order_no/"+order_no,
								success: function(response) {
									var data = JSON.parse(response);
									if ((data[0].product).match(/Error: .*/)) {
										alert(data[0].product);
									}else{
										hideForm();
										getTotal();
										$('#table').bootstrapTable('load', data);
									}
								},
								error: function(response){
									alert('save detail error');
								}
						});
					} else alert('Please fill all data!');
				},
				error: function(response){
					alert('save header error');
				}
		});
		
		
		return false;
		
	});
</script>
