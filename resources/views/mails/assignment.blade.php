<!DOCTYPE html>
<html>
<head>
    <title>Assegnazione lead</title>
</head>
<body>
    <h1>Nome: {{ $lead['name'] }}</h1>
    <h1>Cognome: {{ $lead['surname'] }}</h1>
    <h1>Email: {{ $lead['email'] }}</h1>
    <h1>Telefono: {{ $lead['phone'] }}</h1>
    <h1>Canale: {{ $lead['channel'] }}</h1>
    <h1>Stato: {{ $lead['current_state'] }}</h1>
</body>
</html>
