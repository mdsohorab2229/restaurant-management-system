<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Document</title>
    <style>
        @import  url(https://fonts.googleapis.com/css?family=Righteous);
        *{margin:0;padding:0}
        body{font-family:Righteous,cursive;background-color:#f0f0f0}
        .page_wrapper{width:65%;margin:10% auto;transition:.5s;text-align:center}
        .page_wrapper h2 {
            font-size: 40px;
            text-transform: uppercase;
            color: #f53d03;
        }

        .page_wrapper h1 {
            text-transform:  uppercase;
            font-size: 160px;
            color: #505050;
            line-height: 130px;
        }

        .page_wrapper h3 {
            margin: 30px 0px;
            font-size: 40px;
            color: #656565;
        }

        .page_wrapper p {
            font-size: 20px;
            color: #656565;
            margin-top: 34px;
        }

        .page_wrapper p a {
            text-decoration: none;
            color: #e45600;
        }
        .page_wrapper p a:hover {
            color: #17e400;
        }
    </style>
</head>
<body>
<div class="page_wrapper">
    {{--// You're not authorized to view this page.--}}
    <h2>Unauthorized</h2>
    <h1>Error</h1>
    <h3>You're not authorized to view this page</h3>
    <p><a href="{{ url()->previous() }}">Back Previous</a></p>
</div>
</body>
</html>
