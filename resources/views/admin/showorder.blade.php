<!DOCTYPE html>
<html lang="fr">
<head>
    @include('admin.css')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2C2C2C;
            color: white;
        }
        table {
            font-size: 20px;
            margin: 40px auto;
            margin-top: 6rem;
            width: 80%;
            border-collapse: collapse;
            background-color: #444;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        th, td {
            border: 1px solid #555;
            padding: 15px;
            text-align: center;
        }
        th {
            background-color: #6c7293;
        }
        tr:nth-child(even) {
            background-color: #333;
        }
        tr:hover {
            background-color: #555;
        }
        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-success:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
        .table-title {
            margin: 20px auto;
            font-size: 24px;
            text-align: center;
        }
        .components-table {
            width: 100%;
            border-collapse: collapse;
        }
        .components-table th, .components-table td {
            border: none;
            text-align: left;
            padding: 5px 0;
        }
        .components-table td:first-child {
            padding-right: 10px;
        }
    </style>
</head>
<body>
    @include('admin.navbar')
    @include('admin.sidebar')
    
    <div class="container-fluid page-body-wrapper">
        <div class="container" align="center">
            <!-- Single Products Table -->
            <h2 class="table-title" style="margin-top:8rem;">Produits Simples</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nom du client</th>
                        <th>Numéro de téléphone</th>
                        <th>Adresse</th>
                        <th>Titre du produit</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($singleProducts as $order)
                    <tr>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ $order->product_name }}</td>
                        <td>{{ $order->price }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            <a href="{{ url('updatestatus', $order->id) }}" class="btn btn-success">Livré</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Configurations Table -->
            <h2 class="table-title">Configurations</h2>
            @foreach($configurations as $configId => $configItems)
            <table>
                <thead>
                    <tr>
                        <th>Nom du client</th>
                        <th>Numéro de téléphone</th>
                        <th>Adresse</th>
                        <th>Composants</th>
                        <th>Prix Total</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $configItems->first()->name }}</td>
                        <td>{{ $configItems->first()->phone }}</td>
                        <td>{{ $configItems->first()->address }}</td>
                        <td>
                            <table class="components-table">
                                @foreach($configItems as $item)
                                <tr>
                                    <td>{{ $item->product_name }} (x{{ $item->quantity }})</td>
                                    <td>{{ $item->price }} MAD</td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                        @php
                            $total = $configItems->sum(function($item) {
                                return $item->price * $item->quantity;
                            });
                        @endphp
                        <td>{{ $total }} MAD</td>
                        <td>{{ $configItems->first()->status }}</td>
                        <td>
                            <a href="{{ url('updatestatus', $configItems->first()->id) }}" class="btn btn-success">Livré</a>
                        </td>
                    </tr>
                </tbody>
            </table>
            @endforeach
        </div>
    </div>
    
    @include('admin.script')
</body>
</html>
