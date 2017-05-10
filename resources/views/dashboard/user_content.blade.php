<div class="row">
    <div class="col-md-12">
        <h2>{{ $user->name }} Dashboard</h2>   
        <h5>Welcome iNap Management Server.</h5>
    </div>
</div>              
<!-- /. ROW  -->
<hr />
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-6">
        @foreach($statistics as $item)
        <div class="panel panel-back noti-box">
            <a href='{{ $item->url }}'>
                <span class="{{ $item->shape }}">
                    <i class="{{ $item->icon }}"></i>
                </span>
                <div class="text-box">
                    <p class="main-text">{{ $item->title }}</p>
                    <p class="text-muted">{{ $item->subTitle }}</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    <div class="col-md-9 col-sm-12 col-xs-12">                     
        <div class="panel panel-default">
            <div class="panel-heading">
                Sealing & Leakage Statistics
            </div>
            <div class="panel-body">
                <div id="chart_treatment"></div>
            </div>
        </div>            
    </div>
</div>

<div class="row" id="loading">
    <div class="col-md-12">
        <div class="progress">
            <div class="progress-bar progress-bar-info" id="progressbar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                <span>Loading ...</span>
            </div>
        </div>
    </div>    
</div>

<div class="row" id="detail">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span id="monitorTitle"></span>
            </div>
            <div class="panel-body">
                <div id="chart_monitor"></div>
            </div>
        </div>
    </div>
</div>
    