@extends('layouts.app')

@push('styles')
<style>
@keyframes headerColorAnimation {
    0%   { background-color: rgb(70, 130, 180); }
    25%  { background-color: rgb(100, 149, 237); }
    50%  { background-color: rgb(72, 209, 204); }
    75%  { background-color: rgb(123, 104, 238); }
    100% { background-color: rgb(70, 130, 180); }
}

.card-header-custom {
    color: white !important;
    animation: headerColorAnimation 5s infinite alternate;
}

.calendar {
    display: grid;
    grid-template-rows: auto 1fr;
    height: 100%;
}
.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #17a2b8;
    color: white;
    padding: 0.5rem;
    border-radius: 0.25rem 0.25rem 0 0;
}
.calendar-header button {
    background: none;
    border: none;
    color: white;
    font-size: 1rem;
    cursor: pointer;
}
.calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    flex: 1;
    padding: 5px;
    gap: 3px;
    background-color: white;
    text-align: center;
}
.calendar-grid div {
    padding: 8px 0;
    border-radius: 4px;
}
.calendar-grid div.today {
    background-color: #ffc107;
    font-weight: bold;
}
.calendar-grid div.header {
    font-weight: bold;
    background-color: #f0f0f0;
}
</style>
@endpush

@section('content_title', 'Dashboard')
@section('content')

<div class="row">
   <x-dashboard-card type="bg-info" icon="fas fa-users" label="Total Users" value="{{ $totalUsers }}"/>
   <x-dashboard-card type="bg-warning" icon="fas fa-shopping-bag" label="Total Product" value="{{ $totalProduct }}"/>
   <x-dashboard-card type="bg-success" icon="fas fa-cash-register" label="Total Order" value="{{ $totalOrder }}"/>
   <x-dashboard-card type="bg-teal" icon="fas fa-money-check-alt" label="Total Income" value="{{ $totalIncome }}"/>
</div>

<!-- ===============================
     Chart + Calendar (Smaller)
     =============================== -->
<div class="row mt-3">
    <!-- Chart -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header card-header-custom">
                <h4 class="card-title text-bold">Top Product Revenue</h4>
            </div>
            <div class="card-body" style="height: 350px;">
                <canvas id="topProductRevenueChart" style="height: 100%;"></canvas>
            </div>
        </div>
    </div>

    <!-- Calendar -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header card-header-custom">
                <h4 class="card-title text-bold">
                    <i class="far fa-calendar-alt"></i> Calendar
                </h4>
            </div>
            <div class="card-body" style="height:350px;">
                <div class="calendar">
                    <div class="calendar-header">
                        <button id="prevMonth">&laquo;</button>
                        <span id="calendarMonthYear"></span>
                        <button id="nextMonth">&raquo;</button>
                    </div>
                    <div class="calendar-grid" id="calendarGrid">
                        <!-- Calendar cells will be injected here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===============================
     Recent Transactions + Best Seller
     =============================== -->
<div class="row mt-3">
    <div class="col-8">
        <div class="card">
            <div class="card-header card-header-custom">
                <h4 class="card-title text-bold">Recent Transaction</h4>
            </div>
            <div class="card-body">
                <table class="table table-sm table-striped table-bordered">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Transaction Date</th>
                            <th>Transaction Number</th>
                            <th>Total Item</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($latestOrder as $item )
                        <tr>
                            <td>{{ $item->transaction_date }}</td>
                            <td>{{ $item->issuance_number }}</td>
                            <td>{{ $item->items->count() }}<small> Item</small></td>
                            <td>RM {{ number_format($item->total_price) }}</td>
                        </tr> 
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                Showing The Last 5 Transaction Data
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-header card-header-custom">
                <h4 class="card-title text-bold">Best Seller</h4>
            </div>
            <div class="card-body">
                <table class="table table-sm table-striped table-bordered">
                    <thead class="bg-primary text-white">
                    <tr>
                        <th>No</th>
                        <th>Product Name</th>
                        <th>Total Sold</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bestSeller as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->total_sold }}</td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
             <div class="card-footer">
                Showing 5 Best Selling Item This Month
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ---------------- Chart ----------------
    const ctx = document.getElementById('topProductRevenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartProducts),
            datasets: [{
                label: 'Total Revenue (RM)',
                data: @json($chartTotalRevenue),
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'RM ' + parseFloat(context.raw).toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'RM ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // ---------------- Calendar ----------------
    let currentDate = new Date();

    function renderCalendar(date) {
        const month = date.getMonth();
        const year = date.getFullYear();
        const calendarGrid = document.getElementById('calendarGrid');
        const calendarMonthYear = document.getElementById('calendarMonthYear');

        calendarMonthYear.textContent = date.toLocaleString('default', { month: 'long', year: 'numeric' });
        calendarGrid.innerHTML = '';

        // Weekday headers
        const weekdays = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];
        weekdays.forEach(day => {
            const div = document.createElement('div');
            div.textContent = day;
            div.classList.add('header');
            calendarGrid.appendChild(div);
        });

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        // Empty cells before first day
        for (let i = 0; i < firstDay; i++) {
            const div = document.createElement('div');
            calendarGrid.appendChild(div);
        }

        // Days
        for (let day = 1; day <= daysInMonth; day++) {
            const div = document.createElement('div');
            div.textContent = day;
            const today = new Date();
            if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                div.classList.add('today');
            }
            calendarGrid.appendChild(div);
        }
    }

    renderCalendar(currentDate);

    document.getElementById('prevMonth').addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate);
    });
    document.getElementById('nextMonth').addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    });
});
</script>
@endpush
