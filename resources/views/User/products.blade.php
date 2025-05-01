<div class="latest-products">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Latest Products</h2>
              <a href="products.html">view all products <i class="fa fa-angle-right"></i></a>

              <form method="GET" action="{{ url('search') }}" class="form-inline" style="float:right; padding:10px;">
    @csrf
    <input class="form-control" type="search" name="search" placeholder="search" style="border-style:none;">
    <input type="submit" value="search" class="btn btn-success" style="width: 100px; background-color: #f33f3f; border-style:none
">
</form>

            </div>
          </div>
           
       @foreach ($data as $product)

          <div class="col-md-4">
            <div class="product-item">
              <a href="#"><img src="/productimage/{{$product->image}}" alt=""></a>
              <div class="down-content" style="color:black;">
                <a href="#"><h4>{{$product->title}}</h4></a>
                <h6>{{$product->price}}</h6>

                <p>{{$product->description}}</p>
                <form action="{{url('addcart',$product->id)}}" method="get">
                @csrf
                <input type="number"  value="1" min="1" class="form-control" style="width:100px; margin-bottom:8px;" name="quantity">
                <input type="submit" class="btn btn-primary" value="Add-Cart" style="background-color: #343a40; border-style:none;">
               </form>
              </div>
            </div>
          </div>

          @endforeach
        </div>
      </div>
    </div>