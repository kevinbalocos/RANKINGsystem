<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Tasks</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="<?php echo base_url('assets/css/usertask.css?v=' . filemtime('assets/css/usertask.css')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <style>
        div.Task-Filters,
        div.table,
        .grid {
            margin-left: 20px;
        }

        /* Custom Toastify styles */
        .custom-toastify {
            font-family: 'Poppins';
            /* Use a custom font */
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: capitalize;
        }
    </style>

</head>

<body class="bg-gray-100 p-10 m-10">
    <header class="bg-white shadow px-6 py-3">
        <h1 class="text-2xl font-bold text-gray-800">YOUR TASK</h1>
    </header>

    <script>
        function saveTask(event, taskId) {
            event.preventDefault();  // Prevent the default form submission

            const formData = new FormData(event.target);  // Get the form data

            fetch("<?php echo base_url('home/saveTask'); ?>", {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Success Toast
                        Toastify({
                            text: "Task saved successfully!",
                            style: {
                                background: "linear-gradient(to right, #00b09b, #96c93d)",  // Green gradient background
                                color: "white",  // White text color
                                padding: "10px 20px",  // Padding for the notification
                                borderRadius: "10px",  // Rounded corners
                                boxShadow: "0 4px 10px rgba(0, 0, 0, 0.1)",  // Subtle shadow for depth
                                fontSize: "16px",  // Font size
                            },
                            duration: 3000,
                            close: true,
                            gravity: "top",  // Position at the top
                            position: "right",  // Position it on the right side
                            className: "custom-toastify",  // Custom class for additional styling
                            icon: "✔️",  // Custom icon for success
                        }).showToast();
                    } else {
                        // Error Toast
                        Toastify({
                            text: "Upload a File first!",
                            style: {
                                background: "linear-gradient(to right, #ff5f6d, #ffc3a0)",  // Red gradient background
                                color: "white",
                                padding: "10px 20px",
                                borderRadius: "10px",
                                boxShadow: "0 4px 10px rgba(0, 0, 0, 0.1)",
                                fontSize: "16px",
                            },
                            duration: 3000,
                            close: true,
                            gravity: "top",
                            position: "right",
                            className: "custom-toastify",
                            icon: "❌",  // Custom icon for error
                        }).showToast();
                    }
                })
                .catch(error => {
                    console.error("Error saving task:", error);
                });
        }
    </script>


    <!-- Task Statistics -->
    <!-- Task Statistics Graphs -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 mt-8">
        <!-- Total Tasks -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-bold">Total Tasks</h2>
            <p class="text-3xl text-blue-500 font-semibold"><?php echo $total_tasks; ?></p>
            <canvas id="totalTasksChart" class="max-h-32"></canvas>
        </div>

        <!-- Completed Tasks -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-bold">Completed Tasks</h2>
            <p class="text-3xl text-green-500 font-semibold"><?php echo $completed_tasks; ?></p>
            <canvas id="completedTasksChart" class="max-h-32"></canvas>
        </div>

        <!-- Pending Tasks -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-bold">Pending Tasks</h2>
            <p class="text-3xl text-red-500 font-semibold"><?php echo $pending_tasks; ?></p>
            <canvas id="pendingTasksChart" class="max-h-32"></canvas>
        </div>
    </div>

    <script>
        // Total Tasks Chart
        const totalTasksCtx = document.getElementById('totalTasksChart').getContext('2d');
        new Chart(totalTasksCtx, {
            type: 'bar',
            data: {
                labels: ['Total Tasks'],
                datasets: [{
                    data: [<?php echo $total_tasks; ?>],
                    backgroundColor: ['#3B82F6'],
                    borderColor: ['#3B82F6'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Completed Tasks Chart
        const completedTasksCtx = document.getElementById('completedTasksChart').getContext('2d');
        new Chart(completedTasksCtx, {
            type: 'bar',
            data: {
                labels: ['Completed Tasks'],
                datasets: [{
                    data: [<?php echo $completed_tasks; ?>],
                    backgroundColor: ['#10B981'],
                    borderColor: ['#10B981'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Pending Tasks Chart
        const pendingTasksCtx = document.getElementById('pendingTasksChart').getContext('2d');
        new Chart(pendingTasksCtx, {
            type: 'bar',
            data: {
                labels: ['Pending Tasks'],
                datasets: [{
                    data: [<?php echo $pending_tasks; ?>],
                    backgroundColor: ['#EF4444'],
                    borderColor: ['#EF4444'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    </script>
    <script>
        // Function to filter tasks based on status
        function filterTasks(status) {
            const rows = document.querySelectorAll('.task-row');
            rows.forEach(row => {
                const taskStatus = row.getAttribute('data-status');
                if (status === 'All' || taskStatus === status) {
                    row.style.display = ''; // Show task
                } else {
                    row.style.display = 'none'; // Hide task
                }
            });
        }

        // Event listeners for filter buttons
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const status = e.target.getAttribute('data-status');
                filterTasks(status);
            });
        });
        // Function to filter tasks by task name
        function searchTasks() {
            const searchQuery = document.querySelector('#search-input').value.toLowerCase(); // Get the search query
            const rows = document.querySelectorAll('.task-row'); // Get all task rows

            rows.forEach(row => {
                const taskName = row.querySelector('.task-name').textContent.toLowerCase(); // Get the task name in each row
                if (taskName.includes(searchQuery)) {
                    row.style.display = ''; // Show task if task name matches the search query
                } else {
                    row.style.display = 'none'; // Hide task if task name doesn't match
                }
            });
        }

        // Add event listener for search input
        document.querySelector('#search-input').addEventListener('input', searchTasks);
    </script>

    <!-- Task Filters -->
    <div class="Task-Filters flex justify-between items-center mb-6">
        <div class="flex gap-4">
            <button class="bg-purple-200 px-4 py-2 rounded hover:bg-purple-300 transition filter-btn"
                data-status="All">All
                Tasks</button>
            <button class="bg-green-200 px-4 py-2 rounded hover:bg-green-300 transition filter-btn"
                data-status="Completed">Completed</button>
            <button class="bg-yellow-200 px-4 py-2 rounded hover:bg-yellow-300 transition filter-btn"
                data-status="In Progress">In Progress</button>
            <button class="bg-red-200 px-4 py-2 rounded hover:bg-red-300 transition filter-btn"
                data-status="Not Started">Pending</button>
        </div>
        <input type="text" id="search-input" placeholder="Search tasks..." class="border px-4 py-2 rounded w-1/3">
    </div>

    <!-- Task Table -->
    <div class="table overflow-x-auto bg-white p-6 rounded-md shadow-sm" id="task-table">
        <table class="table-auto w-full text-left text-gray-700">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Task Name</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Owner</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">File</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Due Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($tasks) && is_array($tasks)): ?>
                    <?php foreach ($tasks as $task): ?>
                        <tr class="task-row border-b hover:bg-gray-50 transition-all"
                            data-status="<?php echo $task['status']; ?>">
                            <td class="task-name px-4 py-4 text-sm"><?php echo $task['task_name']; ?></td>
                            <td class="px-4 py-4 text-sm"><?php echo $task['owner']; ?></td>
                            <td class="px-4 py-4 text-sm">
                                <?php if ($task['status'] == 'Completed' || $task['status'] == 'Overdue'): ?>
                                    <p class="text-gray-500">
                                        <?php echo $task['status'] == 'Completed' ? 'Task Completed' : 'Overdue - Upload Disabled'; ?>
                                    </p>
                                <?php else: ?>
                                    <form action="javascript:void(0);" onsubmit="saveTask(event, <?php echo $task['id']; ?>)"
                                        class="flex items-center space-x-4">
                                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                        <label
                                            class="relative bg-gray-200 border border-gray-300 rounded-lg px-4 py-2 cursor-pointer flex items-center">
                                            <span class="text-gray-700">Upload File</span>
                                            <input type="file" name="task_file" class="absolute inset-0 opacity-0 cursor-pointer">
                                        </label>
                                        <button type="submit"
                                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                                            Save Task
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>

                            <td class="px-4 py-4 text-sm">
                                <?php echo date("F j, Y", strtotime($task['due_date'])); ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="border px-4 py-4 text-center text-gray-500">No tasks found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>

    <div class="table overflow-x-auto bg-white p-6 rounded-md shadow-sm mt-4">
        <h2 class="text-lg uppercase text-center  mt-8">Uploaded Tasks</h2>

        <table class="table-auto w-full text-left text-gray-700">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">File Name</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-3 text-sm font-semibold text-gray-600">Uploaded At</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($uploaded_tasks) && is_array($uploaded_tasks)): ?>
                    <?php foreach ($uploaded_tasks as $file): ?>
                        <tr class="border-b hover:bg-gray-50 transition-all">
                            <td class="px-4 py-4 text-sm">
                                <a href="<?php echo base_url('uploads/tasks/' . $file['file_name']); ?>" target="_blank"
                                    class="text-blue-500 hover:underline">
                                    <?php echo $file['file_name']; ?>
                                </a>
                            </td>
                            <td class="px-4 py-4 text-sm">
                                <span
                                    class="px-2 py-1 text-sm font-medium <?php echo $file['status'] == 'Completed' ? 'bg-green-200 text-green-800' : ($file['status'] == 'In Progress' ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800'); ?>">
                                    <?php echo $file['status']; ?>
                                </span>
                            </td>
                            <td class="px-4 py-4 text-sm">
                                <?php echo date("F j, Y, g:i A", strtotime($file['uploaded_at'])); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="border px-4 py-4 text-center text-gray-500">No uploaded tasks found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>



</body>

</html>