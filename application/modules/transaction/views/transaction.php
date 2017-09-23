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
			<input id="order_no" name="order_no" class="form-control input-sm" style="display:inline-block" type="text" placeholder="Order No" value="<?php if($mode=="update") echo $result['order_no'];else echo $order_no; ?>" readonly><br>
			<span style="display:inline-block;">Cust Name</span><br>
			<input id="customer_name" name="customer_name" class="form-control input-sm" style="display:inline-block" type="text" placeholder="Customer Name" value="<?php if($mode=="update") echo $result['customer_name']; ?>" <?php if($mode=="update") echo "readonly"; ?>><br>
			
		</div>
		<div class="col-xs-4 col-sm-4 col-md-4">
			<span style="display:inline-block;">Date</span><br>
			<input id="date" name="date" class="form-control input-sm" style="display:inline-block" type="text" placeholder="Date" value="<?php if($mode=="update") echo $result['date'];else echo date('Y-m-d'); ?>" readonly><br>
			<?php /*<span style="display:inline-block;">Package</span><br>
			<select id="package" name="package" class="form-control input-sm" style="width:300px" data-placeholder="Select Package" <?php if ($mode == 'update') echo "readonly"; ?>><br>
				<?php if ($mode == 'update') echo $result['package'];
				else echo "<option></option>"; ?>
            </select>*/ ?>
		</div>
		<div class="col-xs-4 col-sm-4 col-md-4">
			<span style="display:inline-block;">Receive Date</span><br>
			<input id="receive_date" name="receive_date" class="dp form-control input-sm" style="display:inline-block" type="text" placeholder="Received Date" value="<?php echo $result['receive_date']; ?>"><br>
			<span style="display:inline-block;">Down Payment</span><br>
			<div class="input-group">
				<span class="input-group-addon">Rp.</span>
				<input id="down_payment" name="down_payment" class="form-control input-sm" style="display:inline-block" type="text" placeholder="Down Payment" value="<?php echo $result['down_payment']; ?>"><br>
			</div>
			
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
           data-height="300"
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
            </tr>
        </thead>
    </table><br><br>
	<div class='row'>
		<div class='col-xs-4 col-sm-4 col-md-4'>
			<img id="back" onclick="window.open('<?php echo base_url(); ?>billed_transaction','_parent');" src ="<?php echo base_url();?>assets/img/back.png" width="70" height="70" style="border: #fff solid 1px" >
			<img id="add" onclick="showForm()" src ="<?php echo base_url();?>assets/img/add_detail.png" width="70" height="70" style="border: #fff solid 1px" >
			<img id="clear" onclick="clearData()" src ="<?php echo base_url();?>assets/img/clear.png" width="70" height="70" style="border: #fff solid 1px" >
			<img id="checkout" onclick="checkout()" src ="<?php echo base_url();?>assets/img/checkout.png" width="70" height="70" style="border: #fff solid 1px" >
		</div>
		<div class='col-xs-4 col-sm-4 col-md-4'>
		</div>
		<div id="payment_details" class='col-xs-4 col-sm-4 col-md-4'>
			<dl class='dl-horizontal'>
                <dt>Total</dt>
                <dd>
					<div class="input-group">
						<span class="input-group-addon">Rp.</span>
						<input id='total' name='total' class='form-control input-sm' type='text' value="<?php if($mode=="update") echo $result['total']; ?>" readonly>
					</div>
                </dd>
				<dt>Cash</dt>
                <dd>
					<div class="input-group">
						<span class="input-group-addon">Rp.</span>
						<input id='payment' name='payment' class='form-control input-sm' type='text' value="">
					</div>
                </dd>
                <dt>Change</dt>
                <dd>
					<div class="input-group">
						<span class="input-group-addon">Rp.</span>
						<input id='return' name='return' class='form-control input-sm' type='text' value="" readonly>
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
							<select id="product_id" name="product_id" class="form-control input-sm" style="width:300px" data-placeholder="Select Product"><br>
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
				<a id="add_item" href="#" class="btn btn-sm btn-success" style="margin:5px">Add</a><a href="#" onClick="hideForm()" class="btn btn-sm btn-default" style="margin:5px">Back</a>
			</div>
		</div>
	</div>
</div>
<script>
	$(window).bind("load", function() {
		$('.dp').datepicker({ changeMonth: true, changeYear: true, yearRange: "-100:+10" });
		$('.dp').datepicker("option", "dateFormat", "yy-mm-dd" );
		
		<?php if($mode=="update") { ?>
			$("#order_no").focus();
			$('#receive_date').val('<?php echo $result["receive_date"]; ?>');
		<?php }else{ ?>
			$("#customer_name").val('');
			$("#total").val('');
			$("#payment").val('');
			$("#return").val('');
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
	
	$('#payment').on('change', function(){
		$('#return').val($('#payment').val()-$('#total').val());
	});
	
	function showForm(){
		if(checkData()==true){
			$('#container').css('visibility','visible');
			$('#container').css('display','block');
			$('#qty').val('');
			$('#price').val('');
			$('#subtotal').val('');
			$("#product_id").focus();
		}
		else alert('Order No/Customer Name/Date Empty');
	}
	
	function hideForm(){
		$('#container').css('visibility','hidden');
		$('#container').css('display','none');
	}
	
	function clearData(){
		$('#table').bootstrapTable('removeAll');
	}
	
	function checkData(){
		if($('#order_no').val()=='') return false;
		else if($('#customer_name').val()=='') return false;
		else if($('#date').val()=='') return false;
		else if($('#receive_date').val()=='') return false;
		else if($('#down_payment').val()=='') return false;
		else return true;
	}
	
	function checkDataDetail(){
		if($('#product_id').val()=='') return false;
		else if($('#qty').val()=='') return false;
		else if($('#price').val()=='') return false;
		else if($('#subtotal').val()=='' || $('#subtotal').val()==0) return false;
		else return true;
	}
	
	function checkout(){
		var form_header = $(".form_header")[0];
		var formData = new FormData(form_header);
		$.ajax({
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			url: "<?php echo base_url();?>transaction/checkout/order_no/<?php echo $result['order_no']; ?>",
			success: function(response) {
				window.open('<?php echo base_url(); ?>transaction/print_out/order_no/<?php echo $result['order_no']; ?>','_blank');
				window.open('<?php echo base_url(); ?>billed_transaction','_parent');
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
					$('#total').val(response);
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
