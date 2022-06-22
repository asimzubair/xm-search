<!DOCTYPE html>
<html>
<head>
    @include('layouts.header')
</head>
<body class="bg-gray-100 font-family-karla flex">
    @include('layouts.left-menu')
    @yield('content')
    </div>
    @include('layouts.footer')
    @yield('js')
</body>
</html>
