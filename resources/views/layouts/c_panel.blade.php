<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    @include('layouts.head.app')
<body>
    <div id="app">
        @include('layouts.nav.app')
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="section-block">
                        <ul class="nav nav-pills nav-stacked">
                            <li class="dropdown {{ Route::is('c_panel.users.bank_accounts') ? 'active' : '' }}">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    Gebruikers <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="{{ Route::is('c_panel.users.bank_accounts') ? 'active' : '' }}"><a href="{{ route('c_panel.users.bank_accounts') }}">Bank Accounts</a></li>
                                </ul>
                            </li>
                            <li class="{{ Route::is('c_panel.payouts') ? 'active' : '' }}"><a href="{{ route('c_panel.payouts') }}">Uitbetalingen</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
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
