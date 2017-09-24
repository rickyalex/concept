<section class="content-header">
    <h1>
        <small>Welcome, <?php echo USER_NAME; ?> </small>
    </h1>
</section></br>


<section class="content-header">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="box box-success box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Notifications</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div><!-- /.box-tools -->
				</div><!-- /.box-header -->
				<div class="box-body">
					<p class='text-yellow'>You have Open <?php echo $open; ?> Transaction(s). <a href='localhost/concept/reports'>View</a></p>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div> 
	<div class="row">
		<div class="col-md-4">
			<div class="box box-success">
				<div class="box-header">
					<h3 class="box-title">Sales By Type</h3>
				</div>
				<div class="box-body chart-responsive">
					<div class="chart" id="pie-chart" style="height: 400px;"></div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
		<div class="col-md-4">
			<div class="box box-success">
				<div class="box-header">
					<h3 class="box-title">Package Sales</h3>
				</div>
				<div class="box-body chart-responsive">
					<div class="chart" id="pie-chart2" style="height: 400px;"></div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
</section>
<!-- jQuery 2.1.3 -->
<script src="<?php echo base_url();?>assets/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<!-- Morris.js charts -->
<!--<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>-->
<script src="<?php echo base_url();?>assets/plugins/morris/morris.min.js" type="text/javascript"></script>
<!-- HIGHCHART -->
<script src="<?php echo base_url();?>assets/plugins/highcharts/highcharts.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/plugins/highcharts/modules/exporting.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/plugins/highcharts/themes/grid-light.js" type="text/javascript"></script>
<script>
    new Highcharts.Chart({
        chart: {
            renderTo: 'pie-chart'
        },
        credits: {
            enabled: false
        },
        title: false,
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        subtitle: {
            text: '',
            x: -20
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y}',
                },
                showInLegend: true
            }
        },
        series: [{
                name: 'Percentage',
                type: 'pie',
                data: <?php echo $chart1; ?>}],
        exporting: {
            enabled: false
        }
    });
    
    new Highcharts.Chart({
        chart: {
            renderTo: 'pie-chart2'
        },
        credits: {
            enabled: false
        },
        title: false,
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        subtitle: {
            text: '',
            x: -20
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y}',
                },
                showInLegend: true
            }
        },
        series: [{
                name: 'Percentage',
                type: 'pie',
                data: <?php echo $chart2; ?>}],
        exporting: {
            enabled: false
        }
    });
</script>
