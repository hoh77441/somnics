<!DOCTYPE html>
<html lang="@yield('lang')">
    <head profile=http://www.w3.org/2005/10/profile">
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- bootstrap styles -->
        {!! Html::style('css/bootstrap.css') !!}
        {!! Html::style('css/font-awesome.css') !!}
        {{-- {!! Html::style('js/morris/morris-0.4.3.min.css') !!} --}}
        {!! Html::style('js/morris/morris.css') !!}
        {!! Html::style('js/jstree/themes/default/style.min.css') !!}
        {!! Html::style('css/custom.css') !!}
        <!-- google fonts -->
        {!! Html::style('http://fonts.googleapis.com/css?family=Open+Sans') !!}
        
        {!! Html::script('js/jquery-1.10.2.js') !!}
        {!! Html::script('js/bootstrap.min.js') !!}
        {!! Html::script('js/jquery.metisMenu.js') !!}
        {!! Html::script('js/jstree/jstree.min.js') !!}
        <!-- addition css and javascript -->
        {{-- @yield('css_js') --}}
        
        <link rel="shortcut icon" type="image/png" href="{{{ asset('favicon.png') }}}">
        <title>Welcome {{ Auth::user()->name }} </title>
    </head>
    
    <body>
        <div id="wrapper">
            <!-- draw header bar -->
            @include('layouts.headerbar')
            <!-- draw side menu -->
            @include('layouts.sidemenu')
            
            <!-- draw content  -->
            <div id="page-wrapper" >
                <div id="page-inner">
                    @yield('content')
                </div>  <!-- <div id="page-inner"> -->
            </div>  <!-- <div id="page-wrapper" > -->
        </div>
        <div>
            @include('layouts.footer')
        </div>  <!-- <div>(footer) -->
        
        @yield('css_js')
    </body>
</html>