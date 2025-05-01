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
        .container {
            margin-top: 50px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background-color: #444;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        table th, table td {
            padding: 20px;
            text-align: center;
            border: 1px solid #555;
        }
        table th {
            background-color: #6c7293;
        }
        table tr:nth-child(even) {
            background-color: #333;
        }
        table tr:hover {
            background-color: #555;
        }
        img {
            height: 200px;
            width: 100px;
            object-fit: cover;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            background-color: #a71d2a;
            transform: scale(1.05);
        }
        .alert {
            background-color: #28a745;
            color: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            position: relative;
        }
        .alert .close {
            position: absolute;
            top: 10px;
            right: 10px;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
  </head>
  <body>
      @include('admin.sidebar')
      @include('admin.navbar')
      
      <div class="container-fluid page-body-wrapper">
        <div class="container" align="center">
          @if (session()->has('message'))
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">x</button>
              {{ session()->get('message') }}
            </div>
          @endif
          <table>
            <thead>
              <tr>
                <th>Titre</th>
                <th>Description</th>
                <th>Quantité</th>
                <th>Prix</th>
                <th>Images</th>
                <th>Mettre à jour</th>
                <th>Supprimer</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $product)
              <tr>
                <td>{{ $product->title }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->price }}</td>
                <td>
                  <img src="/productimage/{{ $product->image }}" alt="Image du produit">
                </td>
                <td>
                  <a class="btn btn-primary" href="{{ url('updateview', $product->id) }}">Mettre à jour</a>
                </td>
                <td>
                  <a class="btn btn-danger" href="{{ url('deleteproduct', $product->id) }}">Supprimer</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      @include('admin.script')
  </body>
</html>
