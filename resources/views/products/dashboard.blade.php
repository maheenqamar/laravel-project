@include('inc.navbar')
<div class="main-container">
    <h1>This is our product dashboard!</h1>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <a class="btn btn-success" href="{{ route('createProducts') }}">Create Products</a>
                </div>
                <form action="{{ route('searchProducts') }}" method="GET" class="d-flex">
                    <div class="input-group">
                        <input style="width: 255px" type="text" name="search" class="form-control" placeholder="Search by SKU or Product Name">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    <a href="{{ route('refreshProducts') }}" type="button" class="btn btn-success">Refresh</a>
                    </div>
                </form>
            </div>
        </div>
        </div>
            @if (session('success'))
                @include('partials._success')
            @elseif (session ('error'))
                @include('partials._error')
            @endif
            @if ($products->isEmpty())
            <br>
            <p style="font-weight: bold; font-size: 20px; text-align: center;" class="text-danger">You have no products to display!</p>
            @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product SKU</th>
                    <th>Product Name</th>
                    <th>Product Category</th>
                    <th>Product Price(Rs)</th>
                    <th>Product Weight(Gram)</th>
                    <th>Product Cart Desc</th>
                    <th class="text-center">Product Long Desc</th>
                    <th>Product Image</th>
                    <th>Product Stock</th>
                    <th class="text-center" width="280px">Action</th>
                </tr>
            </thead>
            @foreach ($products as $product)
                <tr>
                    <td>{{$product->productSKU}}</td>
                    <td>{{$product->productName}}</td>
                    <td>
                        @foreach ($product->categories as $category)
                            <span>{{ $category->category_name }}</span>
                        @endforeach
                    </td>
                    <td>{{$product->productPrice}}</td>
                    <td>{{$product->productWeight}}</td>
                    <td>{{$product->productCartDesc}}</td>
                    <td>{{$product->productLongDesc}}</td>
                    <td class="text-center">
                        <img src="{{ asset('uploads/' . $product->productImage) }}" alt="Product Image" width="50">
                    </td>
                    <td>{{$product->productStock}}</td>
                    <td>
                      <div class="justify-content-center" style="display: flex; gap: 10px;">
                          <a href="{{ route('showProducts',$product->id) }}" type="button" class="btn btn-warning">Details</a>
                          <a href="{{ route('editProducts',$product->id) }}" type="button" class="btn btn-primary">Edit</a>
                          <a href="{{ route('deleteProducts',$product->id) }}" type="button" class="btn btn-danger">Archive</a>
                      </div>
                   </td>
                </tr>
            @endforeach
       </table>
       <centre>
       <div class="mt-4 d-flex justify-content-center">
            {{ $products->links('vendor.pagination.bootstrap') }}
            </div>
        </centre>
  </div>
  @endif