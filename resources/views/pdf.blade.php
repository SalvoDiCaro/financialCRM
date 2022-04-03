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
                    <strong>Filiale</strong>
                </td>
                <td>
                    {{ $instance->branch }}
                </td>
            </tr>
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
                    {{ $product->name }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Tipologia</strong>
                </td>
                <td>
                    {{ $instance->product_type }}
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Finalità</strong>
                </td>
                <td>
                    {{ $instance->finality }}
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Fondo Consap</strong>
                </td>
                <td>
                    {{ $instance->consap }}
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Durata</strong>
                </td>
                <td>
                    {{ $instance->duration }}
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Costo immobile</strong>
                </td>
                <td>
                    {{"€ " . number_format($instance->property_cost, 2, ",", ".")  }}
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Valore proprietà</strong>
                </td>
                <td>
                    {{"€ " . number_format($instance->property_value, 2, ",", ".")  }}
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Prima erogazione</strong>
                </td>
                <td>
                    {{"€ " . number_format($instance->first_erogation, 2, ",", ".")  }}
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Indirizzo proprietà</strong>
                </td>
                <td>
                    {{ $instance->property_address }}
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Città</strong>
                </td>
                <td>
                    {{ $instance->property_city }}
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Codice postale</strong>
                </td>
                <td>
                    {{ $instance->property_postal_code }}
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Spread</strong>
                </td>
                <td>
                    {{ $instance->spread }}
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Istruttoria</strong>
                </td>
                <td>
                    {{ $instance->inquest }}
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Membri famiglia</strong>
                </td>
                <td>
                    {{ $instance->family_members }}
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Situazione abitativa</strong>
                </td>
                <td>
                    {{ $instance->housing_situation }}
                </td>
            </tr>

        </table>
    </body>

    </html>
