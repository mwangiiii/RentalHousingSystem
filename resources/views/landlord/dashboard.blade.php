@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Landlord Dashboard') }}
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-2xl font-bold mb-4">Dashboard Overview</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-100 p-4 rounded-lg">
                        <h4 class="text-xl font-semibold">Properties</h4>
                        <p class="text-lg">{{ $properties->count() }}</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-lg">
                        <h4 class="text-xl font-semibold">Tenants</h4>
                        <p class="text-lg">{{ $tenants->count() }}</p>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-lg">
                        <h4 class="text-xl font-semibold">Payments</h4>
                        <p class="text-lg">{{ $payments->count() }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Occupancy Rate Chart -->
                    <div class="bg-red-100 p-3 mt-4 rounded-lg">
                        <h4 class="text-xl font-semibold">Occupancy Rate</h4>
                        <div class="py-6" id="occupancy-chart"></div>
                    </div>

                    <!-- Maintenance Chart -->
                    <div class="bg-blue-200 p-3 mt-4 rounded-lg">
                        <h4 class="text-xl font-semibold">Maintenance Tickets</h4>
                        <div class="py-6" id="maintenance-chart"></div>
                    </div>

                    <!-- Churn Rate-->
                    <div class="bg-red-200 p-3 mt-4 rounded-lg">
                        <h4 class="text-xl font-semibold">Churn Rate</h4>
                        <div class="py-6" id="churn-chart"></div>
                     </div>

                    <!-- Leases Expiring  Chart
                    <div class="py-6" id="bar-chart"></div> -->

                    <!-- Rent Collected Graph -->
                    <div class="bg-green-200 p-3 mt-4 rounded-lg">
                        <h4 class="text-xl font-semibold">Rent Collected</h4>
                        <div class="py-6" id="line-graph"></div>
                    </div>
                    <!-- Outstanding Payment Graph -->
                    <div class="bg-blue-200 p-3 mt-4 rounded-lg">
                        <h4 class="text-xl font-semibold">Outstanding Balances</h4>
                        <div class="py-6" id="column-chart"></div>
                    </div>
                    <!-- Payment History Graph -->
                    <div class="bg-blue-200 p-3 mt-4 rounded-lg">
                        <h4 class="text-xl font-semibold">Payments History</h4>
                        <div class="py-6" id="area-graph"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Script of the occupany rate graph
    const getOccupancyChartOptions = (occupied, available) => {
        return {
            series: [occupied, available],
            colors: ["#3498db", "#e74c3c"],
            chart: {
                height: 420,
                width: "100%",
                type: "pie",
            },
            stroke: {
                colors: ["white"],
                lineCap: "",
            },
            plotOptions: {
                pie: {
                    labels: {
                        show: true,
                    },
                    size: "100%",
                    dataLabels: {
                        offset: -25
                    }
                },
            },
            labels: ["Occupied", "Available"],
            dataLabels: {
                enabled: true,
                style: {
                    fontFamily: "Inter, sans-serif",
                },
            },
            legend: {
                position: "bottom",
                fontFamily: "Inter, sans-serif",
            },
        }
    }
    const occupiedRooms = <?php echo json_encode($occupiedRooms) ?>;
    const availableRooms = <?php echo json_encode($availableRooms) ?>;

    if (document.getElementById("occupancy-chart") && typeof ApexCharts !== 'undefined') {
        const occupancychart = new ApexCharts(document.getElementById("occupancy-chart"), getOccupancyChartOptions(occupiedRooms,availableRooms));
        occupancychart.render();
    }
    //  Script of the maintenance pie chart
    const getMaintenanceRequestsChartOptions = (open, completed) => {
        return {
            series: [open, completed],
            colors: ["#FF5722", "#4CAF50"],
            chart: {
                height: 420,
                width: "100%",
                type: "pie",
            },
            stroke: {
                colors: ["white"],
                lineCap: "",
            },
            plotOptions: {
                pie: {
                    labels: {
                        show: true,
                    },
                    size: "100%",
                    dataLabels: {
                        offset: -25
                    }
                },
            },
            labels: ["Open", "Completed"],
            dataLabels: {
                enabled: true,
                style: {
                    fontFamily: "Inter, sans-serif",
                },
            },
            legend: {
                position: "bottom",
                fontFamily: "Inter, sans-serif",
            },
        }
    }

    const openRequests = <?php echo json_encode($openRequests) ?>;
    const completedRequests = <?php echo json_encode($completedRequests) ?>;

    if (document.getElementById("maintenance-chart") && typeof ApexCharts !== 'undefined') {
        const maintenanceChart = new ApexCharts(document.getElementById("maintenance-chart"), getMaintenanceRequestsChartOptions(openRequests, completedRequests));
        maintenanceChart.render();
    }

    // Script of the Churn Rate line chart
    const getChurnRateChartOptions = (churnData) => {
        return {
            series: [{
                name: 'Churn Rate',
                data: Object.values(churnData)
            }],
            colors: ["#FF0000"],
            chart: {
                height: 420,
                width: "100%",
                type: "line",
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontFamily: "Inter, sans-serif",
                },
            },
            xaxis: {
                categories: Object.keys(churnData)
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return value + '%';
                    }
                },
            },
            legend: {
                position: "bottom",
                fontFamily: "Inter, sans-serif",
            },
        }
    }

    const churnData = <?php echo json_encode($churnData)?>;

    if (document.getElementById("churn-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("churn-chart"), getChurnRateChartOptions(churnData));
        chart.render();
    }

    // Script on the rent collected line chart
    const getRentCollectedChartOptions = (rentCollected) => {
        return {
            series: [{
                name: 'Rent Collected',
                data: Object.values(rentCollected)
            }],
            colors: ["#36A2EB"],
            chart: {
                height: 420,
                width: "100%",
                type: "line",
            },
            stroke: {
                curve: 'smooth'
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontFamily: "Inter, sans-serif",
                },
            },
            xaxis: {
                categories: Object.keys(rentCollected)
            },
            legend: {
                position: "bottom",
                fontFamily: "Inter, sans-serif",
            },
        }
    }

    // Script on outstanding payments
    const getOutstandingPaymentsChartOptions = (outstandingPayments) => {
        return {
            series: [{
                name: 'Outstanding Payments',
                data: outstandingPayments.map(payment => payment.outstanding)
            }],
            colors: ["#FF0000"],
            chart: {
                height: 420,
                width: "100%",
                type: "bar",
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                }
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontFamily: "Inter, sans-serif",
                },
            },
            xaxis: {
                categories: outstandingPayments.map(payment => payment.tenant)
            },
            legend: {
                position: "bottom",
                fontFamily: "Inter, sans-serif",
            },
        }
    }

    const rentCollected = <?php echo json_encode($rentCollected); ?>;
    const outstandingPayments = <?php echo json_encode($outstandingPayments); ?>;

    if (document.getElementById("line-graph") && typeof ApexCharts !== 'undefined') {
        const rentCollectedChart = new ApexCharts(document.getElementById("line-graph"), getRentCollectedChartOptions(rentCollected));
        rentCollectedChart.render();
    }

    if (document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
        const outstandingPaymentsChart = new ApexCharts(document.getElementById("column-chart"), getOutstandingPaymentsChartOptions(outstandingPayments));
        outstandingPaymentsChart.render();
    }

    // Script on the payments history
    const paymentHistoryData = <?php echo json_encode(array_values($paymentHistory->toArray())); ?>;
    const paymentHistoryCategories = <?php echo json_encode(array_keys($paymentHistory->toArray())); ?>;

    const getPaymentHistoryChartOptions = () => {
        return {
            series: [{
                name: 'Payment History',
                data: paymentHistoryData // Replace with your data
            }],
            colors: ["#4BC0C0"],
            chart: {
                height: 420,
                width: "100%",
                type: "area",
            },
            stroke: {
                curve: 'smooth'
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontFamily: "Inter, sans-serif",
                },
            },
            xaxis: {
                categories: paymentHistoryCategories, // Replace with your data
            },
            legend: {
                position: "bottom",
                fontFamily: "Inter, sans-serif",
            },
        }
    }

    if (document.getElementById("area-graph") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("area-graph"), getPaymentHistoryChartOptions());
        chart.render();
    }
</script>
<!-- Script of the leases expiring graph -->
<script>
    const getLeaseExpiryChartOptions = () => {
        return {
            series: [{
                name: 'Leases Expiring',
                data: [5, 7, 3, 8, 2] // Replace with your data
            }],
            colors: ["#FF6384"],
            chart: {
                height: 420,
                width: "100%",
                type: "bar",
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                }
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontFamily: "Inter, sans-serif",
                },
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May'], // Replace with your data
            },
            legend: {
                position: "bottom",
                fontFamily: "Inter, sans-serif",
            },
        }
    }

    if (document.getElementById("bar-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("bar-chart"), getLeaseExpiryChartOptions());
        chart.render();
    }
</script>
@endsection
