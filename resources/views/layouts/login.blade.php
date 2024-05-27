<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles_sbadmin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">

    <title>Gltoz</title>

</head>
<body class="bg-login" style="background-image: url(img/background/bg-login-img.jpg)">

@yield('content')


<script src="{{ asset('js/bootstrap.bundle.min.js/') }}"></script>
<script src="{{ asset('js/scripts_sbadmin.js') }}"></script>
<script src="{{ asset('js/all.min.js') }}"></script>
</body>
</html>
