@extends('layouts.app')

@section('content_title', 'Goods Issuance Receipt')
@section('content')

<div class="receipt-page">

    <div class="card mx-auto receipt-card" style="max-width: 360px;">
        <div class="card-body p-3">

            <!-- Receipt container -->
            <div class="receipt-container mx-auto">
                <div class="receipt">

                    <!-- Header -->
                    <div class="text-center mb-2">
                        <h5 class="mb-1">GOODS ISSUANCE</h5>
                        <div>#{{ $data->issuance_number ?? '-' }}</div>
                        <small>{{ $data->transaction_date ?? '-' }}</small>
                    </div>

                    <hr>

                    <!-- Transaction info -->
                    <div class="d-flex justify-content-between">
                        <span>Staff</span>
                        <span>{{ $data->staff_name ?? '-' }}</span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span>Payment</span>
                        <span>RM {{ number_format($data->payment ?? 0, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span>Change</span>
                        <span>RM {{ number_format($data->change ?? 0, 2) }}</span>
                    </div>

                    <hr>

                    <!-- ✅ Items (scrollable if too many) -->
                    <div class="receipt-items">
                        @foreach ($data->items ?? [] as $item)
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    {{ $item->product_name ?? '-' }}
                                    <div class="text-muted">
                                        {{ number_format($item->qty ?? 0) }} x RM {{ number_format($item->price ?? 0, 2) }}
                                    </div>
                                </div>
                                <div>
                                    RM {{ number_format($item->sub_total ?? 0, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <hr>

                    <!-- Total -->
                    <div class="d-flex justify-content-between font-weight-bold total">
                        <span>TOTAL</span>
                        <span>RM {{ number_format($data->total_price ?? 0, 2) }}</span>
                    </div>

                    <hr>

                    <div class="text-center">
                        Thank you for your business!
                    </div>

                    <!-- ✅ Print button bottom left -->
                    <div class="mt-3 no-print">
                        <button onclick="window.print()" class="btn btn-secondary btn-sm">
                            Print Receipt
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection


@section('styles')
<style>
/* ✅ IMPORTANT: Prevent AdminLTE footer/layout breaking */
.content-wrapper {
    min-height: 100vh;
}

/* ✅ Receipt width */
.receipt-page .receipt-card {
    width: 100%;
    max-width: 360px;
}

/* Receipt styling */
.receipt-page .receipt-container {
    width: 100%;
}

.receipt-page .receipt {
    width: 100%;
    font-family: monospace;
    font-size: 13px;
}

/* dashed separator */
.receipt-page .receipt hr {
    border-top: 1px dashed #000;
    margin: 6px 0;
}

/* bold total */
.receipt-page .total {
    font-size: 15px;
    font-weight: bold;
}

/* ✅ FIX: Scroll items when too many (prevents page breaking) */
.receipt-page .receipt-items {
    max-height: 250px;   /* adjust height if needed */
    overflow-y: auto;
    padding-right: 6px;
}

/* ✅ prevent receipt from going under footer */
.receipt-page {
    padding-bottom: 30px;
}

/* Print-only: print just receipt */
@media print {
    body * {
        visibility: hidden !important;
    }

    .receipt-container, .receipt-container * {
        visibility: visible !important;
    }

    .receipt-container {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        display: flex;
        justify-content: center;
        padding: 0;
        margin: 0;
    }

    .receipt {
        width: 80mm;
    }

    .no-print {
        display: none !important;
    }

    /* ✅ Print ALL items (no scroll cut) */
    .receipt-page .receipt-items {
        max-height: none !important;
        overflow: visible !important;
    }
}
</style>
@endsection


@section('scripts')
<script>
// ✅ Removed auto-print (prevents scruffy layout)
</script>
@endsection
