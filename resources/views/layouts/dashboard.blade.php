<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    @include('layouts.head.app')
<body>
    <div id="app">
        @include('layouts.nav.app')
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-block">
                        <ul class="nav nav-pills">
                            <li class="dropdown {{ Route::is('dashboard.academic_years.verified') || Route::is('dashboard.academic_years.unverified') || Route::is('dashboard.academic_years.archive') ? 'active' : '' }}">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    Mijn studiejaren <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="{{ Route::is('dashboard.academic_years.verified') ? 'active' : '' }}"><a href="{{ route('dashboard.academic_years.verified') }}">Geverifieerd</a></li>
                                    <li class="{{ Route::is('dashboard.academic_years.unverified') ? 'active' : '' }}"><a href="{{ route('dashboard.academic_years.unverified') }}">Niet geverifieerd</a></li>
                                </ul>
                            </li>
                            <li class="{{ Route::is('dashboard.payouts') ? 'active' : '' }}"><a href="{{ route('dashboard.payouts') }}">Mijn uitbetalingen</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="section-block">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.foot.app')
    </div><!-- /#app -->
    @include('layouts.scripts.app')
</body>
</html>
