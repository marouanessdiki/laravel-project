<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.1/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .invoice {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }
        .invoice-box {
            width: 100%;
            overflow: hidden;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td{
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        .download-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .download-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="invoice-box">
            <table cellpadding="0" cellspacing="0">
                <tr class="top">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td class="title">
                                    <h2>Votre Facture</h2>
                                </td>
                                
                                <td>
                                    Facture #: 123<br>
                                    Créée: {{ date('d-m-Y') }}<br>
                                    Due: {{ date('d-m-Y', strtotime('+30 days')) }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
                <tr class="information">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td>
                                    {{ $user->name }}<br>
                                    {{ $user->address }}<br>
                                    {{ $user->phone }}
                                </td>
                                
                                <td>
                                    Nom de la Société<br>
                                    email@example.com
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
                <!-- Section des Produits Simples -->
                <tr class="heading">
                    <td>Produit Simple</td>
                    <td>Prix</td>
                </tr>
                
                @php
                    $totalSingle = 0;
                @endphp
                @foreach($singleProducts as $product)
                    <tr class="item">
                        <td>{{ $product->product_name }} (x{{ $product->quantity }})</td>
                        <td>{{ $product->price }} MAD</td>
                    </tr>
                    @php
                        $totalSingle += $product->price * $product->quantity;
                    @endphp
                @endforeach
                
                <tr class="total">
                    <td>Total Produits Simples</td>
                    <td>{{ $totalSingle }} MAD</td>
                </tr>

                <!-- Section des Configurations -->
                @foreach($configurations as $configId => $configItems)
                    <tr class="heading">
                        <td>Configuration #{{ $configId }}</td>
                        <td></td>
                    </tr>
                    @php
                        $totalConfig = 0;
                    @endphp
                    @foreach($configItems as $item)
                        <tr class="item">
                            <td>{{ $item->product_name }} (x{{ $item->quantity }})</td>
                            <td>{{ $item->price }} MAD</td>
                        </tr>
                        @php
                            $totalConfig += $item->price * $item->quantity;
                        @endphp
                    @endforeach
                    <tr class="total">
                        <td>Total Configuration #{{ $configId }}</td>
                        <td>{{ $totalConfig }} MAD</td>
                    </tr>
                @endforeach

                <!-- Total général -->
                <tr class="total">
                    <td>Total Général</td>
                    <td>{{ $totalSingle + $totalConfig }} MAD</td>
                </tr>
            </table>
        </div>
    </div>

    <a href="{{ url('download-invoice') }}" class="download-btn">Télécharger la Facture</a>
</body>
</html>
