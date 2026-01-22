<div>
    <button type="button" class="btn {{ $id ? 'btn-warning' : 'btn-primary' }}" data-toggle="modal" data-target="#formProduct{{ $id ?? '' }}">
            @if ($id)
              <i class="fas fa-edit"></i>  
              @else
              New Product
            @endif
        </button>
        <div class="modal fade" id="formProduct{{ $id ?? '' }}">
        <form action="{{ route('master-data.product.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $id }}">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{ $id ? 'Form Edit Product' : 'Form New Product' }}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group my-1">
              <label for="">Product Name</label>
              <input type="text" name="product_name" id="product_name" class="form-control" value="{{ $id ? $product_name : old('product_name') }}">
            </div>
            <div class="form-group my-1">
                <label for="">Product Category</label>
                <select name="category_id" id="category_id" class="form-control">
                    <option value="">Choose category</option>
                    @foreach ($category as $item )
                        <option value="{{ $item->id }}"
                         {{ old('category_id' , $category_id)==$item->id ? 'selected' : ''}}>{{ $item->nama_category }}</option>
                    @endforeach
                </select>
                </div>
                <div class="form-group my-1">
                <label for="">Sale Price</label>
                <input type="number" name="sale_price" id="sale_price" class="form-control" value="{{ old('sale_price',$sale_price)}}">
            </div>
                <div class="form-group my-1">
                <label for="">Original Purchase Price</label>
                <input type="number" name="original_purchase_price" id="original_purchase_price" class="form-control" value="{{ $id ? $original_purchase_price : old('original_purchase_price')}}">
                </div>
        
            <div class="form-group my-1">
                <label for="">Ready Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" value="{{ $id ? $stock : old('stock')}}">
        </div>
                 <div class="form-group my-1">
                <label for="">Minimum Stock</label>
                <input type="number" name="minimum_stock" id="minimum_stock" class="form-control" value="{{ $id ? $minimum_stock : old('minimum_stock')}}">
        </div>
            <div class="form-group my-1 d-flex flex-column">
                <div class="d-flex align-items-center">
                <label for="" class="mr-4">Active Product ?</label>
                <input type="checkbox" name="is_active" id="is_active" value="1"
                    {{ old('is_active', $id ? $is_active :false) ? 
                    'checked' : '' }}
                >
            </div>
            <small class="text-secondary -mt-2">If active, the product will be displayed on the cashier page.</small>
            </div>
        </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        </form>
      </div>
      <!-- /.modal -->
</div>