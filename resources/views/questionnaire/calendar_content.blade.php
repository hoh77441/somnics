@if( !$isMe )
<!-- <div style="color: black;text-align: center;font-size: 200%">{{ $user->name }}</div> -->
<div class="panel panel-default">
    <div class="panel-heading">
        {{ $user->name }}'s Questionnaire(s)
    </div>
</div>
@endif

<!-- <div class="modal hide" id="dlgEvent" tabindex="-1" role="dialog" aria-labelledby="dlgEventTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="dlgEventTitle" style="color: blue;">Detail Questionnaire</h4>
            </div>
            <div class="modal-body">
                <p style="color: darkgray;">Are you sure want to quit "iNap Server"?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> -->
<div id="dialog" title="Basic dialog">
  <p>This is the default dialog which is useful for displaying information. The dialog window can be moved, resized and closed with the 'x' icon.</p>
</div>

<div id='calendar'></div>

{{-- {!! Html::script('js/morris/raphael-2.1.0.min.js') !!} --}}
{{-- {!! Html::script('js/morris/morris.js') !!} --}}
