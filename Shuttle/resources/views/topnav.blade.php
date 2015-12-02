@if (Auth::check())
    <div class="container">
        <!-- Static navbar -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">

                <div class="navbar-header">
                    <a href="/" class="pull-left"><img class="brand" alt="WonderShuttle" src="/imgs/logo.png"></a>
                </div>

                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">

                        <!-- All Users Tabs -->

                        <li {!! active('/') !!}><a href="/">Home</a></li>
                        <li {!! active('booking') !!}><a href="{{route('booking.index')}}">Book a Shuttle</a></li>
                        <li {!! active('booking/mine') !!}><a href="{{route('booking.mine')}}">My Bookings</a></li>
                        
                        <!-- Driver Specific Tabs -->
                        
                        @if (Auth::user()->isDriver())
                            <li class="divider-vertical"></li>
                            <li {!! active('trip/schedule') !!}><a href="{{route('trip.schedule')}}">My Schedule</a></li>
                        @endif

                        <!-- Manager Specific Tabs -->

                        @if (Auth::user()->isManager() || Auth::user()->isAdmin())
                            <li class="divider-vertical"></li>
                            <li {!! active('trip') !!}><a href="{{route('trip.index')}}">Manage Trips</a></li>
                            <li {!! active('shuttle') !!}><a href="{{route('shuttle.index')}}">Manage Shuttles</a></li>
                            <li {!! active('user') !!}><a href="{{route('user.index')}}">Manage Users</a></li>
                        @endif
                    </ul>
                    
                    <!-- Auth links -- pulled right -->
                    
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{route('user.profile')}}">Hello, {{ Auth::user()->name }}</a></li>
                        <li><a href="{{route('logout')}}">Logout</a></li>
                    </ul>

                </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
        </nav>
    </div>

@else
    <!-- Fix fixed-topnav if there is no topnav -->
    <style>body {padding-top: 0px !important;}</style>
@endif