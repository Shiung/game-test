<!DOCTYPE html>
<html>
    <head>
        <title>{{ env('COMPANY_NAME') }}-網站維修中</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 60px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <center>
                <img src="{{ asset('front/img/logo.png') }}" height="50px">
                </center>
                <div class="title">網站目前維護中，請稍候再使用。</div>
            </div>
        </div>
    </body>
</html>
