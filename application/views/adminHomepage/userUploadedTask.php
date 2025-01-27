<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USER UPLOADED TASK</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-container {
            display: flex;
            height: calc(100vh - 3rem);
            /* Adjusting for header height */
            overflow: hidden;
        }

        .left-section,
        .right-section {
            overflow-y: auto;
            padding: 1rem;
        }

        .left-section {
            flex: 2;
        }

        .right-section {
            flex: 1;
            background-color: #f9fafb;
            border-left: 1px solid #e5e7eb;
            max-width: 350px;
        }

        .progress-bar {
            width: 100%;
            background-color: #e5e7eb;
            border-radius: 0.375rem;
            height: 0.625rem;
            position: relative;
        }

        .progress-fill {
            background-color: #3b82f6;
            height: 100%;
            border-radius: 0.375rem;
        }
    </style>
</head>

<body class="bg-gray-50">


    <!-- Header -->
    <header class="bg-white shadow px-6 py-3">
        <h1 class="text-2xl font-bold text-gray-800">USER UPLOADED TASKS</h1>
    </header>


    <!-- Main Content -->
    <div class="main-container">
        <div class="left-section space-y-6">

            <!-- Filter Section -->
            <div class="mb-4">
                <h2 class="text-2xl font-bold">Uploaded Tasks</h2>

                <label for="statusFilter" class="text-sm font-medium text-gray-700">Filter by Status:</label>
                <select id="statusFilter" class="mt-1 px-4 py-2 bg-white border rounded-md">
                    <option value="">All</option>
                    <option value="Completed">Completed</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Not Started">Not Started</option>
                </select>
            </div>

            <!-- Table with Tasks -->
            <div class="table overflow-x-auto bg-white p-6 rounded-md shadow-sm mt-4">
                <table class="table-auto w-full text-left text-gray-700" id="tasksTable">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600">File Name</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600">Status</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600">Uploaded By</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600">Uploaded At</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($uploaded_tasks) && is_array($uploaded_tasks)): ?>
                            <?php foreach ($uploaded_tasks as $file): ?>
                                <tr class="border-b hover:bg-gray-50 transition-all task-row"
                                    data-status="<?= $file['status']; ?>">
                                    <td class="px-4 py-4 text-sm">
                                        <a href="<?php echo base_url('uploads/tasks/' . $file['file_name']); ?>" target="_blank"
                                            class="text-blue-500 hover:underline">
                                            <?php echo $file['file_name']; ?>
                                        </a>
                                    </td>
                                    <td class="px-4 py-4 text-sm">
                                        <span
                                            class="px-2 py-1 text-sm font-medium <?= $file['status'] == 'Completed' ? 'bg-green-200 text-green-800' : ($file['status'] == 'In Progress' ? 'bg-yellow-200 text-yellow-800' : 'bg-red-200 text-red-800'); ?>">
                                            <?php echo $file['status']; ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-sm"><?php echo $file['username']; ?></td>
                                    <td class="px-4 py-4 text-sm">
                                        <?php echo date("F j, Y, g:i A", strtotime($file['uploaded_at'])); ?>
                                    </td>

                                    <td class="px-4 py-4 text-sm">
                                        <!-- Delete Task -->
                                        <button onclick="deleteTaskbyUploadedTask(<?= $file['id']; ?>)"
                                            class="ml-2 text-black-800 hover:text-red-800">
                                            <i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="border px-4 py-4 text-center text-gray-500">No uploaded tasks found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-section">

            <!-- File Management Shortcuts -->
            <div>
                <h3 class="text-lg font-medium text-gray-700">Quick Actions</h3>
                <ul class="space-y-4 mt-4">

                </ul>
            </div>
        </div>
    </div>



    <script>
        // Filter tasks based on status
        document.getElementById('statusFilter').addEventListener('change', function () {
            let statusFilter = this.value.toLowerCase();
            let taskRows = document.querySelectorAll('.task-row');

            taskRows.forEach(row => {
                let taskStatus = row.getAttribute('data-status').toLowerCase();
                if (statusFilter === '' || taskStatus === statusFilter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });


        // Function to delete the task
        function deleteTaskbyUploadedTask(taskId) {
            Swal.fire({
                title: "Are you sure you want to delete this task?",
                text: "This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`<?php echo base_url('conAdmin/deleteTaskbyUploadedTask/'); ?>` + taskId, {
                        method: 'POST'
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    'The task has been deleted.',
                                    'success'
                                ).then(() => location.reload()); // Reload the page to reflect changes
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete task: ' + data.message,
                                    'error'
                                );
                            }
                        })
                        .catch(err => Swal.fire('Error', 'An error occurred: ' + err, 'error'));
                }
            });
        }

    </script>

</body>

</html>