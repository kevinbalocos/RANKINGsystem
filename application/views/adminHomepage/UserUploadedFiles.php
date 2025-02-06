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

        .hidden {
            display: none;
        }

        #send_message_des {
            width: 500px;
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




            <!-- Filter Buttons and Search Bar -->
            <div class="buttons flex justify-between items-center mb-6">
                <div class="flex gap-4">
                    <button class="bg-purple-200 px-4 py-2 rounded hover:bg-purple-300 transition filter-btn"
                        onclick="filterFiles('All')">All Files</button>
                    <button class="bg-green-200 px-4 py-2 rounded hover:bg-green-300 transition filter-btn"
                        onclick="filterFiles('Credential')">Credential</button>
                    <button class="bg-yellow-200 px-4 py-2 rounded hover:bg-yellow-300 transition filter-btn"
                        onclick="filterFiles('Mandatory')">Mandatory</button>
                    <button class="bg-red-200 px-4 py-2 rounded hover:bg-red-300 transition filter-btn"
                        onclick="filterFiles('Yearly Event')">Yearly Event</button>
                </div>
            </div>

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
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                File Name
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Points
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Category
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
                                Date Uploaded
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Date Modified
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Message User
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <?php
                    $grouped_files = [];
                    foreach ($uploaded_files as $file) {
                        $grouped_files[$file['user_id']][] = $file;
                    }
                    ?>

                    <tbody id="filesTable" class="bg-white divide-y divide-gray-200">
                        <?php if (!empty($grouped_files)): ?>
                            <?php foreach ($grouped_files as $user_id => $files): ?>
                                <?php
                                // Fetch user data
                                $user = array_filter($users, function ($u) use ($user_id) {
                                    return $u['id'] == $user_id;
                                });
                                $user = reset($user);
                                ?>
                                <tr class="user-row hover:bg-gray-50 cursor-pointer">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" class="select-user-checkbox" data-user-id="<?= $user_id ?>"
                                            onclick="toggleUserFiles(<?= $user_id ?>)">
                                    </td>
                                    <td class="px-6 py-4"><?= htmlspecialchars($user['username'] ?? 'Unknown') ?></td>
                                    <td class="px-6 py-4">
                                        <img class="w-10 h-10 rounded-full"
                                            src="<?= base_url($user['uploaded_profile_image'] ?? 'uploads/default_profiles/default_profile.avif'); ?>"
                                            alt="Profile Image">
                                    </td>
                                    <td colspan="10" class="px-6 py-4 text-center text-gray-500 cursor-pointer"
                                        onclick="toggleFiles(<?= $user_id ?>)">
                                        <strong><?= count($files) ?> Files Uploaded (Click to Expand)</strong>
                                    </td>
                                </tr>


                                <?php foreach ($files as $file): ?>
                                    <tr class="file-row user-files-<?= $user_id ?> hidden">
                                        <td class="px-6 py-4">
                                            <input type="checkbox" class="file-checkbox user-<?= $user_id ?>"
                                                value="<?= $file['id'] ?>">
                                        </td>
                                        <td class="px-6 py-4"><?= htmlspecialchars($user['username'] ?? 'Unknown') ?></td>
                                        <td class="px-6 py-4">
                                            <img class="w-10 h-10 rounded-full"
                                                src="<?= base_url($user['uploaded_profile_image'] ?? 'uploads/default_profiles/default_profile.avif'); ?>"
                                                alt="Profile Image">
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php
                                            $filePath = base_url(htmlspecialchars($file['file_path']));
                                            $fileName = htmlspecialchars($file['file_name']);
                                            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                                            $previewableExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
                                            ?>
                                            <?php if (in_array(strtolower($fileExtension), $previewableExtensions)): ?>
                                                <a href="<?= $filePath ?>" target="_blank"
                                                    class="text-blue-500 hover:underline"><?= $fileName ?></a>
                                            <?php else: ?>
                                                <a href="<?= $filePath ?>" download
                                                    class="text-blue-500 hover:underline"><?= $fileName ?> (Download)</a>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 py-3"><?= htmlspecialchars($file['points']) ?></td> <!-- Display points -->

                                        <td class="px-4 py-3">
                                            <?= (strpos($file['file_path'], 'mandatory_requirements') !== false)
                                                ? '<span class="text-red-500">Mandatory</span>'
                                                : ((strpos($file['file_path'], 'yearly_requirements') !== false)
                                                    ? '<span class="text-blue-500">Yearly</span>'
                                                    : '<span class="text-green-500">Credential</span>'); ?>
                                        </td>
                                        <td class="px-6 py-4"><?= ucfirst(htmlspecialchars($file['file_type'])) ?></td>
                                        <td class="px-6 py-4"><?= ucfirst(htmlspecialchars($file['status'])) ?></td>
                                        <td class="px-4 py-3"><?= date('F j, Y - g:i A', strtotime($file['uploaded_at'])) ?></td>

                                        <td class="px-4 py-3">
                                            <?php if (empty($file['updated_at'])): ?>
                                                <span class="text-gray-500">Not Yet Modified</span>
                                                <!-- Display "Unread" if updated_at is empty -->
                                            <?php else: ?>
                                                <?= date('F j, Y - g:i A', strtotime($file['updated_at'])) ?>
                                            <?php endif; ?>
                                        </td>
                                        <!-- Add a section for sending messages to users -->
                                        <!-- Action: Send message to user -->
                                        <td class="px-6 py-4">
                                            <button onclick="openMessageModal(<?= $user_id ?>)"
                                                class="text-green-300 hover:text-green-400">
                                                <i class="fas fa-comment-alt"></i>
                                            </button>
                                        </td>

                                        <td class="px-6 py-4">
                                            <?php if ($file['status'] !== 'approved' && $file['status'] !== 'denied'): ?>
                                                <button onclick="updateFileStatus(<?= $file['id'] ?>, 'approved')"
                                                    class="ml-2 text-green-600 hover:text-green-800">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button onclick="updateFileStatus(<?= $file['id'] ?>, 'denied')"
                                                    class="ml-2 text-yellow-600 hover:text-yellow-800">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            <?php endif; ?>
                                            <button onclick="deleteFile(<?= $file['id'] ?>)"
                                                class="ml-2 text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">No files uploaded yet.</td>
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

    <!-- Message Modal -->
    <div id="messageModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div id="send_message_des" class="bg-white rounded-lg shadow-lg p-8 mx-96">
            <h2 class="text-2xl font-semibold mb-6 text-gray-800">Send a Message</h2>
            <form class="" method="post" action="<?= base_url('conAdmin/sendMessage') ?>">
                <input type="hidden" id="modalUserId" name="user_id">
                <textarea name="message" rows="6"
                    class="form-textarea mt-1 block w-full border border-gray-300 rounded-md p-4 text-gray-700"
                    placeholder="Enter message here"></textarea>
                <div class="mt-3 justify-between flex">

                    <button type="submit"
                        class="text-green-800 bg-green-200 hover:bg-green-400 py-2 px-4 rounded font-medium transition-all duration-300">
                        Send Message
                    </button>
                    <button onclick="closeMessageModal()"
                        class="bg-yellow-200 text-yellow-800 py-2 px-4 rounded hover:bg-yellow-400">Close</button>
                </div>

            </form>
        </div>
    </div>


    <script>
        // Function to open the message modal
        function openMessageModal(userId) {
            document.getElementById('modalUserId').value = userId;
            document.getElementById('messageModal').classList.remove('hidden');
        }

        // Function to close the message modal
        function closeMessageModal() {
            document.getElementById('messageModal').classList.add('hidden');
        }

        // Function to toggle the visibility of the user's files
        function toggleFiles(userId) {
            document.querySelectorAll('.user-files-' + userId).forEach(row => {
                row.classList.toggle('hidden');
            });
        }

        // Function to select/deselect all files for a specific user
        function toggleUserFiles(userId) {
            const isChecked = document.querySelector(`.select-user-checkbox[data-user-id="${userId}"]`).checked;
            document.querySelectorAll(`.user-${userId}`).forEach(checkbox => {
                checkbox.checked = isChecked;
            });
        }

        // Function to select/deselect all files
        function toggleSelectAll() {
            const isChecked = document.getElementById('selectAll').checked;
            document.querySelectorAll('.file-checkbox').forEach(checkbox => {
                checkbox.checked = isChecked;
            });
        }
    </script>


    <script>
        function filterFiles(category) {
            // Get all the table rows
            const rows = document.querySelectorAll('#filesTable tr');

            // Loop through each row and apply the filter
            rows.forEach(row => {
                const categoryCell = row.querySelector('td:nth-child(5)'); // Get the category cell (5th column)

                if (!categoryCell) return; // Skip if there's no category cell (e.g., empty rows)

                const fileCategory = categoryCell.textContent.trim().toLowerCase();

                if (category === 'All' || fileCategory === category.toLowerCase()) {
                    row.style.display = ''; // Show the row
                } else {
                    row.style.display = 'none'; // Hide the row
                }
            });
        }

    </script>

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