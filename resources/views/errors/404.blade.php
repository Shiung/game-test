<!DOCTYPE html>
<html>
    <head>
       
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>404 Error</title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />
        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
       
        <style>
            html, body {
                height: 100%;
            }

            body {
                background-image: url({{ asset('front/dist/img/wizard.jpg') }});
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-position: center;
                background-size: cover;
                margin: 0;
                padding: 0;
                width: 100%;
                color: #383838;
                display: table;
                font-weight: 100;
                font-family: "Microsoft YaHei","微软雅黑","华文细黑","微軟正黑體", "Microsoft JhengHei", serif;
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
                font-size: 72px;
                margin-bottom: 20px;
            }
            .warningtext {
                font-size: 30px;
                margin-bottom: 30px;
            }
        </style>

        
        
        
    </head>
    <body>

        <div class="container">
            <div class="content">
                <img src="{{ asset('dist/img/secondarylogo.png') }}" style="width:300px; margin-left:40px; margin-bottom:15px;"/>
                <div class="title">404 Error</div>
                <div class="warningtext">找不到您指定的页面</div>

            </div>
        </div>

    </body>
    
    

    
    
    
</html>
