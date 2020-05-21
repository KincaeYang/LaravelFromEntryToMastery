<html>
<head>
    <title>Laravel学院 | @yield('title', '首页')</title>
</head>
<body>
<div class="container">
    @yield('content')
</div>
@section('footerScripts')
    <script src="{{ asset('js/app.js') }}"></script>        {{-- 默认提供的区块内容 --}}
@show
</body>
</html>