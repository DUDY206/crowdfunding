<html>
<head>
    <style>
        /* @page {
            margin-top: 3cm;
            margin-bottom: 4cm;
        }

        @font-face {
            font-family: sans-serif;
        }

        header {
            position: fixed;
            top: -3cm;
            left: -1.2cm;
            right: -1.2cm;
            height: 115px;
            width: 100%;
            background: url('{{ asset('/images/pdf/header.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0cm 0cm;
        }

        footer {
            position: fixed;
            bottom: -4.5cm;
            left: -1.2cm;
            right: -1.2cm;
            height: 90px;
            width: 100%;
            background: url('{{ asset('/images/pdf/footer.png') }}');
            background-size: contain;
            background-repeat: no-repeat;
            margin: 0cm 0cm;
        }

        .flyleaf {
            page-break-after: always;
        } */


        @page {
            margin-top: 3cm;
            margin-left: 2cm;
            margin-right: 2cm;
        }

        body {
            font-family: 'myFont';
            font-size: 14px;
        }

        header {
            position: fixed;
            top: -3cm;
            left: -1.2cm;
            right: -1.2cm;
            height: 115px;
            width: 100%;
            background: url('{{ public_path('images/pdf/header1.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0cm 0cm;
        }
    </style>
</head>
<body>
    <div class="flyleaf"></div>

    <header></header>

    <div class="main">
        {!! $contract !!}
    </div>

    {{-- <footer></footer> --}}
</body>
</html>
