<script src="<?php echo base_url();?>assets/js/jquery.js"></script>

<div class="col-lg-12">
<h3 class="title">Change Confirmation Code</h3>
</div>

<div class="col-lg-6">
	<form class='form_add' class='navbar-form'>
		<dl class='dl-horizontal'>
            <dt>New Code</dt>
            <dd>
				<input id='confirmpass' name='confirmpass' class='form-control' type='text' placeholder='Confirmation Code' value="">
            </dd>
        </dl>
	<div class='row'>
		<div class='col-sm-6'>
			<button id="button_submit" class="btn btn-success" type="submit">Save</button>
        </div>
    </div>
	</form>
</div>

<script>
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
			url: "<?php echo base_url();?>auth/action_change_confirmation",
				success: function(response) {
					alert('code updated');
					window.open("<?php echo base_url(); ?>dashboard",'_parent');
				},
				error: function(response){
					alert(response);
				}
		});
		return false;
	});
</script>