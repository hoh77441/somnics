{!! Html::style('/js/fullcalendar/fullcalendar.min.css') !!}
{!! Html::style('/js/fullcalendar/fullcalendar.print.min.css', array('media' => 'print')) !!}
{{-- {!! Html::style('js/jquery-ui-1.10.4/css/base/jquery-ui-1.10.4.custom.css') !!} --}}

{{-- {!! Html::script('js/morris/raphael-2.1.0.min.js') !!} --}}
{{-- {!! Html::script('js/morris/morris.js') !!} --}}
{{-- {!! Html::script('js/custom.js') !!} --}}
{!! Html::script('js/fullcalendar/lib/moment.min.js') !!}
{!! Html::script('js/fullcalendar/lib/jquery.min.js') !!}
{!! Html::script('js/fullcalendar/fullcalendar.min.js') !!}

{{-- {!! Html::script('js/jquery-ui-1.10.4/js/jquery-ui-1.10.4.custom.js') !!} --}}
{!! Html::script('js/utility/TDateUtility.js') !!}
{!! Html::script('js/utility/TUtility.js') !!}

<style>
#calendar {
    max-width: 98%;
    margin: 0 auto;
}
</style>

<script>
$(document).ready(function() {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next',
            center: 'title',
            right: 'today'// 'month,basicWeek,basicDay'
        },
        defaultDate: '{{ date("Y-m-d") }}',
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        selectable: true,
        eventLimit: true, // allow "more" link when too many events
        /*dayClick: function(date, jsEvent, view) {
            requestByDate(date);
        },
        eventClick: function(calEvent, jsEvent, view) {
            requestByDate(calEvent.start);
        },//*/
        select: function(start, end, allDay) {
            //alert('select');
            $('#dlgEvent').modal();
        },
        events: [
            @if( isset($events) )
            @foreach( $events as $items )
                @foreach( $items as $event ) {
                start: '{{ $event->date }}',
                title: '{{ $event->title }}',
                color: '{{ $event->color }}'

                @if( $loop->parent->last && $loop->last )  {{-- the last event --}}
                }
                @else
                },
                @endif
                @endforeach
            @endforeach
            @endif
        ]
    });
});
</script>

<script>
$(document).ready(function() {
    //alert('{{ count($user->complianceApps) }}');
    //$("#dialog").dialog();
    $("#dialog").hide();
});

function requestByDate(date)
{
    var url = '{{ $eventUrl }}' + '/' + {{ $user->id }} + '/' + date.format();
    //var modal = $('#dlgEvent');
    //modal.modal();
    //$("#dialog").show();
    //$("#dialog").dialog();
    
    /*$(function() {
        $('#dlgEvent').modal();
    });//*/
    //console.log($(document));//.modal('show');
    //$('#dlgEvent').modal({
    //    show: 'false'
    //});
    //$('#dlgLogout').modal('toggle');
    //console.log('url: '+url);
    //$('#dlgEvent').modal();
    //alert('element: ');//.$('#dlgEvent'));
    //$('#dlgEvent').modal();
    /*$.ajax({
        url: url,
        async: true,
        dataType: 'json',
        beforeSend: function() {
            
        },
        complete: function() {
            
        },
        success: function(json) {
            if( json )
            {
                if( isEmpty(json) )
                {
                    console.log('no data -> do nothing');
                    return;
                }
                //var data = JSON.stringify(json);
                //console.log(json);
                //$('#dlgEvent').modal();
                //alert('loaded');
                //$('#dlgEvent').modal('show');
            }
        }
    });//*/
}
</script>
