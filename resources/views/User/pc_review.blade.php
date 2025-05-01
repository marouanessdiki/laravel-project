<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Your Configuration</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.1/dist/tailwind.min.css" rel="stylesheet">
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
    <style>
        .title{
            margin-top:7rem;
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
                    
                </div>
            </div>
        </nav>
    </header>
    <div class="container mx-auto mt-10">
        <h1 class="text-4xl font-bold mb-5 title" align="center">Revoyez votre configuration</h1>
        <div id="review" class="bg-white p-5 rounded-lg shadow-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($selectedComponents as $component)
                    <div class="border rounded p-4">
                        <img src="/productimage/{{ $component->product->image }}" style="width:150px;height:150px" alt="{{ $component->product->name }}" class="w-full h-32 object-cover mb-2">
                        <h3 class="text-lg font-semibold">{{ $component->product->name }}</h3>
                        <p>{{ $component->product->description }}</p>
                        <p class="text-right text-green-500 font-bold">{{ $component->product->price }} MAD</p>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 text-center">
                <form action="{{ url('/submit-configuration') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-500 text-white p-2 rounded">Valider la configuration</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
