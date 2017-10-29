<section class="content-header">
    <h1><small>Form Master Category</small></h1>
    <ol class="breadcrumb">
</section></br>
<section class="content">
    <div class='row'>
        <div class='col-sm-6'>
            <form class='form_add' class='navbar-form'>
                <dl class='dl-horizontal'>
                    <input id='id' name='id' class='form-control' type='hidden' value="<?php echo $result['id']; ?>">
                    <dt>Category ID</dt>
                    <dd>
                        <input id='category_id' name='category_id' class='form-control' type='text' placeholder='Generated Automatically' value="<?php if ($mode == 'update') echo $result['category_id']; ?>" readonly>
                    </dd>
					<dt>Category Name</dt>
                    <dd>
                        <input id='category' name='category' class='form-control' type='text' placeholder='Name of the Category' value="<?php if ($mode == 'update') echo $result['category']; ?>">
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
			url: "<?php echo base_url();?>category/saveData",
				success: function(response) {
					alert(response);
					window.open("<?php echo base_url(); ?>category",'_parent');
				},
				error: function(response){
					alert('Error '+response);
				}
		});
		return false;
	});
</script>
