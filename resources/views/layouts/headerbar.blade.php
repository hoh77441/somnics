<nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <!-- <a class="navbar-brand" href="index.html">Console Admin</a> -->
        {!! Html::image('image/logo-somnics.png') !!}
    </div>
    <div class="dropdown" style="color: white;
        padding: 15px 50px 5px 50px;
        float: right;
        font-size: 16px;"> {{-- $user->name --}} {{-- <a href="/logout" class="btn btn-info"> --}}
        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            {{ Auth::user()->email }}'s Profile
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li class="disabled"><a href="#">Admin Console</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#" data-toggle="modal" data-target="#dlgLogout">Logout</a></li>
        </ul>
        
        <div class="modal fade" id="dlgLogout" tabindex="-1" role="dialog" aria-labelledby="dlgTitle" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="dlgTitle" style="color: blue;">Logout?</h4>
                    </div>
                    <div class="modal-body">
                        <p style="color: darkgray;">Are you sure want to quit "iNap Server"?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">{!! link_to_action('TControllerLogin@logout', 'Logout', null, ['style'=>'color: white;']) !!}</button>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Welcome: {{ $user->name }}
        {!! link_to_action('TControllerLogin@logout', 'Logout', null, ['class' => 'btn btn-info']) !!} --}}
    </div>
</nav>
