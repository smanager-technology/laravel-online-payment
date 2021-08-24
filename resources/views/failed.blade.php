<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Payment Failed</title>

    <x-favicon/>

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'>
    <link rel="stylesheet" href="{{ asset('resources/css/fail.css') }}" />
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="message-box _success _failed">
                <i class="fa fa-times-circle" aria-hidden="true"></i>
                <h2>Your Demo Payment Failed</h2>
                <br />
                <a href="{{ url('') }}"><button class="button">Home</button></a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
