@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-4 gap-4 mb-8">
        <div class="bg-yellow-100 p-6 rounded-lg shadow">
            <h3 class="text-blue-500 text-sm">Pending</h3>
            <p class="text-4xl font-bold">{{ $countWorkOrdersByPending }}</p>
        </div>

        <div class="bg-blue-100 p-6 rounded-lg shadow">
            <h3 class="text-blue-500 text-sm">In Progress</h3>
            <p class="text-4xl font-bold">{{ $countWorkOrdersByProgress }}</p>
        </div>

        <div class="bg-green-100 p-6 rounded-lg shadow">
            <h3 class="text-blue-500 text-sm">Completed</h3>
            <p class="text-4xl font-bold">{{ $countWorkOrdersByCompleted }}</p>
        </div>

        <div class="bg-red-100 p-6 rounded-lg shadow">
            <h3 class="text-blue-500 text-sm">Canceled</h3>
            <p class="text-4xl font-bold">{{ $countWorkOrdersByCanceled }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4">
        <div class="col-span-2 bg-blue-100 p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4"> Work Order Chart</h2>
            <div class="w-full">
                <canvas id="workOrderChart"></canvas>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const ctx = document.getElementById('workOrderChart');
                        const data = {
                            pending: {{ $countWorkOrdersByPending }},
                            progress: {{ $countWorkOrdersByProgress }},
                            completed: {{ $countWorkOrdersByCompleted }},
                            canceled: {{ $countWorkOrdersByCanceled }}
                        };

                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Pending', 'In Progress', 'Completed', 'Cancelled'],
                                datasets: [{
                                    label: 'Jumlah Work Order',
                                    data: [data.pending, data.progress, data.completed, data.canceled],
                                    backgroundColor: [
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(255, 99, 132, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(255, 99, 132, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                },
                                plugins: {
                                    legend: {
                                        position: 'top',
                                        align: 'start',
                                        display: false
                                    }
                                }
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
@endsection