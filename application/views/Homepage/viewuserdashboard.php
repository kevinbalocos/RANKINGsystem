<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen p-6">

    <div class="m-10">

        <!-- Dashboard Title -->
        <div class="flex justify-between items-center mb-6">
        </div>

        <!-- Overall Progress Bar -->
        <div class="bg-white p-5 rounded-lg shadow-md mb-6">
            <h3 class="text-lg font-semibold mb-3">Overall Progress</h3>
            <div class="w-full bg-gray-200 rounded-full h-5">
                <div class="bg-green-500 h-5 rounded-full text-white text-xs text-center leading-5"
                    style="width: <?= $progress ?>%;">
                    <?= round($progress, 2) ?>%
                </div>
            </div>
        </div>
        <h1 class="bg-white my-3 rounded py-3 px-2 text-2xl font-bold text-gray-600 text-lg text-semibold uppercase ">📊
            User
            Dashboard</h1>


        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white shadow-md rounded-lg p-5 text-center">
                <h2 class="text-sm text-gray-600">Uploaded Files</h2>
                <p class="text-3xl font-bold text-blue-500"><?= $totalUploaded ?></p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-5 text-center">
                <h2 class="text-sm text-gray-600">Pending Approval</h2>
                <p class="text-3xl font-bold text-yellow-500"><?= $pendingFiles ?></p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-5 text-center">
                <h2 class="text-sm text-gray-600">Approved Files</h2>
                <p class="text-3xl font-bold text-green-500"><?= $approvedFiles ?></p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-5 text-center">
                <h2 class="text-sm text-gray-600">Denied Files</h2>
                <p class="text-3xl font-bold text-red-500"><?= $deniedFiles ?></p>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <!-- Pie Chart -->
            <div class="bg-white p-5 rounded-lg shadow-md">
                <h3 class="text-sm font-semibold mb-3 text-center">Approval Status</h3>
                <canvas id="approvalPieChart"></canvas>
            </div>

            <!-- Bar Chart -->
            <div class="bg-white p-5 rounded-lg shadow-md">
                <h3 class="text-sm font-semibold mb-3 text-center">Files Over Time</h3>
                <canvas id="uploadBarChart"></canvas>
            </div>

            <!-- Doughnut Chart -->
            <div class="bg-white p-5 rounded-lg shadow-md">
                <h3 class="text-sm font-semibold mb-3 text-center">File Categories</h3>
                <canvas id="categoryDoughnutChart"></canvas>
            </div>

            <!-- Line Chart -->
            <div class="bg-white p-5 rounded-lg shadow-md">
                <h3 class="text-sm font-semibold mb-3 text-center">Progress Trend</h3>
                <canvas id="progressLineChart"></canvas>
            </div>

        </div>

    </div>

    <script>
        // Pie Chart - Approval Status
        new Chart(document.getElementById('approvalPieChart'), {
            type: 'pie',
            data: {
                labels: ['Approved', 'Pending', 'Denied'],
                datasets: [{
                    data: [<?= $approvedFiles ?>, <?= $pendingFiles ?>, <?= $deniedFiles ?>],
                    backgroundColor: ['#10B981', '#FBBF24', '#EF4444']
                }]
            }
        });

        // Bar Chart - Uploaded Files Over Time
        new Chart(document.getElementById('uploadBarChart'), {
            type: 'bar',
            data: {
                labels: <?= $uploadDates ?>,
                datasets: [{
                    label: 'Uploads',
                    data: <?= $uploadCounts ?>,
                    backgroundColor: '#3B82F6'
                }]
            }
        });

        // Doughnut Chart - File Categories
        new Chart(document.getElementById('categoryDoughnutChart'), {
            type: 'doughnut',
            data: {
                labels: <?= $fileCategories ?>,
                datasets: [{
                    data: <?= $categoryCounts ?>,
                    backgroundColor: ['#F87171', '#34D399', '#60A5FA', '#FBBF24', '#A78BFA']
                }]
            }
        });

        // Line Chart - Progress Trend
        new Chart(document.getElementById('progressLineChart'), {
            type: 'line',
            data: {
                labels: <?= $uploadDates ?>,
                datasets: [{
                    label: 'Progress',
                    data: <?= $uploadCounts ?>,
                    borderColor: '#10B981',
                    fill: false
                }]
            }
        });
    </script>

</body>

</html>