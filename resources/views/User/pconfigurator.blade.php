<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC Configurator</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
    
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/templatemo-sixteen.css') }}">
    
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/owl.css') }}">
    
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- Axios JS -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <!-- Additional Styles -->
    <style>
        .border-red-500 {
            border-color: #f33f3f !important;
            border-width: 2px !important;
        }
        .bg-blue-500 {
            background-color: red;
            border-style:none;
            cursor:pointer;

        }
        .bg-blue-500:hover {
            background-color: #f33f3f;
           

        }
        .product-item:hover {
            cursor: pointer;
        }
        .text-center{
             margin-top: 7rem;
        }
    </style>
</head>
<body>
    <header class="background-header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="/"><h2>PC  <em>Configurator</em></h2></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="/">Quitter</a></li>
                        
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    
    <div class="container mx-auto mt-10">
        <h1 class="text-4xl font-bold mb-5 text-center">Composez le PC gamer de vos rêves !</h1>
        <div id="configurator" class="bg-white p-5 rounded-lg shadow-lg">
            <h2 class="text-2xl mb-4">Step {{ $step }}: Sélectionner votre {{ $category }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($products as $product)
                    <div class="border rounded p-4 cursor-pointer product-item" onclick="selectProduct(event, {{ $product->id }}, '{{ $product->name }}', {{ $product->price }})">
                        <img style="width:150px; height:150px" src="/productimage/{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-32 object-cover mb-2">
                        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                        <p>{{ $product->description }}</p>
                        <p class="text-right text-red-500 font-bold">{{ $product->price }} MAD</p>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 text-center">
                <button id="next-button" class="bg-blue-500  cursor-pointer text-white p-2 rounded" disabled onclick="goToNextStep()">Next</button>
            </div>
        </div>
    </div>

    <script>
        let selectedProduct = null;

        function selectProduct(event, id, name, price) {
            selectedProduct = { id, name, price };
            document.getElementById('next-button').disabled = false;
            // Highlight the selected product
            document.querySelectorAll('.product-item').forEach(el => el.classList.remove('border-red-500'));
            event.currentTarget.classList.add('border-red-500');
        }

        function goToNextStep() {
            if (selectedProduct) {
                axios.post('/save-config', {
                    step: {{ $step }},
                    product: selectedProduct
                }).then(response => {
                    const nextStep = {{ $step }} + 1;
                    window.location.href = `/pconfigurator/${nextStep}`;
                }).catch(error => {
                    console.error('Error saving configuration:', error);
                });
            }
        }
    </script>
</body>
</html>
