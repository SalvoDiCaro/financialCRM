<! DOCTYPE html>
    <html>

    <head>
        <title>Riepilogo richiesta</title>
        <style>
            td{
                border-bottom: 1px solid black;
            }
        </style>
    </head>

    <body>
        <h2>{{ $title }}</h2>
        <img height="50" src="{{ 'storage/image/dicaro.png' }}">
        <table>
            @foreach ($partecipations as $partecipation)
            <tr>
                <td>
                    <strong>Partecipanti</strong>
                </td>
                <td>
                    {{ $partecipation->name }} {{ $partecipation->surname }} - {{$partecipation->typology}} - tel. {{$partecipation->phone}}
                </td>
            </tr>
            @endforeach

            <tr>
                <td>
                    <strong>Provenienza</strong>
                </td>
                <td>
                    {{ $channel }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Prodotto</strong>
                </td>
                <td>
                    {{ $product }}
                </td>
            </tr>


        </table>
    </body>

    </html>
