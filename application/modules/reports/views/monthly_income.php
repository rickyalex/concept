<section class="content-header">
    <h1>
        <small>Monthly Income </small>
    </h1>
</section></br>


<section class="content-header">
	<div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-body chart-responsive">
                  <div class="chart" id="chart-income" style="height: 400px;"></div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
	<div class="modal"><!-- Place at bottom of page --></div>
</section>
<script src="<?php echo base_url();?>assets/js/highcharts/js/highcharts.js"></script>
<script>
    $(window).bind("load", function () {
        $('.dp').datepicker({changeMonth: true, changeYear: true, yearRange: "-100:+10"});
        $('.dp').datepicker("option", "dateFormat", "yy-mm-dd");
        $('#datefrom').datepicker('setDate', '<?php echo Date('Y-m-d'); ?>');
        $('#dateto').datepicker('setDate', '<?php echo Date('Y-m-d'); ?>');
        
        
    });

	
	$(document).ready(function(){
		new Highcharts.Chart({
			  chart: {
			   renderTo: 'chart-income'
			  },
					 title: {
					text: 'Concept Photo'
				},

				subtitle: {
					text: 'Monthly Income <?php echo date('F', mktime(0, 0, 0, Date('m'), 10)); ?>'
				},
				 xAxis: {		
								title: {
									text: 'Tanggal'
								},
								categories: ['<?php echo Date('Y'); ?>']
								
							},
				yAxis: {
					min:0,
					tickInterval: 1,//set interval
					title: {
						text: 'Rp'
					},
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'middle'
				},

				plotOptions: {
					series: {
						pointStart: 1
					}
				},

				series: [{
					name: <?php print (date('Y'));?>,
					data: <?php echo $res; ?> 
				}],
			  exporting: {
						enabled: true
					}
		});
	});
		
    // $('#button_submit').on('click', function (e) {
        // e.preventDefault();
		// var datefrom = $("#datefrom").val();
		// var dateto = $("#dateto").val();
        // $.ajax({
            // type: "POST",
			// dataType: 'json',
            // url: "<?php echo base_url(); ?>reports/getMonthlyIncome/datefrom/"+datefrom+"/dateto/"+dateto,
            // success: function (res) {
                // //var item = JSON.parse(res);
				// console.log(res);
				// var options = {
					   // chart: {
						   // renderTo: 'chart-income'
					   // },
					  // series: [{}]
				   // };
				   
				// options.series[0].data = res;
				// var chart = new Highcharts.Chart(options);
            // },
            // error: function (response) {
                // alert(response);
            // }
        // });
        // return false;
    // });
    
    
</script>
