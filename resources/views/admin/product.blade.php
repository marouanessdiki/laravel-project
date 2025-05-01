<!DOCTYPE html>
<html lang="fr">
  <head>
    @include('admin.css')
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            background-color: #2C2C2C;
            color: white;
        }
        .title {
            color: white; 
            padding-top: 25px; 
            font-size: 32px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .container {
            background-color: #333;
            border-radius: 10px;
            padding: 30px;
            margin-top: 50px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: white;
        }
        .form-group {
            margin-bottom: 20px;
            width: 100%;
        }
        input[type="text"], input[type="number"], input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #6c7293;
            border-radius: 5px;
            background-color: #444;
            color: white;
            margin-top: 5px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s, border-color 0.3s;
        }
        input[type="text"]:hover, input[type="number"]:hover, input[type="file"]:hover {
            background-color: #555;
            border-color: #6c7293;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .alert {
            width: 100%;
            margin-bottom: 20px;
        }
        .alert .close {
            float: right;
            font-size: 20px;
            font-weight: bold;
        }
    </style>
  </head>
  <body>
      @include('admin.sidebar')
      @include('admin.navbar')
      
      <div class="container-fluid page-body-wrapper">
        <div class="container" align="center">
          <h1 class="title">Ajouter un produit</h1>
          
          @if (session()->has('message'))
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">x</button>
              {{ session()->get('message') }}
            </div>
          @endif

          <form action="{{ url('uploadproduct') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label>Titre du produit</label>
              <input type="text" name="title" placeholder="Donner un titre au produit" required>
            </div>
            <div class="form-group">
              <label>Prix</label>
              <input type="number" name="price" placeholder="Donner un prix" required>
            </div>
            <div class="form-group">
              <label>Description</label>
              <input type="text" name="description" placeholder="Description" required>
            </div>
            <div class="form-group">
              <label>Quantité</label>
              <input type="number" name="quantity" placeholder="Quantité de produit" required>
            </div>
            <div class="form-group">
              <label>Catégorie</label>
              <input type="text" name="category" placeholder="Catégorie de produit" required>
            </div>
            <div class="form-group">
              <input type="file" name="file">
            </div>
            <div class="form-group">
              <input class="btn btn-success" type="submit" value="Ajouter">
            </div>
          </form>
        </div>
      </div>
  </body>
</html>
