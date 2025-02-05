@include('inc.navbar')
<div class="main-container">
  <div class="container">
    <h2>Product Form</h2>
    <form action="{{ route('storeProducts') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label for="sku">Product SKU:</label>
        <input type="number" class="form-control" id="sku" name="productSKU" required>
      </div>
      <div class="form-group">
        <label for="name">Product Name:</label>
        <input type="text" class="form-control" id="name" name="productName" required>
      </div>
      <div class="form-group">
        <label for="category">Product Category:</label>
        <select class="form-control" id="category" name="category_id" required>
          <option>Select a category</option>
          @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="price">Product Price:</label>
        <input type="number" class="form-control" id="price" name="productPrice" required>
      </div>
      <div class="form-group">
        <label for="weight">Product Weight:</label>
        <input type="number" class="form-control" id="weight" name="productWeight" required>
      </div>
      <div class="form-group">
        <label for="cart-desc">Product Cart Description:</label>
        <textarea class="form-control" id="cart-desc" name="productCartDesc" rows="3" required></textarea>
      </div>
      <div class="form-group">
        <label for="long-desc">Product Long Description:</label>
        <textarea class="form-control" id="long-desc" name="productLongDesc" rows="5" required></textarea>
      </div>
      <div class="form-group">
        <label for="image">Product Image:</label>
        <input type="file" class="form-control-file" id="image" name="productImage" required>
      </div>
      <div class="form-group">
        <label for="stock">Product Stock:</label>
        <input type="number" class="form-control" id="stock" name="productStock" required>
      </div>
      <button type="submit" class="btn btn-primary">Save</button>
      <button type="button" class="btn btn-secondary" onclick="clearForm()">Clear All</button>
    </form>
  </div>
  <script>
    function clearForm() {
      document.getElementById("sku").value = "";
      document.getElementById("name").value = "";
      document.getElementById("price").value = "";
      document.getElementById("weight").value = "";
      document.getElementById("cart-desc").value = "";
      document.getElementById("long-desc").value = "";
      document.getElementById("image").value = "";
      document.getElementById("stock").value = "";
    }
  </script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</div>
