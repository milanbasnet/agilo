<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agilo</title>
</head>
<body>
    <p>Hello {{ $therapist->first_name }} {{ $therapist->last_name }}</p>
    <br>
    <p>Your password: {{ $password }}</p>
</body>
</html>