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
            <button id="button_submit" class="btn btn-success" type="submit">Save</button>
        </div>
    </div>

</section>
<script>
    $(window).bind("load", function () {
        $('.dp').datepicker({changeMonth: true, changeYear: true, yearRange: "-100:+10"});
        $('.dp').datepicker("option", "dateFormat", "yy-mm-dd");
        $('#date').datepicker('setDate', '<?php echo Date('Y-m-d'); ?>');
    });

    $('#button_submit').on('click', function (e) {
        e.preventDefault();
        var form = $(".form_add")[0];
        var formData = new FormData(form);
        $.ajax({
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            url: "<?php echo base_url(); ?>reports/getDailyReports",
            success: function (response) {
                alert(response);
                window.open("<?php //echo base_url(); ?>reports/viewDailyReports", '_parent');
            },
            error: function (response) {
                alert(response);
            }
        });
        return false;
    });
</script>
