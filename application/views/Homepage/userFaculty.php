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
            <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-2xl mx-auto">
                <!-- Profile Header -->
                <div class="flex items-center space-x-4 border-b pb-4">
                    <img class="w-16 h-16 rounded-full border border-gray-300"
                        src="<?= base_url($user['uploaded_profile_image'] ?? 'uploads/default_profiles/default_profile.avif'); ?>"
                        alt="Profile Image">
                    <div>
                        <h4 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($user['username']); ?></h4>
                        <p class="text-gray-600"><strong class="text-gray-800">Rank:</strong>
                            <?= htmlspecialchars($user['rank'] ?: 'Not Yet Assigned'); ?></p>
                        <p class="text-gray-600"><strong class="text-gray-800">Rank Label:</strong>
                            <?= htmlspecialchars($rank_label); ?></p>
                        <p class="text-gray-600"><strong class="text-gray-800">Faculty:</strong>
                            <?= htmlspecialchars($user['faculty'] ?: 'Not Yet Assigned'); ?></p>
                    </div>
                </div>

                <!-- Next Rank Requirements -->
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-800">Next Rank Requirements:</h3>
                    <p class="text-gray-700 mt-1"><strong class="text-gray-800">To be
                            <?= htmlspecialchars($next_rank_order); ?>, submit:</strong></p>
                    <p class="text-gray-600"><?= htmlspecialchars($next_rank_label); ?></p>
                </div>

                <!-- File Upload Form -->
                <form method="POST" enctype="multipart/form-data"
                    action="<?= base_url('controllerFaculty/submitFile') ?>" id="fileForm" class="mt-6">
                    <label class="block text-gray-700 font-medium mb-2" for="file">Upload File:</label>
                    <input type="file" name="file" id="file" required
                        class="block w-full border border-gray-300 rounded-md py-2 px-4 text-gray-700 focus:ring focus:ring-blue-300">

                    <button type="submit"
                        class="w-full bg-blue-600 text-white font-medium py-2 px-4 rounded-md mt-4 hover:bg-blue-700 transition-all duration-300">
                        Submit File
                    </button>
                </form>
            </div>

            <h1 class="text-2xl py-2 uppercase">FACULTY MEMBERS</h1>
            <div class="faculty p-2 border rounded-lg shadow-md bg-gray-100">
                <!-- Fellow faculty members -->
                <?php if (isset($fellow_faculty_members) && !empty($fellow_faculty_members)): ?>
                    <?php foreach ($fellow_faculty_members as $faculty_member): ?>
                        <?php if ($faculty_member['id'] != $user['id'] && !empty($faculty_member['faculty']) && $faculty_member['faculty'] === $user['faculty']) { ?>
                            <div class="bg-white card m-2 p-3 rounded-lg shadow">
                                <div class="card-header flex items-center space-x-3">
                                    <img class="w-12 h-12 rounded-full object-cover"
                                        src="<?= base_url($faculty_member['uploaded_profile_image'] ?? 'uploads/default_profiles/default_profile.avif'); ?>"
                                        alt="Profile Image">
                                    <div>
                                        <h3 class="text-lg font-semibold">
                                            <?= htmlspecialchars($faculty_member['username']); ?>
                                        </h3>
                                        <p class="text-sm text-gray-600"><strong>Rank:</strong>
                                            <?= htmlspecialchars($faculty_member['rank'] ?: 'Not Yet Assigned'); ?></p>
                                        <p class="text-sm text-gray-600"><strong>Faculty:</strong>
                                            <?= htmlspecialchars($faculty_member['faculty'] ?: 'Not Yet Assigned'); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500 text-center">No fellow faculty members found.</p>
                <?php endif; ?>
            </div>

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

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This action cannot be undone.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('<?= base_url('controllerFaculty/declineFile/'); ?>' + submissionId)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire('Deleted!', data.message, 'success')
                                            .then(() => location.reload());
                                    } else {
                                        Swal.fire('Error!', data.message, 'error');
                                    }
                                })
                                .catch(() => Swal.fire('Error!', 'An error occurred.', 'error'));
                        }
                    });
                });
            });


        </script>

    </div>
</body>

</html>