@extends('layouts.app')
@section('content_title', 'Goods Receipt Report')
@section('content')

<div class="card mx-auto" style="max-width: 800px;">
    <div class="card-header text-center">
        <h3 class="mb-1">PT POS APP</h3>
        <h5 class="mb-1">Goods Receipt Report</h5>
        <small>{{ $data->receipt_date ?? '-' }}</small>
    </div>

    <div class="card-body">

        <!-- Info Section -->
        <div class="row mb-3">
            <div class="col-md-4 mb-2">
                <strong>Distributor:</strong>
                <div>{{ $data->distributor ?? '-' }}</div>
            </div>
            <div class="col-md-4 mb-2">
                <strong>Factory #:</strong>
                <div>{{ $data->factory_number ?? '-' }}</div>
            </div>
            <div class="col-md-4 mb-2">
                <strong>Receiving Staff:</strong>
                <div>{{ $data->receiving_staff ?? '-' }}</div>
            </div>
        </div>

        <!-- Scrollable Table for Web -->
        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
            <table class="table table-bordered table-striped table-sm">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center" style="width: 40px;">No</th>
                        <th>Product Name</th>
                        <th class="text-center" style="width: 60px;">Qty</th>
                        <th class="text-right" style="width: 100px;">Price</th>
                        <th class="text-right" style="width: 100px;">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->items ?? [] as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td style="word-wrap: break-word;">{{ $item->product_name ?? '-' }}</td>
                        <td class="text-center">{{ number_format($item->qty ?? 0) }}</td>
                        <td class="text-right">RM {{ number_format($item->purchase_price ?? 0,2) }}</td>
                        <td class="text-right">RM {{ number_format($item->sub_total ?? 0,2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-right">Total Purchase</th>
                        <th class="text-right">RM {{ number_format($data->total ?? 0,2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Footer -->
        <div class="text-center mt-4">
            <small>by POS for POS</small>
        </div>

    </div>
</div>

@endsection

@section('styles')
<style>
.card {
    width: 100%;
    max-width: 800px;
    margin-top: 20px;
}

/* Table styling */
.table th, .table td {
    vertical-align: middle;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

/* Header background */
.table thead th {
    background-color: #f8f9fa;
}

/* Bold totals */
.table tfoot th {
    font-weight: bold;
}

/* Print adjustments */
@media print {
    body * {
        visibility: hidden;
    }
    .card, .card * {
        visibility: visible;
    }
    .card {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        max-width: 800px;
        border: none;
        box-shadow: none;
    }

    /* Remove scroll for print, table expands naturally */
    .table-responsive {
        max-height: none !important;
        overflow: visible !important;
    }
}
</style>
@endsection
