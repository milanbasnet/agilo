<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agilo</title>
</head>
<body>
    <p>Hallo {{ $therapist->first_name }} {{ $therapist->last_name }}</p>
    <br>
    <p>Ihr Passwort: {{ $password }}</p>
</body>
</html>