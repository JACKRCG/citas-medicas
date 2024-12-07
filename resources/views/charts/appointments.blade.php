@extends('layouts.panel')

@section('content')
<div class="card shadow">
	<div class="card-header border-0">
		<div class="row align-items-center">
		  <div class="col">
		    <h3 class="mb-0">Reporte: Fecuencia de citas</h3>
		  </div>
		</div>
	</div>
	<div class="card-body">
		<div id="container"></div>
	</div>
</div>
@endsection

@section('scripts')
	
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<!--Puede ser Opcional-->
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>
	<script>
		Highcharts.chart('container', {
		    chart: {
		        type: 'line'
		    },
		    title: {
		        text: 'Citas registradas mensualmente'
		    },
		    subtitle: {
		        text: 'Source: ' +
		            '<a href="" ' +
		            'target="_blank"></a>'
		    },
		    xAxis: {
		        categories: [
		            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep',
		            'Oct', 'Nov', 'Dec'
		        ]
		    },
		    yAxis: {
		        title: {
		            text: 'Cantidad de citas'
		        }
		    },
		    plotOptions: {
		        line: {
		            dataLabels: {
		                enabled: true
		            },
		            enableMouseTracking: false
		        }
		    },
		    series: [{
		        name: 'Citas registradas',
		        data: @json($counts) //convertirmos en formato JSON los valores de las citas en cada mes
		    }/*, {
		        name: 'Tallinn',
		        data: [
		            -2.9, -3.6, -0.6, 4.8, 10.2, 14.5, 17.6, 16.5, 12.0, 6.5,
		            2.0, -0.9
		        ]
		    }*/]
		});
	</script>

@endsection