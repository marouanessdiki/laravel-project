<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Panier</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.1/dist/tailwind.min.css" rel="stylesheet">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-sixteen.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <style>
        .table-container {
            margin: 20px 0;
        }
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }
        .table th, .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }
        .table tbody + tbody {
            border-top: 2px solid #dee2e6;
        }
    </style>
</head>
<body class="bg-gray-100">

<!-- En-tête -->
<header class="">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ url('redirect') }}"><h2>PC <em>Store</em></h2></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ url('redirect') }}">Accueil
                            <span class="sr-only">(actuel)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.html">Nos Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">PC Configurator</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contactez-nous</a>
                    </li>
                    <li class="nav-item">
                        @if (Route::has('login'))
                            @auth
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('showcart') }}">Panier[{{ $count }}]</a>
                                </li>
                                <x-app-layout></x-app-layout>
                            @else
                                <li><a class="nav-link" href="{{ route('login') }}">Connexion</a></li>
                                @if (Route::has('register'))
                                    <li><a class="nav-link" href="{{ route('register') }}">Inscription</a></li>
                                @endif
                            @endauth
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @if (session()->has('message'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">x</button>
            {{ session()->get('message') }}
        </div>
    @endif
</header>

<div class="container mx-auto mt-10">
    <h1 class="text-4xl font-bold mb-5 text-center">Votre Panier</h1>

    <!-- Section Produits Simples -->
    <div class="bg-white p-5 rounded-lg shadow-lg table-container">
        <h2 class="text-2xl font-bold mb-4">Produits Simples</h2>
        @if($singleProducts->isEmpty())
            <p>Pas de produits simples dans votre panier.</p>
        @else
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Nom du Produit</th>
                        <th scope="col">Quantité</th>
                        <th scope="col">Prix</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($singleProducts as $product)
                        <tr>
                            <td>{{ $product->product_title }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ $product->price }}</td>
                            <td>
                                <a href="{{ url('delete', $product->id) }}" class="btn btn-danger">Supprimer</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Section Configurations -->
    <div class="bg-white p-5 rounded-lg shadow-lg table-container">
        <h2 class="text-2xl font-bold mb-4">Configurations</h2>
        @if($configurations->isEmpty())
            <p>Pas de configurations dans votre panier.</p>
        @else
            @foreach($configurations as $configId => $configItems)
                <table class="table table-bordered table-striped mb-4">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Composant</th>
                            <th scope="col">Quantité</th>
                            <th scope="col">Prix</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($configItems as $component)
                            <tr>
                                <td>{{ $component->product_title }}</td>
                                <td>{{ $component->quantity }}</td>
                                <td>{{ $component->price }}</td>
                                @php $total += $component->price * $component->quantity; @endphp
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" class="font-bold text-right">Total</td>
                            <td class="font-bold">{{ $total }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-right">
                    <a href="{{ url('delete-configuration', $configId) }}" class="btn btn-danger">Supprimer la Configuration</a>
                </div>
            @endforeach
        @endif
    </div>

    <div class="mt-4 text-center">
        <form action="{{ url('order') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Passer la Commande</button>
        </form>
    </div>
</div>

<!-- JavaScript Bootstrap -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Scripts Additionnels -->
<script src="assets/js/custom.js"></script>
<script src="assets/js/owl.js"></script>
<script src="assets/js/slick.js"></script>
<script src="assets/js/isotope.js"></script>
<script src="assets/js/accordions.js"></script>

<script language="text/Javascript">
    cleared[0] = cleared[1] = cleared[2] = 0; // définir un drapeau effacé pour chaque champ
    function clearField(t) {                   // déclarer le tableau en dehors de la fonction le rend statique et global
        if (!cleared[t.id]) {                  // la fonction le rend statique et global
            cleared[t.id] = 1;  // vous pourriez utiliser true et false, mais c'est plus de frappe
            t.value = '';         // avec plus de risques de fautes de frappe
            t.style.color = '#fff';
        }
    }
</script>

</body>
</html>
