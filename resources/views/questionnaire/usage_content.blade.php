<div class="panel panel-default">
    <div class="panel-heading">
        {{ $user->email }}'s Usage Report
    </div>

    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="usage_report">
                <thead>
                    <tr >
                        <th>Night No.</th>
                        <th>Serial No</th>
                        <th>Start<br />End</th>
                        <th>Treatment</th>
                        <th>Sealing</th>
                        <th>Evening</th>
                        <th>Morning</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($detail as $key => $value)
                    <tr data="{{ $key }}">  {{-- $key is appId --}}
                        <td>{{ $value['night_no'] }}</td>
                        <td>
                        @if ( $value['change_console'] )
                        <font color='blue'>{{ $value['serial_no'] }}</font>
                        @else
                        {{ $value['serial_no'] }}
                        @endif
                        </td>
                        <td>{{ $value['app_start'] }}<br />{{ $value['app_end'] }}</td>
                        @if( $loop->last )
                        <td>N/A</td>
                        <td>N/A</td>
                        @else
                        <td>{{ $value['treatment'] }}</td>
                        <td>{{ $value['sealing'] }}</td>
                        @endif
                        <td>{{ $value['evening1'] }}<br />{{ $value['evening2'] }}</td>
                        <td>{{ $value['morning1'] }}<br />{{ $value['morning2'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>  <!-- <div class="table-responsive"> -->
    </div>  <!-- <div class="panel-body"> -->
    
    <!-- <div class="panel-footer">
        Export TO CSV
    </div> -->
    
    <!-- for detail compliance record -->
    <div class="modal fade" id="dlgCompliance" tabindex="-1" role="dialog" aria-labelledby="dlgComplianceTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="dlgComplianceTitle" style="color: blue;">Detail of Compliance Record</h4>
                </div>
                <div class="modal-body">
                    <div id="compliance_records"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="dialog_hint" tabindex="-1" role="dialog" aria-labelledby="dialog_hint_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="dialog_hint_title" style="color: blue;">Detail of Compliance Record</h4>
                </div>
                <div class="modal-body">
                    <p style="color: darkgray;">No Data</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>  <!-- <div class="panel panel-default"> -->
