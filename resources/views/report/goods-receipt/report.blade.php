@extends('layouts.app')
@section('content_title', 'Goods Receipt Report')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Goods Receipt Report</h4>
    </div>

    <div class="card-body">
        <table class="table table-sm table-striped table-bordered" id="table2">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Receipt Number</th>
                    <th>Factory Number</th>
                    <th>Distributor</th>
                    <th>Date Of Entry</th>
                    <th>Receiving Staff</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($goodsReceipt as $index=> $item )
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->receipt_number }}</td>
                    <td>{{ $item->factory_number }}</td>
                    <td>{{ $item->distributor }}</td>
                    <td>{{ $item->receipt_date }}</td>
                    <td>{{ $item->receiving_staff }}</td>
                    <td>
                        <a href="{{ route('report.goods-receipt.detail-report', $item->receipt_number) }}" class="text-primary">
                            Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
