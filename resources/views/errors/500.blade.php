<!DOCTYPE html>
<html>
    <head>
        <title>網站發生錯誤</title>

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
                <div class="title">網站目前連線不穩，請重新整理或聯繫客服人員</div>
            </div>
            <p>Error code (請回報給客服人員)</p>
            <p>{{ $exception->getMessage()  }}</P>
        </div>
    </body>
</html>
