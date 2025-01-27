<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet"
        href="<?php echo base_url('assets/css/dashboard.css?v=' . filemtime('assets/css/dashboard.css')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-gray-100 p-6">
    <header class="bg-white shadow px-6 py-3 mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
    </header>


    <!-- Dashboard Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">


        <!-- Total Users -->
        <div class="bg-white shadow-md rounded-lg p-4 flex flex-col items-center card"
            onclick="confirmAction('userInfo')">
            <h2 class="card-title text-purple-500">Total Users</h2>
            <p class="card-stat text-purple-500"><?php echo count($users); ?></p>
            <canvas id="totalUsersChart"></canvas>
        </div>

        <!-- Pending Approval -->
        <div class="bg-white shadow-md rounded-lg p-4 flex flex-col items-center card"
            onclick="confirmAction('userfiles')">

            <h2 class="card-title text-yellow-500">Pending Approval</h2>
            <p class="card-stat text-yellow-500"><?php echo $totalUploaded - $approvedFiles - $deniedFiles; ?></p>
            <canvas id="pendingApprovalChart"></canvas>
        </div>



        <!-- Approved Files -->
        <div class="bg-white shadow-md rounded-lg p-4 flex flex-col items-center card"
            onclick="confirmAction('userfiles')">
            <h2 class="card-title text-green-500">Approved Files</h2>
            <p class="card-stat text-green-500"><?php echo $approvedFiles; ?></p>
            <canvas id="approvedFilesChart"></canvas>
        </div>

        <!-- Denied Files -->
        <div class="bg-white shadow-md rounded-lg p-4 flex flex-col items-center card"
            onclick="confirmAction('userfiles')">
            <h2 class="card-title text-red-500">Denied Files</h2>
            <p class="card-stat text-red-500"><?php echo $deniedFiles; ?></p>
            <canvas id="deniedFilesChart"></canvas>
        </div>

        <!-- Completed Tasks -->
        <div class="bg-white shadow-md rounded-lg p-4 flex flex-col items-center card" onclick="confirmAction('tasks')">
            <h2 class="card-title text-green-500">Completed Tasks</h2>
            <p class="card-stat text-green-500"><?php echo $completedTasks; ?></p>
            <canvas id="completedTasksChart"></canvas>
        </div>

        <!-- Pending Tasks -->
        <div class="bg-white shadow-md rounded-lg p-4 flex flex-col items-center card" onclick="confirmAction('tasks')">
            <h2 class="card-title text-red-500">Pending Tasks</h2>
            <p class="card-stat text-red-500"><?php echo $pendingTasks; ?></p>
            <canvas id="pendingTasksChart"></canvas>
        </div>
        <!-- Uploaded Files -->
        <div class="bg-white shadow-md rounded-lg p-4 flex flex-col items-center card"
            onclick="confirmAction('userfiles')">
            <h2 class="card-title text-blue-500">Uploaded Files</h2>
            <p class="card-stat text-blue-500"><?php echo $totalUploaded; ?></p>
            <canvas id="uploadedFilesChart"></canvas>
        </div>
        <!-- Overall Tasks -->
        <div class="bg-white shadow-md rounded-lg p-4 flex flex-col items-center card" onclick="confirmAction('tasks')">
            <h2 class="card-title text-blue-500">Overall Tasks</h2>
            <p class="card-stat text-blue-500"><?php echo $totalTask; ?></p>
            <canvas id="overallTasksChart"></canvas>
        </div>
    </div>


    <!-- Dashboard Row with 4 Columns: Recent Tasks, Users Progress, and Uploaded Files -->
    <div class="grid grid-cols-1 gap-3 mb-6 md:grid-cols-3">

        <!-- Recent Tasks (Resizable) -->
        <div class="dark_mode tables_second_row bg-white shadow-md rounded-lg p-4 resizable" id="recentTasks">
            <h2 class="text-xl font-bold mb-4">Recent Tasks</h2>
            <!-- Resize Handle -->
            <div class="resize-handle"></div>
            <?php if (!empty($recentTasks)): ?>
                <div class="table-scroll">
                    <table class="w-full text-gray-700">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-sm font-semibold">Task Name</th>
                                <th class="px-4 py-2 text-sm font-semibold">Task For (ID)</th>
                                <th class="px-4 py-2 text-sm font-semibold">Owner</th>
                                <th class="px-4 py-2 text-sm font-semibold">Status</th>
                                <th class="px-4 py-2 text-sm font-semibold">Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentTasks as $task): ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2"><?php echo $task['task_name'] ?? 'N/A'; ?></td>
                                    <td class="px-4 py-2"><?php echo htmlspecialchars($task['task_for'] ?? 'N/A'); ?></td>
                                    <td class="px-4 py-2"><?php echo $task['owner'] ?? 'N/A'; ?></td>
                                    <td class="px-4 py-2">
                                        <span
                                            class="px-2 py-1 rounded-md text-white
                                        <?php echo $task['status'] === 'In Progress' ? 'bg-yellow-500' : ($task['status'] === 'Completed' ? 'bg-green-500' : 'bg-red-500'); ?>">
                                            <?php echo $task['status'] ?? 'Unknown'; ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-2"><?php echo $task['due_date'] ?? 'N/A'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-gray-500">No recent tasks available.</p>
            <?php endif; ?>
        </div>
        <?php
        // Sort users by progress in descending order
        usort($users, function ($a, $b) {
            return $b['progress'] <=> $a['progress']; // Descending order
        });
        ?>
        <!-- Users Progress -->
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">All Users Progress</h2>
            <div class="table-scroll">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Username</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Progress</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($users as $user): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 text-sm text-gray-800"><?= htmlspecialchars($user['username']); ?></td>
                                <td class="px-4 py-2 text-sm text-gray-800">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: <?= round($user['progress'], 2); ?>%;">
                                        </div>
                                    </div>
                                    <div class="text-gray-500 mt-1 text-xs"><?= round($user['progress'], 2); ?>% Complete
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-3 mb-6 md:grid-cols-2">

            <!-- Weekly Tracker -->
            <div class="charts bg-white shadow-md rounded-lg p-4 md:col-span-3">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Weekly Tracker</h2>
                <canvas id="weeklyLineChart"></canvas> <!-- Canvas for the line graph -->
            </div>

            <!-- Uploaded Files Status -->
            <div class="charts bg-white shadow-md rounded-lg p-4 md:col-span-3">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Uploaded Files Status</h2>
                <canvas id="fileBarChart"></canvas> <!-- Canvas for the bar graph -->

            </div>
        </div>


        <script>
            // Data for the line graph
            const daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

            // Data from the PHP controller
            const approvedFilesData = <?= json_encode($approved_files_by_day); ?>;
            const deniedFilesData = <?= json_encode($denied_files_by_day); ?>;

            // Create the line graph using Chart.js
            const weeklyCtx = document.getElementById('weeklyLineChart').getContext('2d');
            const weeklyLineChart = new Chart(weeklyCtx, {
                type: 'line',
                data: {
                    labels: daysOfWeek, // X-axis labels (days of the week)
                    datasets: [
                        {
                            label: 'Approved Files',
                            data: approvedFilesData, // Y-axis values for approved files
                            backgroundColor: 'rgba(59, 130, 246, 0.2)', // Transparent blue fill
                            borderColor: 'rgba(59, 130, 246, 1)', // Blue line
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                            pointRadius: 4,
                        },
                        {
                            label: 'Denied Files',
                            data: deniedFilesData, // Y-axis values for denied files
                            backgroundColor: 'rgba(220, 38, 38, 0.2)', // Transparent red fill
                            borderColor: 'rgba(220, 38, 38, 1)', // Red line
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgba(220, 38, 38, 1)',
                            pointRadius: 4,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true, // Start Y-axis from zero
                        },
                    },
                },
            });
        </script>

        <script>
            // PHP Data passed into JavaScript
            const uploadedFiles = <?php echo json_encode($uploaded_files); ?>;
        </script>
        <script>
            // Prepare data for the bar chart
            const fileNames = uploadedFiles.map(file => file.file_name);
            const approvedFileCount = uploadedFiles.filter(file => file.status === 'approved').length;
            const deniedFileCount = uploadedFiles.filter(file => file.status === 'denied').length;
            const pendingFileCount = uploadedFiles.filter(file => file.status === 'pending').length;

            // Create the bar chart using Chart.js
            const ctx = document.getElementById('fileBarChart').getContext('2d');
            const fileBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Approved', 'Denied', 'Pending'], // X-axis labels for statuses
                    datasets: [{
                        label: 'File Status Counts', // Label for the bar chart
                        data: [approvedFileCount, deniedFileCount, pendingFileCount], // Y-axis values: counts of each status
                        backgroundColor: [
                            'rgba(34, 197, 94, 0.6)', // Approved bar color
                            'rgba(248, 113, 113, 0.6)', // Denied bar color
                            'rgba(251, 191, 36, 0.6)'  // Pending bar color
                        ],
                        borderColor: [
                            'rgba(34, 197, 94, 1)', // Approved border color
                            'rgba(248, 113, 113, 1)', // Denied border color
                            'rgba(251, 191, 36, 1)'  // Pending border color
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1 // Make sure the steps are integers
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // Hide the legend if not needed
                        },
                        tooltip: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    return `Count: ${tooltipItem.raw}`;
                                }
                            }
                        }
                    }
                }
            });

        </script>
        <script>
            function confirmAction(viewName) {
                Swal.fire({
                    title: 'Proceed?',
                    text: 'Are you sure you want to proceed?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, proceed!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        loadView(viewName);  // Proceed with the action
                    }
                });
            }
        </script>

        <script>
            // Overall Tasks Chart
            const overallTasksCtx = document.getElementById('overallTasksChart').getContext('2d');
            new Chart(overallTasksCtx, {
                type: 'bar',
                data: {
                    labels: ['Completed Tasks', 'Pending Tasks'],
                    datasets: [{
                        label: 'Tasks',
                        data: [<?php echo $completedTasks; ?>, <?php echo $pendingTasks; ?>],
                        backgroundColor: ['#34D399', '#F87171'],
                        borderColor: ['#34D399', '#F87171'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Total Users Chart
            const totalUsersCtx = document.getElementById('totalUsersChart').getContext('2d');
            new Chart(totalUsersCtx, {
                type: 'pie',
                data: {
                    labels: ['Users'],
                    datasets: [{
                        data: [<?php echo count($users); ?>],
                        backgroundColor: ['#9333EA'],
                        borderColor: ['#9333EA'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true
                }
            });

            // Pending Approval Chart
            const pendingApprovalCtx = document.getElementById('pendingApprovalChart').getContext('2d');
            new Chart(pendingApprovalCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Pending Approval'],
                    datasets: [{
                        data: [<?php echo $totalUploaded - $approvedFiles - $deniedFiles; ?>],
                        backgroundColor: ['#F59E0B'],
                        borderColor: ['#F59E0B'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true
                }
            });

            // Uploaded Files Chart
            const uploadedFilesCtx = document.getElementById('uploadedFilesChart').getContext('2d');
            new Chart(uploadedFilesCtx, {
                type: 'bar',
                data: {
                    labels: ['Uploaded Files', 'Approved Files', 'Denied Files'],
                    datasets: [{
                        label: 'Files',
                        data: [<?php echo $totalUploaded; ?>, <?php echo $approvedFiles; ?>, <?php echo $deniedFiles; ?>],
                        backgroundColor: ['#3B82F6', '#10B981', '#EF4444'],
                        borderColor: ['#3B82F6', '#10B981', '#EF4444'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Approved Files Chart
            const approvedFilesCtx = document.getElementById('approvedFilesChart').getContext('2d');
            new Chart(approvedFilesCtx, {
                type: 'bar',
                data: {
                    labels: ['Approved Files'],
                    datasets: [{
                        data: [<?php echo $approvedFiles; ?>],
                        backgroundColor: ['#10B981'],
                        borderColor: ['#10B981'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true
                }
            });

            // Denied Files Chart
            const deniedFilesCtx = document.getElementById('deniedFilesChart').getContext('2d');
            new Chart(deniedFilesCtx, {
                type: 'bar',
                data: {
                    labels: ['Denied Files'],
                    datasets: [{
                        data: [<?php echo $deniedFiles; ?>],
                        backgroundColor: ['#EF4444'],
                        borderColor: ['#EF4444'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true
                }
            });

            // Completed Tasks Chart
            const completedTasksCtx = document.getElementById('completedTasksChart').getContext('2d');
            new Chart(completedTasksCtx, {
                type: 'bar',
                data: {
                    labels: ['Completed Tasks'],
                    datasets: [{
                        data: [<?php echo $completedTasks; ?>],
                        backgroundColor: ['#34D399'],
                        borderColor: ['#34D399'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true
                }
            });

            // Pending Tasks Chart
            const pendingTasksCtx = document.getElementById('pendingTasksChart').getContext('2d');
            new Chart(pendingTasksCtx, {
                type: 'bar',
                data: {
                    labels: ['Pending Tasks'],
                    datasets: [{
                        data: [<?php echo $pendingTasks; ?>],
                        backgroundColor: ['#F87171'],
                        borderColor: ['#F87171'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true
                }
            });
        </script>


</body>

</html>