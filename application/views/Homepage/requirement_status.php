<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requirements Status</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            width: 200px;
            max-width: 100%;
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


    <!-- Main Content -->
    <div class="main-container">
        <!-- Left Section -->
        <div class="left-section space-y-6">
            <!-- Uploaded Files -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">User Uploaded Files</h2>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">File Name</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Type</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (!empty($uploaded_files)): ?>
                            <?php foreach ($uploaded_files as $file): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 text-sm text-gray-800"><?= htmlspecialchars($file['file_name']); ?>
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-500"><?= ucfirst($file['file_type']); ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-500"><?= ucfirst($file['status']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="px-4 py-2 text-center text-sm text-gray-500">No files uploaded yet.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- <h2 class="text-2xl font-bold mt-8">Uploaded Tasks</h2>
            <div class="table overflow-x-auto bg-white p-6 rounded-md shadow-sm mt-4">
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


                </table>
            </div> -->
            <?php
            // Sort users by progress in descending order
            usort($users, function ($a, $b) {
                return $b['progress'] - $a['progress']; // Sort in descending order
            });
            ?>
            <!-- Users Progress -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">All Users</h2>
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

        <div class="right-section">
            <h2 class="text-md uppercase text-gray-800 flex justify-between my-3">Notifications <button
                    class="text-red-500 hover:line-through text-sm  uppercase"
                    onclick="deleteAllRequirement_statusNotifications()">Delete
                    All Notifications</button></h2>

            <?php if (!empty($notifications)): ?>
                <ul class="space-y-4">
                    <?php foreach ($notifications as $notification): ?>
                        <li id="notification-<?= $notification['id']; ?>"
                            class="bg-white p-4 shadow rounded-lg flex justify-between items-center">
                            <div>
                                <p class="text-gray-800"><?= htmlspecialchars($notification['message']); ?></p>
                                <small class="text-gray-500"><?= $notification['created_at']; ?></small>
                            </div>
                            <button class="text-red-500 hover:underline text-sm"
                                onclick="deleteRequirement_statusNotification(<?= $notification['id']; ?>)">Delete</button>
                        </li>
                    <?php endforeach; ?>

                </ul>

            <?php else: ?>
                <p class="text-gray-500">No new notifications.</p>
            <?php endif; ?>
        </div>

        <script>
            function deleteRequirement_statusNotification(notificationId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('<?= base_url('requirementstatus/deleteRequirement_statusNotification/'); ?>' + notificationId, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(`HTTP error! Status: ${response.status}`);
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.status === 'success') {
                                    Swal.fire(
                                        'Deleted!',
                                        data.message,
                                        'success'
                                    );
                                    document.querySelector(`#notification-${notificationId}`).remove();
                                } else {
                                    Swal.fire('Error!', data.message, 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire('Error!', 'An error occurred while deleting the notification.', 'error');
                            });
                    }
                });
            }

            function deleteAllRequirement_statusNotifications() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This will delete all notifications!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete all!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('<?= base_url('requirementstatus/deleteAllRequirement_statusNotifications'); ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(`HTTP error! Status: ${response.status}`);
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.status === 'success') {
                                    Swal.fire(
                                        'Deleted!',
                                        data.message,
                                        'success'
                                    );
                                    document.querySelector('.right-section ul').innerHTML = '';
                                } else {
                                    Swal.fire('Error!', data.message, 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire('Error!', 'An error occurred while deleting all notifications.', 'error');
                            });
                    }
                });
            }
        </script>

</body>

</html>