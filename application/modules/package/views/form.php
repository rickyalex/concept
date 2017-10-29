<?php
  echo $mode;
  echo $result['id'];
?>
<section class="content-header">
    <h1><small>Form Package</small></h1>
    <ol class="breadcrumb">
</section></br>
<section class="content">
    <div class='row'>
        <div class='col-sm-6'>
            <form class='form_add' class='navbar-form'>
                <dl class='dl-horizontal'>
                    <input id='id' name='id' class='form-control' type='hidden' value="<?php if ($mode == 'update') echo $result['id']; ?>">
                    <dt>Package Name</dt>
                    <dd>
                        <input id='package' name='package' class='form-control' type='text' placeholder='The Name of the Package' value="<?php if ($mode == 'update') echo $result['package']; ?>">
                    </dd>
                </dl>
            </form>
        </div>
        <div class='col-sm-6'>
                <dl class='dl-horizontal'>
                    <dt>Package Price</dt>
                    <dd>
                        <input id='total' name='total' class='form-control' type='text' placeholder='Total price' value="<?php if ($mode == 'update') echo $total; ?>">
                    </dd>
                </dl>
            <dl class='dl-horizontal'>
                    <dt>Package Profit</dt>
                    <dd>
                        <input id='profit' name='profit' class='form-control' type='text' placeholder='Total profit' value="<?php if ($mode == 'update') echo $profit; ?>">
                    </dd>
                </dl>
        </div>
    </div>
	<div id="toolbar">
        <button id="add" class="btn btn-success">
            <i class="glyphicon glyphicon-add"></i> Add
        </button>
    </div>
    <table id="table"
           data-toolbar="#toolbar"
           data-toggle="table"
           data-show-refresh="true"
           data-minimum-count-columns="2"
           data-pagination="true"
           data-page-list="[10, 25, 50, 100, ALL]"
           data-show-footer="false"
           data-export-data-type="all"
           data-export-types="['excel']"
           data-height="300"
           data-url="<?php echo base_url(); ?>package/getDetailData/id/<?php echo $result['id']; ?>">
        <thead>
            <tr>
                <th data-field="id">ID</th>
                <th data-field="product">Product</th>
				<th data-field="qty">Qty</th>
                                <th data-field="selling_price">Sell Price</th>
                                <th data-field="receive_price">Receive Price</th>
				<th data-field="action">Action</th>
            </tr>
        </thead>
    </table><br>
    <div class='row'>
		<div class='col-sm-6'>
			<button id="button_submit" class="btn btn-success" type="submit">Save</button>
        </div>
    </div>
	<div class="modal"><!-- Place at bottom of page --></div>
</section>
<script>
  $(window).bind("load", function() {
    <?php if ($mode != 'update'){ ?>
      $('#toolbar').hide();
    <?php } ?>
  });
  
	var $table = $('#table');
	var $add = $('#add');
    $table.on('dbl-click-row.bs.table', function (row, $element) {
		window.open("<?php echo base_url(); ?>package/detail/id_header/<?php echo $result['id']; ?>/id/"+$element.id,'_parent');
    });
    $add.on('click',function(){
		window.open("<?php echo base_url(); ?>package/detail/id_header/<?php echo $result['id']; ?>",'_parent');
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
			url: "<?php echo base_url();?>package/saveData",
				success: function(response) {
          if (response.match(/.* Empty.*/)) {
            alert(response);
          }else{
  					alert(response);
  					window.open("<?php echo base_url(); ?>package",'_parent');
          }
				},
				error: function(response){
					alert(response);
				}
		});
		return false;
	});
	
  $(document).on('click', '.remove', function (e){
    //if(field=='action'){
    var id = $(this).parent().siblings(":first").text();
    // alert(id);
    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>package/remove_detail/id/"+id,
      success: function(s){
        alert(s);
        if (s.match(/.*Success/)) {
          location.reload();
        }
        
      }
      ,
      error: function(e){
        alert('Delete Error');
      }
    });
  });
	
</script>
