<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="<?php echo base_url('assets/css/userFaculty.css?v=' . filemtime('assets/css/userFaculty.css')); ?>">
    <title>User Faculty</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


</head>

<body>


    <div class="main-container">
        <div class="bg-white left-section">
            <div class="card-header">
                <img class="image_size"
                    src="<?= base_url($user['uploaded_profile_image'] ?? 'uploads/default_profiles/default_profile.avif'); ?>"
                    alt="Profile Image">
                <div>
                    <h4><?= htmlspecialchars($user['username']); ?></h4>
                    <p><strong>Rank:</strong> <?= htmlspecialchars($user['rank'] ?: 'Not Yet Assigned'); ?></p>
                    <p><strong>Rank Label:</strong> <?= htmlspecialchars($rank_label); ?></p>
                    <p><strong>Faculty:</strong> <?= htmlspecialchars($user['faculty'] ?: 'Not Yet Assigned'); ?></p>
                </div>
            </div>

            <div>
                <h3 class="font-semibold text-lg mb-2">Next Rank Requirements:</h3>
                <p><strong>To be <?= htmlspecialchars($next_rank_order); ?>, submit:</strong></p>
                <p><?= htmlspecialchars($next_rank_label); ?></p>
            </div>

            <form method="POST" enctype="multipart/form-data" action="<?= base_url('controllerFaculty/submitFile') ?>"
                id="fileForm">
                <input type="file" name="file" required
                    class="block w-full mt-4 mb-4 py-2 px-4 border border-gray-300 rounded-md">
                <button type="submit" class="btn-submit">Submit File</button>
            </form>

            <table class="min-w-full divide-y divide-gray-200 file-submission-table">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            File</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Current Rank Label</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Next Rank Label</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Next Rank Order</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (is_array($file_submissions) && count($file_submissions) > 0): ?>
                        <?php foreach ($file_submissions as $submission): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><a
                                        class="text-blue-500 hover:underline"
                                        href="<?= base_url($submission['file_path']); ?>">View File</a></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                    <span
                                        class="status-label <?= $submission['approved'] ? 'status-approved' : 'status-pending'; ?>">
                                        <?= $submission['approved'] ? 'Approved' : 'Pending'; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                    <?= htmlspecialchars($submission['label']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                    <?= htmlspecialchars($submission['next_rank_label']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                    <?= htmlspecialchars($submission['next_rank_order']); ?>
                                </td>
                                <td class="action-links px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                    <!-- <?php if (!$submission['approved']): ?>
                                        <a href="<?= base_url('controllerFaculty/approveFile/' . $submission['id']); ?>"
                                            class="text-green-600">
                                            <i class="fas fa-check-circle text-lg"></i> <!-- Approve Icon -->
                                        </a>
                                    <?php endif; ?> -->
                                    <a href="javascript:void(0);" class="text-red-400 hover:text-red-500 decline-link"
                                        data-id="<?= $submission['id']; ?>">
                                        <i class="fas fa-times-circle text-lg"></i> <!-- Decline Icon -->
                                    </a>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-4">No file submissions found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="right-section">
            <h1 class="text-2xl uppercase">FACULTY MEMBERS</h1>

            <!-- Fellow faculty members -->
            <?php if (isset($fellow_faculty_members) && !empty($fellow_faculty_members)): ?>
                <?php foreach ($fellow_faculty_members as $faculty_member): ?>
                    <?php if ($faculty_member['id'] != $user['id'] && !empty($faculty_member['faculty']) && $faculty_member['faculty'] === $user['faculty']) { ?>
                        <div class="bg-white card m-2">
                            <div class="card-header">
                                <img class="image_size"
                                    src="<?= base_url($faculty_member['uploaded_profile_image'] ?? 'uploads/default_profiles/default_profile.avif'); ?>"
                                    alt="Profile Image">
                                <div>
                                    <h3>
                                        <?= htmlspecialchars($faculty_member['username']); ?>
                                    </h3>
                                    <p><strong>Rank:</strong>
                                        <?= htmlspecialchars($faculty_member['rank'] ?: 'Not Yet Assigned'); ?></p>
                                    <p><strong>Faculty:</strong>
                                        <?= htmlspecialchars($faculty_member['faculty'] ?: 'Not Yet Assigned'); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No fellow faculty members found.</p>
            <?php endif; ?>
        </div>
        <script>
            document.getElementById('fileForm').addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent the form from submitting

                const formData = new FormData(this);

                fetch('<?= base_url('controllerFaculty/submitFile') ?>', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonText: 'Okay'
                            }).then(() => {
                                location.reload(); // Reload the page after clicking "Okay"
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.message,
                                icon: 'error',
                                confirmButtonText: 'Try Again'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while uploading the file.',
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });
                    });
            });
            // Decline file submission with SweetAlert2 confirmation
            document.querySelectorAll('.decline-link').forEach(function (element) {
                element.addEventListener('click', function (e) {
                    e.preventDefault();
                    const submissionId = this.getAttribute('data-id');

                    // SweetAlert2 confirmation dialog for decline
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You are about to delete this submission.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Proceed with the delete action via fetch
                            fetch('<?= base_url('controllerFaculty/declineFile/'); ?>' + submissionId)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            title: 'Success!',
                                            text: data.message,
                                            icon: 'success',
                                            confirmButtonText: 'Okay'
                                        }).then(() => {
                                            location.reload(); // Reload the page to reflect the changes
                                        });
                                    } else {
                                        Swal.fire({
                                            title: 'Error!',
                                            text: data.message,
                                            icon: 'error',
                                            confirmButtonText: 'Try Again'
                                        });
                                    }
                                })
                                .catch(error => {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'An error occurred while deleting the file.',
                                        icon: 'error',
                                        confirmButtonText: 'Try Again'
                                    });
                                });
                        }
                    });
                });
            });


        </script>

    </div>
</body>

</html>