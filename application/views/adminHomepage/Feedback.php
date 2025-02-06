<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Messages</title>
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
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Header -->
    <header class="bg-white shadow px-6 py-3">
        <h1 class="text-2xl font-bold text-gray-800">Feedback Messages</h1>
    </header>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Left Section - Feedback Messages -->
        <div class="left-section space-y-6">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">User Feedback</h2>

                <?php if (!empty($feedbacks)) { ?>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Name</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Message</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Date Submitted
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($feedbacks as $feedback) { ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 text-sm text-gray-800"><?= $feedback['id']; ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-800"><?= htmlspecialchars($feedback['name']); ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-500"><?= htmlspecialchars($feedback['email']); ?>
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-500">
                                        <?= nl2br(htmlspecialchars($feedback['message'])); ?>
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-500">
                                        <?= date('F j, Y, g:i a', strtotime($feedback['created_at'])); ?>
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        <button onclick="deleteFeedback(<?= $feedback['id']; ?>)"
                                            class="text-red-500 hover:underline">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                <?php } else { ?>
                    <p class="text-gray-500">No feedback messages yet.</p>
                <?php } ?>
            </div>
        </div>

        <!-- Right Section - Notifications -->
        <div class="right-section">
            <h2 class="text-md uppercase text-gray-800 flex justify-between my-3">Notifications

        </div>
    </div>

    <!-- JavaScript for Deleting Notifications -->
    <script>
        function deleteFeedbackNotification(notificationId) {
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
                    fetch('<?= base_url('feedback/deleteNotification/'); ?>' + notificationId, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire('Deleted!', data.message, 'success');
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

        function deleteAllFeedbackNotifications() {
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
                    fetch('<?= base_url('feedback/deleteAllNotifications'); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire('Deleted!', data.message, 'success');
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
    <script>
        function deleteFeedback(feedbackId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This feedback will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Make sure the URL is correct
                    fetch('<?= base_url('auth/deleteFeedback/'); ?>' + feedbackId, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire('Deleted!', data.message, 'success');
                                location.reload(); // Refresh page to update the table after successful deletion
                            } else {
                                Swal.fire('Error!', data.message, 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error!', 'An error occurred while deleting the feedback.', 'error');
                        });
                }
            });
        }


    </script>

</body>

</html>