<section class="content-header">
    <h1>
        <small>Daily Reports </small>
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
            <button id="button_search" class="btn btn-success" type="submit">Search</button>
            <button id="button_submit_All" class="btn btn-success" type="submit">Download All</button>
            <button id="button_submit_Range" class="btn btn-success" type="submit">Download Range</button>
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
           data-show-footer="true"
           data-export-data-type="all"
           data-export-types="['excel']"
           data-height="600">
        <thead>
            <tr>
                <th data-field="date">Transaction Date</th>
				<th data-field="closed_date">Closed Date</th>
                <th data-field="type_name">Tipe</th>
                <th data-field="product">Produk</th>
                <th data-field="total">Qty Order</th>
                <th data-field="qty">Qty Produk</th>
                <th data-field="price">Harga Paket</th>
                <th data-field="subtotal" data-footer-formatter="sumFormatter1">Subtotal</th>
                <th data-field="laba_studio" data-footer-formatter="sumFormatter1">Laba Studio</th>
                <th data-field="laba_produk" data-footer-formatter="sumFormatter1">Laba Produk</th>
                <th data-field="modal_produk" data-footer-formatter="sumFormatter1">Modal Produk</th>
            </tr>
        </thead>
    </table>
</section>
<script>
    $(window).bind("load", function () {
        $('.dp').datepicker({changeMonth: true, changeYear: true, yearRange: "-100:+10"});
        $('.dp').datepicker("option", "dateFormat", "yy-mm-dd");
        $('#datefrom').datepicker('setDate', '<?php echo Date('Y-m-d'); ?>');
        $('#dateto').datepicker('setDate', '<?php echo Date('Y-m-d'); ?>');
    });

    function sumFormatter1(data) {
        field = this.field;
        return 'Rp. '+data.reduce(function(sum, row) { 
            return sum + (+row[field]);
        }, 0).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    }

    $('#button_search').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?php echo base_url(); ?>reports/getDailyReportsTable/"+$('#datefrom').val()+"/"+$('#dateto').val(),
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

    $('#button_submit_All').on('click', function (e) {
        e.preventDefault();
        // var form = $(".form_add")[0];
        // var formData = new FormData(form);
        // $.ajax({
        //     type: "POST",
        //     data: formData,
        //     contentType: false,
        //     processData: false,
        //     url: "<?php //echo base_url(); ?>reports/getDailyReports",
        //     success: function (response) {
        //         alert(response);
                // window.open("<?php //echo base_url(); ?>reports/viewDailyReports", '_parent');
                window.open("<?php //echo base_url(); ?>reports/downloadExcel", '_parent');
        //     },
        //     error: function (response) {
        //         alert(response);
        //     }
        // });
        // return false;
    });
    $('#button_submit_Range').on('click', function (e) {
        e.preventDefault();
        // var form = $(".form_add")[0];
        // var formData = new FormData(form);
        // $.ajax({
        //     type: "POST",
        //     data: formData,
        //     contentType: false,
        //     processData: false,
        //     url: "<?php //echo base_url(); ?>reports/getDailyReports",
        //     success: function (response) {
                // alert(response);
                // window.open("<?php //echo base_url(); ?>reports/viewDailyReports", '_parent');
                window.open("<?php //echo base_url(); ?>reports/downloadExcelRange/"+$('#datefrom').val()+"/"+$('#dateto').val(), '_parent');
        //     },
        //     error: function (response) {
        //         alert(response);
        //     }
        // });
        // return false;
    });
</script>
