@extends('layouts.app')
@section('content_title', 'Product Data')
@section('content')

<div class="card">
    <div class="p-2 d-flex justify-content-between border">
        <h4 class="card-title m-2">Product Data</h4>
        <!-- Add User button -->
        <x-product.form-product button-label="New Product"/>
    </div>
    <div class="card-body">
        <x-alert :errors="$errors" type="warning"/>
       <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered" id="table2" style="width: 100%;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>SKU</th>
                    <th>Product Name</th>
                    <th>Sale Price</th>
                    <th>Purchase Price</th>
                    <th>Stock</th>
                    <th>Active</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $index => $product )
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>RM{{ number_format($product->sale_price) }}</td>
                    <td>RM{{ number_format($product->original_purchase_price) }}</td>
                    <td>{{ number_format($product->stock) }}</td>
                    <td> <span class="badge badge-pill {{ $product->is_active ? 'badge-success' : 'badge-danger'}}">
                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span></td>
                    <td>

                    <div class="d-flex align-items-center">
                        <x-product.form-product :id="$product->id" />
                            <a href="{{ route('master-data.product.destroy', $product->id) }}" data-confirm-delete="true"
                                 class="btn btn-danger mx-1">
                                <i class="fas fa-trash"></i>
                            </a>
                    </div>
                    </td>
                </tr>
                    
                @endforeach
            </tbody>
        </table>
        </div>
        </div>
    </div>
</div>

@endsection