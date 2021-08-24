<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Successful</title>

    <x-favicon/>

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('resources/css/success.css') }}" />
</head>
<body>
<div class="card">
    <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
        <i class="checkmark">✓</i>
    </div>
    <h1>Success</h1>
    <p>Your demo payment is successful.</p>
    <br />
    <a href="{{ url('') }}"><button class="button">Home</button></a>
</div>
</body>
</html>
