<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<style>
    .container {
        text-align: center;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .notice {
        margin-top: -15px;
        font-size: 20px;
        font-weight: 600;
        text-align: center;
        color: green;
    }
</style>
<div class="container">
    <img src="/img/success.png" alt="" srcset="">
    <p class="notice">{{$msg}}</p>
</div>

</body>
</html>
