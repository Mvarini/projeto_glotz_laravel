<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{--    <link rel="stylesheet" href="{{ asset('css/aux.css') }}" type="text/css">--}}
    <link rel="stylesheet" href="/public/css/aux.css" type="text/css">

    {{--        <link rel="stylesheet" href="{{ public_path('css/aux.css') }}" type="text/css">--}}
    <style>
        body {
            color: black;
            display: table;
            font-family: Arial, Georgia, serif;
            font-size: 18px;
            margin-left: 150px;
            text-align: center;

        }

        .container {
            /*border: 3px solid #CF6E00;*/
            width: 750px;
            height: 563px;
            vertical-align: middle;
            text-align: center;
            /*position: absolute;*/
            /*top: 100px;*/
            /*display: block;*/
            /*z-index: 1;*/
            /*left: 100px;*/
        }

        .logo {
            position: absolute;
            top: 0;
            left: 0;

        }

        .marquee {
            color: midnightblue;
            font-size: 100px;
            margin: 20px;
            padding-bottom: 20px;
            padding-top: 20px;
        }

        .assignment {
            margin: 20px;
        }

        .person {
            color: midnightblue;
            font-size: 32px;
            font-style: italic;
            margin: 20px;
            width: 100%;
            padding-bottom: 20px;
        }

        .reason {
            margin: 20px;
            padding-bottom: 50px;
        }

        .professor {
            display: block;
            justify-content: center;
            margin: 20px;
            /*margin-top: 20px;*/
        }

        .professor-image {
            margin-bottom: 0;
        }

        /*.relative{*/
        /*    position: relative;*/
        /*    z-index: -1;*/
        /*}*/
    </style>

    <title>Glotz - Certificado</title>

</head>
<body>

{{--    <img src="{{$image}}" alt="" width="100" height="50"/>--}}

{{--<div class="relative">--}}
{{--    @php--}}
{{--        $imageFile = public_path('img/template/certificate_course_2.png');--}}
{{--        $imgData = base64_encode(file_get_contents($imageFile));--}}
{{--        $base64_image = 'data:image/png;base64,' . $imgData;--}}

{{--        echo '<img src="' . $base64_image .'" alt="" style="width:105%; height:105%"/>'--}}

{{--    @endphp--}}


<div class="container">
    <div class="logo">
        @php
            $imageFile = public_path('img/icon/glotzorange.png');
            $imgData = base64_encode(file_get_contents($imageFile));
            $base64_image = 'data:image/jpeg;base64,' . $imgData;

            echo '<img src="' . $base64_image .'" alt="" width="80" height="40"/>'

        @endphp
        {{--        <img src="/img/icon/glotzorange.png" alt="" style="width: 100px">--}}
        {{--        <img src="{{asset('glotzorange.png')}}" alt="" style="width: 100px">--}}
        {{--        <img src="http://localhost:8000/projeto_glotz_laravel/public/img/icon/glotzorange.png" alt="" style="width: 100px">--}}

    </div>

    <div class="marquee">
        CERTIFICADO
    </div>

    <div class="person">
        {{ $student->user->name }}
    </div>

    <div class="reason">
        Certificamos que {{ $student->user->name }} concluiu o curso de {{ $course->name }} com carga horária
        de {{ $course->hour }} horas.<br>
        Número do registro: {{ $certificateUUID }}
    </div>

    <div class="reason">
        São José do Rio Preto, {{ \Illuminate\Support\Carbon::now('America/Sao_Paulo')->translatedFormat('d F Y') }}
    </div>

    <div class="professor">
        <div class="professor-image">

            @php
                $imageFile = public_path('img/teachers/'. $course->teacher->signature);

                if (is_file($imageFile)){
                    $imgData = base64_encode(file_get_contents($imageFile));
                    $base64_image = 'data:image/jpeg;base64,' . $imgData . $course->teacher->signture;

                    echo '<img src="' . $base64_image .'" alt="" width="200" height="100"/>';
                }

            @endphp
        </div>
    </div>
</div>
{{--</div>--}}
</body>
</html>


