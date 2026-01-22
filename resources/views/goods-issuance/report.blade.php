@extends('layouts.app')
@section('content_title', 'Goods Issuance Report')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Goods Issuance Report (Transaction)</h4>
    </div>
    <div class="card-body">
        <table class="table table-sm table-striped table-bordered" id="table2">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Issuance Number</th>
                    <th>Transaction Date</th>
                    <th>Total Price</th>
                    <th>Total Payment</th>
                    <th>Change</th>
                    <th>Staff</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $item )
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->issuance_number }}</td>
                    <td>{{ $item->transaction_date }}</td>
                    <td>RM {{ number_format($item->total_price) }}</td>
                    <td>RM {{ number_format($item->payment) }}</td>
                    <td>RM {{ number_format($item->change) }}</td>
                    <td>{{ ucwords($item->staff_name) }}</td>
                    <td>
                        <a href="{{ route('report.goods-issuance.detail-report',$item->issuance_number) }}">
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