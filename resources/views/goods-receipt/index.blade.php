@extends('layouts.app')
@section('content_title', "Goods Receipt")
@section('content')
<div class="card">
    <form action="{{ route('goods-receipt.store') }}" method="POST" id="form-goods-receipt">
        @csrf
        <div id="data-hidden"></div>
    <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
        <h4 class="card-title">Goods Receipt</h4>
        <div>
            <button type="submit" class="btn btn-primary">Save Goods Receipt</button>
        </div>
    </div>
    <div class="card-body">
        <div class="w-50">
            <div class="form-group my-1">
                <label for="">Distributor</label>
                <input type="text" name="distributor" id="distributor" class="form-control">
                @error('distributor')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group my-1">
                <label for="">Factory Number</label>
                <input type="text" name="factory_number" id="factory_number" class="form-control">
                @error('factory_number')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="d-flex">
            <div class="w-100">
                <label for="">Product</label>
            <select name="select2" id="select2" class="form-control"></select>
            </div>

            <div>
            <label for="">Ready Stock</label>
            <input type="number" id="current_stock" class="form-control mx-1" style="width: 100px" readonly>
            </div>

            <div>
                <label for="">Qty</label>
                <input type="number" id="qty" class="form-control mx-1" style="width: 100px" min="1">
            </div>
            <div>
                <label for="">Purchase Price</label>
                <input type="number" id="purchase_price" class="form-control mx-1" style="width: 300px" min="1">
            </div>
            <div style="padding-top: 32px;">
                <button type="button" class="btn btn-dark" id="btn-add">Add</button>
            </div>
        </div>
    </div>
</form>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table- table-striped table-bordered" id="table-product">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Qty</th>
                    <th>Purchase Price</th>
                    <th>Sub Total (RM)</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection
@push('scripts')

<script>
 $(document).ready(function () {
    let selectedProduct = {};
    $('#select2').select2({
        theme: 'bootstrap',
        placeholder: 'Find Product...',
        ajax: {
            url: "{{ route('get-data.product') }}",
            dataType: 'json',
            delay: 300,
            data:(params) => {
                return {
                    search:params.term
                }
            },
            processResults: (data) => {
                // Store all fetched products in selectedProduct object
                data.forEach(item => {
                    selectedProduct[item.id] = item;
                })

                // Format results for Select2
                return {
                    results:data.map((item) => {
                        return {
                            id: item.id,
                            text: item.product_name
                        }
                    }) 
                }
            },
            cache:true
        },
        minimumInputLength:2
    });

    // Fixed parentheses
    $("#select2").on("change", function (e) {
        let id = $(this).val();
        $.ajax({
            type: "GET",
            url: "{{ route('get-data.check-stock') }}",
            data: {
                id:id
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                $('#current_stock').val(response);
            }
        });



    });
   
    $('#btn-add').on("click", function () {
        const selectedId = $("#select2").val();
        const qty = $("#qty").val();
        const currentStock = $("#current_stock").val();
        const purchasePrice = $("#purchase_price").val();
        const subTotal = parseInt(qty) * parseInt(purchasePrice);
    

        if(!selectedId){
            alert('Please select a product');
            return;
        }
        const product = selectedProduct[selectedId];

        if(isNaN(qty) || qty <=0){
            alert('Quantity must be greater than 0');
            $("#qty").focus();
            return;
        }

        if (isNaN(purchasePrice) || purchasePrice <= 0) {
        alert('Purchase price must be greater than 0');
        $("#purchase_price").focus();
        return;

        }
        
         if(qty > currentStock){
            alert('Number of items is not available')
            return;
        }
        

        
        let exist = false;
        $('#table-product tbody tr').each(function(){
            const rowProduct = $(this).find("td:first").text();

            if(rowProduct === product.product_name){
                let currentQty = parseInt($(this).find("td:eq(1)").text());
                let newQty = currentQty + parseInt(qty);

                $(this).find("td:eq(1)").text(newQty);
                exist = true;
                return false;
            }
        })

        if(!exist){
            const row = `
            <tr data-id="${product.id}">
                <td>${product.product_name }</td>
                <td>${qty}</td>
                <td>${purchasePrice}</td>
                <td>${subTotal}</td>
                <td>
                <button class="btn btn-danger btn-sm btn-remove">
                    <i class="fas fa-trash"></i>
                    </button>
                    </td>
                </tr>
                `
            
              $("#table-product tbody").append(row);  
        }

        $("#select2").val(null).trigger("change");
        $("#qty").val(null);
        $("#purchase_price").val(null);
        $("#current_stock").val(null);

    });

$("#table-product").on("click",".btn-remove", function () {
    $(this).closest('tr').remove();
    
});
$("#form-goods-receipt").on("submit", function () {
    $("#data-hidden").html("");

    $("#table-product tbody tr").each(function(index, row){
        const nameProduct = $(row).find("td:eq(0)").text();
        const qty = $(row).find("td:eq(1)").text();
        const productId = $(row).data("id");
        const purchasePrice = $(row).find("td:eq(2)").text();
        const subTotal = $(row).find("td:eq(3)").text();

        const inputProduct = `<input type="hidden" name="product[${index}][product_name]" value="${nameProduct}"/>`;
        const inputQty = `<input type="hidden" name="product[${index}][qty]" value="${qty}"/>`;
        const inputProductId = `<input type="hidden" name="product[${index}][product_id]" value="${productId}"/>`;
        const inputPurchasePrice = `<input type="hidden" name="product[${index}][purchase_price]" value="${purchasePrice}"/>`;
        const inputSubTotal = `<input type="hidden" name="product[${index}][sub_total]" value="${subTotal}"/>`;

        $("#data-hidden").append(inputProduct).append(inputQty).append(inputProductId).append(inputPurchasePrice).append(inputSubTotal);
    })
    
});

});
</script>
    
@endpush
