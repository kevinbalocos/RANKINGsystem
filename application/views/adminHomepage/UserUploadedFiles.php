<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Uploaded Files</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/javascripts/UserUploadedFiles.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

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
        <h1 class="text-2xl font-bold text-gray-800">User Uploaded Files</h1>
    </header>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Left Section -->
        <div class="left-section space-y-6">
            <!-- Flash Messages -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                    <p class="font-medium"><?php echo $this->session->flashdata('success'); ?></p>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                    <p class="font-medium"><?php echo $this->session->flashdata('error'); ?></p>
                </div>
            <?php endif; ?>






            <!-- User Uploaded Files Table -->
            <div class="bg-white shadow-lg rounded-lg p-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <input type="checkbox" id="selectAll" onclick="toggleSelectAll()">
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Uploaded By
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                User Icon
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                File Name
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Type
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status
                            </th>

                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody id="filesTable" class="bg-white divide-y divide-gray-200">
                        <?php if (!empty($uploaded_files)): ?>
                            <?php
                            // Separate pending files from others
                            $pending_files = array_filter($uploaded_files, function ($file) {
                                return strtolower($file['status']) === 'pending';
                            });

                            $other_files = array_filter($uploaded_files, function ($file) {
                                return strtolower($file['status']) !== 'pending';
                            });

                            // Display pending files first
                            foreach (array_merge($pending_files, $other_files) as $file):
                                ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        <input type="checkbox" value="<?= $file['id'] ?>" class="file-checkbox">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php
                                        // Fetch the username or email of the user who uploaded the file
                                        $user = array_filter($users, function ($u) use ($file) {
                                            return $u['id'] == $file['user_id'];
                                        });
                                        $user = reset($user);
                                        echo htmlspecialchars($user['username'] ?? 'Unknown');
                                        ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        <img class="w-10 h-10 rounded-full"
                                            src="<?= base_url($user['uploaded_profile_image'] ?? 'uploads/default_profiles/default_profile.avif'); ?>"
                                            alt="Profile Image">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        <?= htmlspecialchars($file['file_name']) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= ucfirst(htmlspecialchars($file['file_type'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= ucfirst(htmlspecialchars($file['status'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="#"
                                            onclick="confirmDownload('<?= base_url(htmlspecialchars($file['file_path'])) ?>', '<?= htmlspecialchars($file['file_name']) ?>')"
                                            class="text-black-600 hover:text-blue-800">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <?php if ($file['status'] === 'pending'): ?>
                                            <button onclick="updateFileStatus(<?= $file['id'] ?>, 'approved')"
                                                class="ml-2 text-black-600 hover:text-green-800">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                            <button onclick="updateFileStatus(<?= $file['id'] ?>, 'denied')"
                                                class="ml-2 text-black-600 hover:text-red-800">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        <?php endif; ?>
                                        <button onclick="deleteFile(<?= $file['id'] ?>)"
                                            class="ml-2 text-black-600 hover:text-red-800">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    No files uploaded yet.
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
                    <li>
                        <a href="#" onclick="bulkApprove()"
                            class="block text-sm text-blue-600 hover:text-blue-800">Approve All Files</a>
                    </li>
                    <li>
                        <a href="#" onclick="bulkDeny()" class="block text-sm text-blue-600 hover:text-blue-800">Deny
                            New
                            All Files</a>
                    </li>
                    <li>
                        <a href="#" onclick="bulkDelete()"
                            class="block text-sm text-blue-600 hover:text-blue-800">Delete
                            All Files</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <script>
        function updateFileStatus(fileId, status) {
            Swal.fire({
                title: `Are you sure you want to ${status} this file?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?php echo base_url('conAdmin/updateFileStatus'); ?>",
                        method: "POST",
                        data: { file_id: fileId, status: status },
                        success: function (response) {
                            const result = JSON.parse(response);
                            Swal.fire({
                                icon: result.status === 'success' ? 'success' : 'error',
                                title: result.message
                            }).then(() => location.reload());
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'An error occurred. Please try again.'
                            });
                        }
                    });
                }
            });
        }

        function deleteFile(fileId) {
            Swal.fire({
                title: "Are you sure you want to delete this file?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?php echo base_url('conAdmin/deleteFile'); ?>",
                        method: "POST",
                        data: { file_id: fileId },
                        success: function (response) {
                            const result = JSON.parse(response);
                            Swal.fire({
                                icon: result.status === 'success' ? 'success' : 'error',
                                title: result.message
                            }).then(() => location.reload());
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'An error occurred. Please try again.'
                            });
                        }
                    });
                }
            });
        }

        function bulkApprove() {
            Swal.fire({
                title: "Are you sure you want to approve all pending files?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    const fileIds = getSelectedFileIds();
                    if (fileIds.length > 0) {
                        $.ajax({
                            url: "<?php echo base_url('conAdmin/bulkUpdateFileStatus'); ?>",
                            method: "POST",
                            data: { file_ids: fileIds, status: 'approved' },
                            success: function (response) {
                                const result = JSON.parse(response);
                                Swal.fire({
                                    icon: result.status === 'success' ? 'success' : 'error',
                                    title: result.message
                                }).then(() => location.reload());
                            },
                            error: function () {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'An error occurred. Please try again.'
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'No pending files selected.'
                        });
                    }
                }
            });
        }

        function bulkDeny() {
            Swal.fire({
                title: "Are you sure you want to deny all pending files?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    const fileIds = getSelectedFileIds();
                    if (fileIds.length > 0) {
                        $.ajax({
                            url: "<?php echo base_url('conAdmin/bulkUpdateFileStatus'); ?>",
                            method: "POST",
                            data: { file_ids: fileIds, status: 'denied' },
                            success: function (response) {
                                const result = JSON.parse(response);
                                Swal.fire({
                                    icon: result.status === 'success' ? 'success' : 'error',
                                    title: result.message
                                }).then(() => location.reload());
                            },
                            error: function () {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'An error occurred. Please try again.'
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'No pending files selected.'
                        });
                    }
                }
            });
        }


        function bulkDelete() {
            Swal.fire({
                title: "Are you sure you want to delete all selected files?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    const fileIds = getSelectedFileIds();
                    if (fileIds.length > 0) {
                        $.ajax({
                            url: "<?php echo base_url('conAdmin/bulkDeleteFiles'); ?>",
                            method: "POST",
                            data: { file_ids: fileIds },
                            success: function (response) {
                                const result = JSON.parse(response);
                                Swal.fire({
                                    icon: result.status === 'success' ? 'success' : 'error',
                                    title: result.message
                                }).then(() => location.reload());
                            },
                            error: function () {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'An error occurred. Please try again.'
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'No files selected.'
                        });
                    }
                }
            });
        }
        function getSelectedFileIds() {
            const checkboxes = document.querySelectorAll('.file-checkbox:checked');
            return Array.from(checkboxes).map(checkbox => checkbox.value);
        }

        function toggleSelectAll() {
            const masterCheckbox = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.file-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = masterCheckbox.checked);
        }

        $.ajax({
            url: "<?php echo base_url('conAdmin/updateFileStatus'); ?>",
            method: "POST",
            data: { file_id: fileId, status: status },
            success: function (response) {
                const result = JSON.parse(response);
                Swal.fire({
                    icon: result.status === 'success' ? 'success' : 'error',
                    title: result.message
                }).then(() => {
                    if (result.status === 'success') location.reload();
                });
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'An error occurred. Please check the console for details.'
                });
            }
        });

        function confirmDownload(filePath, fileName) {
            Swal.fire({
                title: `Download ${fileName}?`,
                text: "Are you sure you want to download this file?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Download",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create a hidden anchor element to trigger download
                    const link = document.createElement('a');
                    link.href = filePath;
                    link.download = fileName;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    Swal.fire({
                        icon: "success",
                        title: "Download started",
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        }


    </script>


</body>

</html>