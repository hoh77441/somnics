<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
            <li class="text-center">
                {{-- !! Html::image('image/logo-somnics.png') !! --}}  <!-- remove the logo -->
            </li>
            @if( isset($menuItems) )
                @foreach( $menuItems as $menuItem )
                <li>
                    @if( isset($menuItem->subMenu) )
                        @if( $loop->index == $selected )
                        <a class="active-menu" href="#"><i class='{{ $menuItem->icon }}'></i> {{ $menuItem->title }}<span class="fa arrow"></span></a>
                        @else
                        <a href="#"><i class="{{ $menuItem->icon }}"></i> {{ $menuItem->title }}<span class="fa arrow"></span></a>
                        @endif
                        
                        <ul class="nav nav-second-level">
                        @foreach( $menuItem->subMenu as $subMenu )
                        <li><a href="{{ $subMenu->url }}"><i class='{{ $subMenu->icon }}'></i> {{ $subMenu->title }}</a></li>
                        @endforeach
                        </ul>
                    @else
                        @if( $loop->index == $selected )  {{-- $loop->index is current index: zero base --}}
                        <a  class='active-menu' href='{{ action($menuItem->url, null) }}'><i class='{{ $menuItem->icon }}'></i> {{ $menuItem->title }}</a>
                        @else
                        <a href="{{ action($menuItem->url, null) }}"><i class="{{ $menuItem->icon }}"></i> {{ $menuItem->title }}</a>
                        @endif
                    @endif
                </li>
                @endforeach
            @endif
        </ul>  <!-- <ul class="nav" id="main-menu"> -->
    </div>  <!-- <div class="sidebar-collapse"> -->
</nav>  <!-- <nav class="navbar-default navbar-side" role="navigation"> -->

<script>
$(document).ready(function() {
    $('#main-menu').metisMenu();
    $(window).bind("load resize", function () {
        if ($(this).width() < 768) {
            $('div.sidebar-collapse').addClass('collapse')
        } else {
            $('div.sidebar-collapse').removeClass('collapse')
        }
    });
});
</script>
