<!DOCTYPE html>
<html lang="EN">
    <head profile=http://www.w3.org/2005/10/profile">
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- bootstrap styles -->
        {!! Html::style('css/bootstrap.css') !!}
        {!! Html::style('css/login.css') !!}
        <!-- google fonts -->
        {!! Html::style('http://fonts.googleapis.com/css?family=Open+Sans') !!}
        <!-- <link rel="icon" type="image/png" href="favicon.png"/> -->
        <link rel="shortcut icon" type="image/png" href="{{{ asset('favicon.png') }}}">
        
        <title>Welcome @yield('title')</title>
    </head>
    
    <body>
        @yield('content')
    </body>
</html>