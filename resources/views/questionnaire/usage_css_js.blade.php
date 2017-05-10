{!! Html::style('js/dataTables/dataTables.bootstrap.css') !!}
{!! Html::style('js/loading/loading.css') !!}

{!! Html::script('js/dataTables/jquery.dataTables.js') !!}
{!! Html::script('js/dataTables/dataTables.bootstrap.js') !!}
{!! Html::script('https://www.gstatic.com/charts/loader.js') !!}
{!! Html::script('js/utility/TUtility.js') !!}

<script>
$(document).ready(function() {
    $('#usage_report').dataTable({
        searching: false
    });
});

$(document).ready(function() {
    google.charts.load('current', {packages: ['table']});
    google.charts.setOnLoadCallback(function() {});
});

$('#usage_report').on('click', 'tr', function() {
    var url = '{{ $url_compliance }}' + '/' + $(this).attr('data');
    console.log(url);
    
    $.ajax({
        url: url,
        async: true,
        dataType: 'json',
        success: function(json) {
            if( json )
            {
                if( isEmpty(json) )
                {
                    showHint("Not applicable");
                    return;
                }
                
                drawTimeLine(json);
            }
        },
    });
})
</script>

<script>
function showHint(hint)
{
    if( isEmpty(hint) )
    {
        $('#dlgCompliance').modal();
        /*$('#dlgCompliance').modal({
            keyboard: false,
            show: true
        });
        $('#dlgCompliance .modal-dialog').draggable({
            handle: "#dlgCompliance .modal-header"
        });//*/
    }
    else
    {
        $('#dialog_hint p').text(hint);
        $('#dialog_hint').modal();
    }
}

function drawTimeLine(json)
{
    //console.log(json);
    var hint=null;
    
    if( isEmpty(json['rows']) )
    {
        hint = "No Data";
    }
    else
    {
        var chart = new google.visualization.Table(document.getElementById('compliance_records'));
        var data = new google.visualization.DataTable(json);
        chart.draw(data);
    }
    
    showHint(hint);
}
</script>
