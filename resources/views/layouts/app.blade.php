<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Laravel Shop') - Laravel 电商教程</title>
    <!-- 样式 -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app" class="{{ route_class() }}-page">
        @include('layouts._header')
        <div class="container">
            @yield('content')
        </div>
        @include('layouts._footer')
    </div>
    <!-- JS 脚本 -->
    <script src="{{ mix('js/app.js') }}"></script>
    @yield('scriptsAfterJs')

    @section('scriptsAfterJs')
    <script>
        $(document).ready(function() {
          // 删除按钮点击事件
          $('.btn-del-address').click(function() {
            // 获取按钮上 data-id 属性的值，也就是地址 ID
            var id = $(this).data('id');
            // 调用 sweetalert
            swal({
                title: "确认要删除该地址？",
                icon: "warning",
                buttons: ['取消', '确定'],
                dangerMode: true,
              })
            .then(function(willDelete) { // 用户点击按钮后会触发这个回调函数
              // 用户点击确定 willDelete 值为 true， 否则为 false
              // 用户点了取消，啥也不做
              if (!willDelete) {
                return;
              }
              // 调用删除接口，用 id 来拼接出请求的 url
              axios.delete('/user_addresses/' + id)
                .then(function () {
                  // 请求成功之后重新加载页面
                  location.reload();
                })
            });
          });
        });
        </script>
    @endsection
</body>
</html>