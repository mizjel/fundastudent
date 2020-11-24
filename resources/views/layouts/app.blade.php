<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    @include('layouts.head.app')
<body>
    <div id="app">
        @include('layouts.nav.app')

        @yield('content')

        @include('layouts.foot.app')
    </div><!-- /#app -->

    @include('layouts.scripts.app')
</body>
</html>
