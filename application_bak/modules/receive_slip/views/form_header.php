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
                    <dt>Document No</dt>
                    <dd>
                        <input id='document_no' name='document_no' class='form-control' type='text' placeholder='Generated Automatically' value="<?php echo $result['document_no']; ?>" readonly>
                    </dd>
					<dt>Date</dt>
                    <dd>
                        <input id='date' name='date' class='dp form-control' type='text' placeholder='Date' value="<?php if ($mode == 'update') echo $result['date']; ?>">
                    </dd>
                    <dt>Vendor</dt>
                    <dd>
                        <select id="vendor" name="vendor" class="form-control" style="width:300px" data-placeholder="Select Vendor">
                            <?php if ($mode == 'update') echo $result['vendor'];
                            else echo "<option></option>"; ?>
                        </select>
                    </dd>
                    <dt>Kurir</dt>
                    <dd>
                        <input id='kurir' name='kurir' class='form-control' type='text' placeholder='The couriers name' value="<?php if ($mode == 'update') echo $result['kurir']; ?>">
                    </dd>
                    <dt>Remarks</dt>
                    <dd>
                        <textarea id='remarks' name='remarks' class='form-control' rows=2 cols=1 type='text' placeholder='Remarks' ><?php if ($mode == 'update') echo $result['remarks']; ?></textarea>
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
		$("#vendor").select2({
			data : <?php echo $all_vendor; ?>
		});
		
		$('.dp').datepicker({ changeMonth: true, changeYear: true, yearRange: "-100:+10" });
		$('.dp').datepicker("option", "dateFormat", "yy-mm-dd" );
		$('#date').datepicker('setDate', '<?php echo $date; ?>');
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
			url: "<?php echo base_url();?>receive_slip/saveData/mode/header",
				success: function(response) {
					alert(response);
					window.open("<?php echo base_url(); ?>receive_slip",'_parent');
				},
				error: function(response){
					alert(response);
				}
		});
		return false;
	});
</script>
