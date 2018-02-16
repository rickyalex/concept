<section class="content-header">
    <h1>
        <small>Monthly Reports </small>
    </h1>
</section></br>


<section class="content-header">
    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4">
            <form class='form_add' class='navbar-form'>
                <dl class='dl-horizontal'>
                    <dt>Month :</dt>
                    <dd>
                        <select id='month' name='month' class='form-control' type='text' placeholder='Month'>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </dd>
                    <dt>Year :</dt>
                    <dd>
                        <select id='year' name='year' class='form-control' type='text' placeholder='Year'>
                            <option value="<?php echo Date('Y')-2; ?>"><?php echo Date('Y')-2; ?></option>
                            <option value="<?php echo Date('Y')-1; ?>"><?php echo Date('Y')-1; ?></option>
                            <option value="<?php echo Date('Y'); ?>" selected><?php echo Date('Y'); ?></option>
                        </select>
                    </dd>
                </dl>
            </form>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-6'>
            <button id="button_submit" class="btn btn-success" type="submit">Download</button>
        </div>
    </div>

</section>
<script>
    $(window).bind("load", function () {
        $('select[name=month]').val("<?php echo date('n'); ?>");
    });

    $('#button_submit').on('click', function (e) {
        e.preventDefault();
        var mon = $('select[name=month]').val();
        var yr = $('select[name=year]').val();
        var form = $(".form_add")[0];
        var formData = new FormData(form);
        $.ajax({
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            url: "<?php echo base_url(); ?>reports/getMonthlyReports",
            success: function (response) {
                alert(response);
                // window.open("<?php //echo base_url(); ?>reports/viewDailyReports", '_parent');
                window.open("<?php echo base_url(); ?>reports/downloadExcelMonthly/"+ mon + "/" + yr, '_blank');
            },
            error: function (response) {
                alert(response);
            }
        });
        return false;
    });
</script>
