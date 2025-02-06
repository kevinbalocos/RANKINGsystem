<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve User</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .main-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .section {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            flex: 1;
            min-width: 280px;
            overflow-y: auto;
        }

        .section-header {
            padding-bottom: 1rem;
            border-bottom: 2px solid #e5e7eb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 0.75rem;
            text-align: left;
            font-size: 0.875rem;
        }

        table th {
            background-color: #f3f4f6;
            font-weight: bold;
            text-transform: uppercase;
            color: #4b5563;
        }

        table td {
            border-bottom: 1px solid #e5e7eb;
        }

        .action-links a {
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: background-color 0.3s;
        }

        .action-links .approve {
            color: #16a34a;
            border: 1px solid #16a34a;
        }

        .action-links .approve:hover {
            background-color: #16a34a;
            color: white;
        }

        .action-links .reject {
            color: #ef4444;
            border: 1px solid #ef4444;
        }

        .action-links .reject:hover {
            background-color: #ef4444;
            color: white;
        }

        .action-links .move {
            background-color: #facc15;
            color: #b45309;
        }

        .action-links .move:hover {
            background-color: #b45309;
            color: white;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <div class="p-6">
        <div class="main-container">
            <!-- Pending Users Table -->
            <div class="section">
                <div class="section-header">
                    <h2 class="text-2xl font-semibold text-gray-600">Pending Users</h2>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending_users as $user): ?>
                            <tr>
                                <td><?= $user['username'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td class="action-links">
                                    <a href="#" class="approve" onclick="approveUser(<?= $user['id'] ?>)">Approve</a> |
                                    <a href="#" class="reject" onclick="rejectUser(<?= $user['id'] ?>)">Reject</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="section">
                <div class="section-header">
                    <h2 class="text-2xl font-semibold text-gray-600">Approved Users</h2>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($approved_users as $user): ?>
                            <tr>
                                <td><?= $user['id'] ?></td>
                                <td><?= $user['username'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td class="action-links">
                                    <a href="#" class="move" onclick="moveToPending(<?= $user['id'] ?>)">Move to Pending</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="section">
                <div class="section-header">
                    <h2 class="text-2xl font-semibold text-gray-600">Rejected Users</h2>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rejected_users as $user): ?>
                            <tr>
                                <td><?= $user['id'] ?></td>
                                <td><?= $user['username'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td class="action-links">
                                    <a href="#" class="move" onclick="moveToPending(<?= $user['id'] ?>)">Move to Pending</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function approveUser(userId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to approve this user!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, approve it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading spinner while processing
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Please wait while we process your request.',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading(); // Show loading spinner
                        }
                    });

                    // AJAX request to approve user
                    $.ajax({
                        url: "<?= base_url('auth/approve_user') ?>",
                        method: "POST",
                        data: { user_id: userId },
                        success: function (response) {
                            Swal.fire('Approved!', 'The user has been approved.', 'success').then(() => {
                                location.reload(); // Reload the page after success
                            });
                        },
                        error: function () {
                            Swal.fire('Error!', 'There was an error approving the user.', 'error');
                        }
                    });
                }
            });
        }

        function rejectUser(userId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to reject this user!",
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Yes, reject it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading spinner while processing
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Please wait while we process your request.',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading(); // Show loading spinner
                        }
                    });

                    // AJAX request to reject user
                    $.ajax({
                        url: "<?= base_url('auth/reject_user') ?>",
                        method: "POST",
                        data: { user_id: userId },
                        success: function (response) {
                            Swal.fire('Rejected!', 'The user has been rejected.', 'success').then(() => {
                                location.reload(); // Reload the page after success
                            });
                        },
                        error: function () {
                            Swal.fire('Error!', 'There was an error rejecting the user.', 'error');
                        }
                    });
                }
            });
        }

        function moveToPending(userId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to move this user to pending!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Yes, move it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading spinner while processing
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Please wait while we process your request.',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading(); // Show loading spinner
                        }
                    });

                    // AJAX request to move user to pending
                    $.ajax({
                        url: "<?= base_url('auth/move_to_pending') ?>",
                        method: "POST",
                        data: { user_id: userId },
                        success: function (response) {
                            Swal.fire('Moved!', 'The user has been moved to pending.', 'success').then(() => {
                                location.reload(); // Reload the page after success
                            });
                        },
                        error: function () {
                            Swal.fire('Error!', 'There was an error moving the user to pending.', 'error');
                        }
                    });
                }
            });
        }
    </script>

    <!-- Include jQuery for AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>