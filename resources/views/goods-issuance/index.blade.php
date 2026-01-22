@extends('layouts.app')
@section('content_title', "Goods Issuance / Transaction")
@section('content')
<div class="card">
    <x-alert :errors="$errors"/>
    <form action="{{ route('goods-issuance.store') }}" method="POST" id="form-goods-issuance">
        @csrf
        <div id="data-hidden"></div>
    <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
        <h4 class="card-title">Goods Issuance / Transaction</h4>
    </div>
    <div class="card-body">
        
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
                <label for="">Price (RM)</label>
                <input type="number" id="sale_price" class="form-control mx-1" style="width: 100px" readonly>
                </div>

            <div>
                <label for="">Qty</label>
                <input type="number" id="qty" class="form-control mx-1" style="width: 100px" min="1">
            </div>
            <div style="padding-top: 32px;">
                <button type="button" class="btn btn-dark" id="btn-add">Add</button>
            </div>
        </div>
    </div>

</div>
        <div class="row">
            <div class="col-9">
                <div class="card">
                    <div class="card-body">
                    <table class="table table-sm table-striped table-bordered" id="table-product">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Sub Total (RM)</th>
                            <th>Option</th>
                        </tr>
                </thead>
            <tbody></tbody>
               </table>
                    </div>
                </div>
            </div>
            <div class="col-3">
               <div class="card">
                <div class="card-body">
                     <div>
                    <label for="">Total</label>
                    <input type="number" class="form-control" id="total" readonly>
                </div>
                <div>
                    <label for="">Change</label>
                    <input type="number" class="form-control" id="change" min="1" readonly>
                </div>
                <div>
                    <label for="">Total Payment</label>
                    <input type="number" class="form-control" name="payment" id="payment" min="1">
                </div>
                    <div>
                        <button type="submit" class="btn btn-primary w-100 mt-2">Save Transaction</button>
                    </div>
                </div>
             </div>
        </div>
    </form>
</div>
@endsection
@push('scripts')

<script>
 $(document).ready(function () {
    let selectedProduct = {};

    function totalCount(){
        let total = 0;

        $('#table-product tbody tr').each(function(){
            const subTotal = parseInt($(this).find('td:eq(3)').text()) || 0;
             total += subTotal;
        });

        $("#total").val(total);
    }


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
            data: {id:id},
            dataType: "json",
            success: function (response) {
                console.log(response);
                $('#current_stock').val(response);
            }
        });
        $.ajax({
            type: "GET",
            url: "{{ route('get-data.check-price') }}",
            data: {id:id},
            dataType: "json",
            success: function (response) {
                console.log(response);
                $('#sale_price').val(response);
            }
        });



    });
   
    $('#btn-add').on("click", function () {
        const selectedId = $("#select2").val();
        const qty = parseInt($("#qty").val());
        const currentStock = $("#current_stock").val();
        const salePrice = $("#sale_price").val();
        const subTotal = parseInt(qty) * parseInt(salePrice);

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
                <td>${salePrice}</td>
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
        $("#current_stock").val(null);
        $("#sale_price").val(null);
        totalCount();

    });

$("#table-product").on("click",".btn-remove", function () {
    $(this).closest('tr').remove();
    totalCount();
    
});
$("#form-goods-issuance").on("submit", function () {
    $("#data-hidden").html("");

    $("#table-product tbody tr").each(function(index, row){
        const nameProduct = $(row).find("td:eq(0)").text();
        const qty = $(row).find("td:eq(1)").text();
        const productId = $(row).data("id");
        const salePrice = $(row).find("td:eq(2)").text();
        const subTotal = $(row).find("td:eq(3)").text();

        const inputProduct = `<input type="hidden" name="product[${index}][product_name]" value="${nameProduct}"/>`;
        const inputQty = `<input type="hidden" name="product[${index}][qty]" value="${qty}"/>`;
        const inputProductId = `<input type="hidden" name="product[${index}][product_id]" value="${productId}"/>`;
          const inputSalePrice = `<input type="hidden" name="product[${index}][sale_price]" value="${salePrice}"/>`;
        const inputSubTotal = `<input type="hidden" name="product[${index}][sub_total]" value="${subTotal}"/>`;

        $("#data-hidden").append(inputProduct).append(inputQty).append(inputProductId).append(inputSalePrice).append(inputSubTotal);
    })
    
});

    $("#payment").on("input", function() {
        const total     = parseInt($("#total").val()) || 0;
        const payment   = parseInt($(this).val()) || 0;
        const change    = payment - total;

        $("#change").val(change);
    });

});
</script>
    
@endpush
