<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USER UPLOADED TASKS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
        }

        .main-container {
            display: flex;
            height: calc(100vh - 4rem);
            padding: 2rem;
        }

        .left-section,
        .right-section {
            padding: 1.5rem;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .left-section {
            flex: .5;
            margin-right: 2rem;
        }

        .right-section {
            flex: 1;
            background-color: #ffffff;
            border-left: 1px solid #e5e7eb;
        }

        .filter-section {
            margin-bottom: 1.5rem;
        }

        .filter-section select {
            width: 100%;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            font-size: 1rem;
            background-color: #ffffff;
            cursor: pointer;
        }

        table {
            width: 100%;
            margin-top: 1rem;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            padding: 0.75rem;
            text-align: left;
            font-size: 1rem;
        }

        th {
            background-color: #f3f4f6;
            font-weight: 600;
            color: #4b5563;
        }

        td {
            background-color: #ffffff;
            color: #4b5563;
        }

        tr:hover {
            background-color: #f9fafb;
        }

        .status-label {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 9999px;
        }

        .status-completed {
            background-color: #d1fae5;
            color: #16a34a;
        }

        .status-in-progress {
            background-color: #fef3c7;
            color: #f59e0b;
        }

        .status-pending {
            background-color: #fee2e2;
            color: #ef4444;
        }

        .action-btn {
            padding: 0.25rem 0.75rem;
            border-radius: 8px;
            background-color: #3b82f6;
            color: #ffffff;
            font-size: 0.875rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .action-btn:hover {
            background-color: #2563eb;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header class="bg-white shadow px-6 py-3">
        <h1 class="text-2xl font-bold text-gray-800">TASK AND REQUIREMENTS</h1>
    </header>
    <!-- Main Content -->
    <div class="main-container">

        <!-- Left Section -->
        <div class="left-section">
            <!-- Filter Section -->
            <div class="filter-section">
                <h3 class="text-lg font-medium text-gray-700">USER TASKS </h3>
                <label for="statusFilter" class="text-sm font-medium text-gray-700">Filter by Status:</label>
                <select id="statusFilter">
                    <option value="">All</option>
                    <option value="Completed">Completed</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Not Started">Not Started</option>
                </select>
            </div>

            <!-- Task Table -->
            <table>
                <thead>
                    <tr>
                        <th>File Name</th>
                        <th>Status</th>
                        <th>Uploaded By</th>
                        <th>Uploaded At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($uploaded_tasks) && is_array($uploaded_tasks)): ?>
                        <?php foreach ($uploaded_tasks as $file): ?>
                            <tr class="task-row" data-status="<?= $file['status']; ?>">
                                <td>
                                    <a href="<?php echo base_url('uploads/tasks/' . $file['file_name']); ?>" target="_blank"
                                        class="text-blue-500 hover:underline">
                                        <?= $file['file_name']; ?>
                                    </a>
                                    <?php
                                    // If it's a PDF, show a preview link
                                    $file_extension = pathinfo($file['file_name'], PATHINFO_EXTENSION);
                                    if ($file_extension == 'pdf'): ?>
                                        <a href="https://docs.google.com/viewer?url=<?= base_url('uploads/tasks/' . $file['file_name']); ?>"
                                            target="_blank" class="text-blue-500 hover:underline ml-2">View PDF</a>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <span
                                        class="status-label 
                                    <?= $file['status'] == 'Completed' ? 'status-completed' : ($file['status'] == 'In Progress' ? 'status-in-progress' : 'status-pending'); ?>">
                                        <?= $file['status']; ?>
                                    </span>
                                </td>
                                <td><?= $file['username']; ?></td>
                                <td><?= date("F j, Y, g:i A", strtotime($file['uploaded_at'])); ?></td>
                                <td>
                                    <button onclick="deleteTaskbyUploadedTask(<?= $file['id']; ?>)"
                                        class="bg-red-400 hover:bg-red-500 rounded-lg py-1 px-1 text-white">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-gray-500">No uploaded tasks found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Right Section -->
        <div class="right-section bg-white rounded-xl shadow-lg p-6 w-full">
            <h3 class="text-2xl font-semibold text-gray-800 mb-4">Ranking Requirements</h3>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse rounded-lg overflow-hidden shadow-sm">
                    <thead class="bg-gray-100 text-gray-700 text-sm font-semibold">
                        <tr class="border-b border-gray-200">
                            <th class="py-3 px-4 text-left">File</th>
                            <th class="py-3 px-4 text-left">Uploaded By</th>
                            <th class="py-3 px-4 text-left">Submitted At</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-left">Current Rank Label</th>
                            <th class="py-3 px-4 text-left">Next Rank Label</th>
                            <th class="py-3 px-4 text-left">Next Rank Order</th>
                            <th class="py-3 px-4 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (is_array($file_submissions) && count($file_submissions) > 0): ?>
                            <?php foreach ($file_submissions as $submission): ?>
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-200">
                                    <td class="py-3 px-4 text-sm">
                                        <a href="<?= base_url($submission['file_path']); ?>" target="_blank"
                                            class="text-blue-500 hover:underline">
                                            View
                                        </a>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-700">
                                        <?= htmlspecialchars($submission['username'] ?? 'Unknown User'); ?>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-700">
                                        <?= isset($submission['submitted_at']) ? date("F j, Y, g:i A", strtotime($submission['submitted_at'])) : 'N/A'; ?>
                                    </td>
                                    <td class="py-3 px-4 text-sm">
                                        <span
                                            class="inline-block py-1 px-3 rounded-full text-xs font-semibold 
                                    <?= $submission['approved'] ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'; ?>">
                                            <?= $submission['approved'] ? 'Approved' : 'Pending'; ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-700"><?= htmlspecialchars($submission['label']); ?>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-700">
                                        <?= htmlspecialchars($submission['next_rank_label']); ?>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-700">
                                        <?= htmlspecialchars($submission['next_rank_order']); ?>
                                    </td>
                                    <td class="py-3 px-4 text-sm">
                                        <?php if (!$submission['approved']): ?>
                                            <a href="javascript:void(0);" class="approve-link text-green-400 hover:text-green-500"
                                                data-id="<?= $submission['id']; ?>">
                                                <i class="fas fa-check-circle text-lg"></i> <!-- Approve Icon -->
                                            </a>
                                        <?php endif; ?>
                                        <a href="javascript:void(0);" class="decline-link text-red-400 hover:text-red-500"
                                            data-id="<?= $submission['id']; ?>">
                                            <i class="fas fa-times-circle text-lg"></i> <!-- Decline Icon -->
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="py-4 px-4 text-center text-gray-500">No file submissions found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Include Font Awesome CDN for Icons -->
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>

        <script>
            // Approve file submission
            document.querySelectorAll('.approve-link').forEach(function (element) {
                element.addEventListener('click', function (e) {
                    e.preventDefault();
                    const submissionId = this.getAttribute('data-id');

                    // SweetAlert2 confirm box for approve
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You are about to approve this submission.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, approve it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Use AJAX to send approval request
                            fetch('<?= base_url('controllerFaculty/approveFile/'); ?>' + submissionId)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire(
                                            'Approved!',
                                            data.message,
                                            'success'
                                        ).then(() => {
                                            location.reload(); // Reload the page to reflect changes
                                        });
                                    } else {
                                        Swal.fire(
                                            'Error!',
                                            data.message,
                                            'error'
                                        );
                                    }
                                })
                                .catch(error => {
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred while processing the request.',
                                        'error'
                                    );
                                });
                        }
                    });
                });
            });

            // Decline file submission
            document.querySelectorAll('.decline-link').forEach(function (element) {
                element.addEventListener('click', function (e) {
                    e.preventDefault();
                    const submissionId = this.getAttribute('data-id');

                    // SweetAlert2 confirm box for decline
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You are about to delete this submission.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Use AJAX to send decline request
                            fetch('<?= base_url('controllerFaculty/declineFile/'); ?>' + submissionId)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire(
                                            'Delete!',
                                            data.message,
                                            'success'
                                        ).then(() => {
                                            location.reload(); // Reload the page to reflect changes
                                        });
                                    } else {
                                        Swal.fire(
                                            'Error!',
                                            data.message,
                                            'error'
                                        );
                                    }
                                })
                                .catch(error => {
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred while processing the request.',
                                        'error'
                                    );
                                });
                        }
                    });
                });
            });

        </script>

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