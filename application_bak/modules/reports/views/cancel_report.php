<section class="content-header">
    <h1>
        <small>Cancel Report </small>
    </h1>
</section></br>


<section class="content-header">
    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4">
            <form class='form_add' class='navbar-form'>
                <dl class='dl-horizontal'>
                    <dt>Date From :</dt>
                    <dd>
                        <input id='datefrom' name='datefrom' class='dp form-control' type='text' placeholder='Date'>
                    </dd>
                    <dt>Date To :</dt>
                    <dd>
                        <input id='dateto' name='dateto' class='dp form-control' type='text' placeholder='Date'>
                    </dd>
                </dl>
            </form>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-6'>
            <button id="button_submit" class="btn btn-success" type="submit">Search</button>
            <button id="button_submit_Cancel" class="btn btn-success" type="submit">Download</button>
        </div>
    </div>
	<table id="table"
           data-toolbar="#toolbar"
           data-toggle="table"
           data-show-refresh="true"
           data-minimum-count-columns="2"
           data-pagination="true"
           data-page-list="[10, 25, 50, 100, ALL]"
           data-show-footer="true"
           data-export-data-type="all"
           data-export-types="['excel']"
           data-height="300">
        <thead>
            <tr>
                <th data-field="id">ID</th>
                <th data-field="order_no">Order No</th>
                <th data-field="date">Transaction Date</th>
                <th data-field="cancel_date">Cancel Date</th>
                <th data-field="customer_name">Customer</th>
				<th data-field="customer_phone">Phone</th>
				<th data-field="down_payment" data-footer-formatter="sumFormatter1">DP</th>
            </tr>
        </thead>
    </table>
	<div class="modal"><!-- Place at bottom of page --></div>
</section>
<script>
    $(window).bind("load", function () {
        $('.dp').datepicker({changeMonth: true, changeYear: true, yearRange: "-100:+10"});
        $('.dp').datepicker("option", "dateFormat", "yy-mm-dd");
        $('#datefrom').datepicker('setDate', '<?php echo Date('Y-m-d'); ?>');
        $('#dateto').datepicker('setDate', '<?php echo Date('Y-m-d'); ?>');
        
        
    });

    $('#button_submit').on('click', function (e) {
        e.preventDefault();
		var datefrom = $("#datefrom").val();
		var dateto = $("#dateto").val();
        $.ajax({
            type: "POST",
			dataType: 'json',
            url: "<?php echo base_url(); ?>reports/getCancel/datefrom/"+datefrom+"/dateto/"+dateto,
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

    $('#button_submit_Cancel').on('click', function (e) {
        e.preventDefault();        
        window.open("<?php //echo base_url(); ?>reports/downloadExcelCancel/"+$('#datefrom').val()+"/"+$('#dateto').val(), '_parent');            
    });

    function sumFormatter1(data) {
                field = this.field;
            return 'Rp. '+data.reduce(function(sum, row) { 
                return sum + (+row[field]);
            }, 0).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            }
</script>
