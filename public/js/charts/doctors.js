const chart = Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Médicos más activos',
        align: 'center'
    },
    subtitle: {
        text:
            'con mas citas atendidas: <a target="_blank" ' +
            'href="#"></a>',
        align: 'center'
    },
    xAxis: {
        categories: [],
        crosshair: true,
        accessibility: {
            description: 'Médicos'
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Registro de Citas'
        }
    },
    tooltip: {
        valueSuffix: ' (citas)'
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: []
});

let $start, $end;

function fetchData() {
    const startDate = $start.val();
    const endDate = $end.val();

    //Fetch API
    const url = `/charts/doctors/column/data?start=${startDate}&end=${endDate}`;
    fetch(url)
    .then(response => response.json())
    .then(datos => {
        //console.log(data);
        chart.xAxis[0].setCategories(datos.categories);
        //para limpiar los datos de las columnas
        if(chart.series.length > 0){
            //para eliminar se realiza de manera descendente ya que se toman posiciones si hay vacios en el arreglo
            chart.series[2].remove();
            chart.series[1].remove();
            chart.series[0].remove();    
        }        

        chart.addSeries(datos.series[0]);
        chart.addSeries(datos.series[1]);
        chart.addSeries(datos.series[2]);
    });
}

$(function () {
    
    $start = $('#startDate');
    $end = $('#endDate');

    fetchData();    

    $start.change(fetchData);
    $end.change(fetchData);
});