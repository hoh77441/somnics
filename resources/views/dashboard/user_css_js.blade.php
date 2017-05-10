{!! Html::script('/js/morris/morris.min.js') !!}
{!! Html::script('/js/morris/raphael-2.1.0.min.js') !!}
{!! Html::script('https://www.gstatic.com/charts/loader.js') !!}
{!! Html::script('js/utility/TDateUtility.js') !!}
{!! Html::script('js/utility/TUtility.js') !!}
{{-- {!! Html::script('js/loading/jquery.isloading.min.js') !!} --}}

<script>
$(document).ready(function() {
    google.charts.load('current', {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawChart);
});
function drawChart() {
    var data = new google.visualization.DataTable();
    data.addColumn({type: 'string', label: 'Date'});
    data.addColumn({type: 'number', label: 'Sealing'});
    data.addColumn({type: 'number', label: 'Leakage'});
    data.addRows([
        @foreach($treatments as $date => $treatment)
        ['{{ $date }}', {{ $treatment->sealing }}, {{ $treatment->leakage }}],
        @endforeach
    ]);
    var options = {
        //title: 'Usage history',
        legend: { position: "top", alignment: "start" }
    };
    var chart = new google.visualization.ColumnChart(document.getElementById('chart_treatment'));
    
    //customize data format
    for( var i=0; i < data.getNumberOfRows(); i++ )
    {
        var seal = data.getValue(i, 1);  //1 for seal in second
        data.setFormattedValue(i, 1, toTime(seal));
        
        var leak = data.getValue(i, 2);  //2 for leakage in second
        data.setFormattedValue(i, 2, toTime(leak));
    }
    
    //customize label format
    var runOnce = google.visualization.events.addListener(chart, 'ready', function() {
        google.visualization.events.removeListener(runOnce);
        var bb, val, formatted, ticks=[], cli = chart.getChartLayoutInterface();
        for(var i=0; bb=cli.getBoundingBox('vAxis#0#gridline#' + i); i++ )
        {
            val = cli.getVAxisValue(bb.top);
            if( val != parseInt(val) )
            {
                val = cli.getVAxisValue(bb.top + bb.height / 2);
            }
            
            formatted = toTime(val);
            ticks.push({v: val, f: formatted});
        }  //end of for(var i=0; bb=cli.getBoundingBox('vAxis#0#gridline#' + i); i++ )
        
        options.vAxis = options.vAxis || {};
        options.vAxis.ticks = ticks;
        chart.draw(data, options);
    });  //end of runOnce
    
    google.visualization.events.addListener(chart, 'select', function() {
        var selection = chart.getSelection();
        var item = selection[0];
        if( item == null )  //double select the same item will trigger toggle => null
        {
            return;
        }
        //var format = data.getFormattedValue(item.row, item.column);
        //var val = data.getValue(item.row, item.column);
        var date = data.getValue(item.row, 0);
        drawDetail(date);
    });
    
    google.visualization.events.addListener(chart, 'click', function(e) {
        var parts = e.targetID.split('#');
        if( parts.indexOf('label') >= 0 )
        {
            var idx = parts[parts.indexOf('label') + 1];
            drawDetail(data.getValue(parseInt(idx), 0));
        }
    });
    
    chart.draw(data, options);
}
</script>

<script>
$(document).ready(function() {
    $('#loading').hide();
    $('#detail').hide();
});

function drawDetail(date) 
{
    var url = '{{ $monitor }}' + '/' + {{ $user->id }} + '/' + date;
    var monitorData;
    var progress=0, timerId;
    
    $.ajax({
        url: url,
        async: true,
        dataType: 'json',
        beforeSend: function() {
            $('#loading').show();
            //setTimeout(function() {  //only run once
            timerId = setInterval(function() {  //run until complete
                progress += 5;
                $('#progressbar').css('width', progress.toString() + '%');
            }, 100);
        },
        complete: function() {
            $('#loading').hide();
            clearInterval(timerId);
        },
        success: function(json) {
            if( json )
            {
                //console.log(JSON.stringify(json));
                if( isEmpty(json) )
                {
                    alert('no data');
                    return;
                }
                drawMonitor(date, json);
            }
        },
    });
}

function drawMonitor(date, json)
{
    $('#detail').show();
    $('#monitorTitle').html('Detail data at <strong><font color="blue">' + date + '</font></strong>');
    
    var chartMonitor = new google.visualization.LineChart(document.getElementById('chart_monitor'));
    var optionMonitor = {
        legend: { position: "bottom", alignment: "start" }
    };
    var dataMonitor = new google.visualization.DataTable(json);
    
    chartMonitor.draw(dataMonitor, optionMonitor);
}
</script>
