@if (Auth::check())
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
                {{-- */$user = Auth::user()/* --}}
                <div class="navbar-right">
                 <a href="{{ route('logout') }}" class="btn btn-primary btn-lg" role="button">Logout</a>
                 <p class="navbar-right navbar-text">Hello, <a href="{{route('user.profile')}}" class="navbar-link">{{$user->name}}</a></p>
                </div>
        </div>
    </div>
</nav>
@else
    <style>body {padding-top: 0px !important;}</style>
@endif