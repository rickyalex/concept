<section class="content-header">
    <h1>
        <small>Daily Orders </small>
    </h1>
</section></br>


<section class="content-header">
    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4">
            <form class='form_add' class='navbar-form'>
                <dl class='dl-horizontal'>
                    <dt>Date</dt>
                    <dd>
                        <input id='date' name='date' class='dp form-control' type='text' placeholder='Date'>
                    </dd>
                </dl>
            </form>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-6'>
            <button id="button_submit" class="btn btn-success" type="submit">Search</button>
        </div>
    </div>
	<table id="table"
           data-toolbar="#toolbar"
           data-toggle="table"
           data-search="true"
           data-show-refresh="true"
           data-show-toggle="true"
           data-show-columns="true"
           data-show-export="true"
           data-minimum-count-columns="2"
           data-show-pagination-switch="true"
           data-pagination="true"
           data-page-list="[10, 25, 50, 100, ALL]"
           data-show-footer="false"
           data-export-data-type="all"
           data-export-types="['excel']"
           data-height="600">
        <thead>
            <tr>
                <th data-field="id">ID</th>
                <th data-field="order_no">Order No</th>
                <th data-field="date">Transaction Date</th>
                <th data-field="customer_name">Customer</th>
                <th data-field="status">Status</th>
        				<th data-field="product">Product</th>
        				<th data-field="qty">Qty</th>
        				<th data-field="price">Price</th>
        				<th data-field="subtotal">Subtotal</th>
                <th data-field="down_payment">DP</th>
            </tr>
        </thead>
    </table>
	<div class="modal"><!-- Place at bottom of page --></div>
</section>
<script>
    $(window).bind("load", function () {
        $('.dp').datepicker({changeMonth: true, changeYear: true, yearRange: "-100:+10"});
        $('.dp').datepicker("option", "dateFormat", "yy-mm-dd");
        $('#date').datepicker('setDate', '<?php echo Date('Y-m-d'); ?>');
    });

    $('#button_submit').on('click', function (e) {
        e.preventDefault();
		var date = $("#date").val();
        $.ajax({
            type: "POST",
			dataType: 'json',
            url: "<?php echo base_url(); ?>reports/getDailyOrders/date/"+date,
            success: function (res) {
                if($.isEmptyObject(res)) $('#table').bootstrapTable('removeAll');
				else $('#table').bootstrapTable('load', res);
            },
            error: function (response) {
                alert(response);
            }
        });
        return false;
    });
</script>
