<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN USER REQUIREMENTS</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/javascripts/UserUploadedFiles.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

</head>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        height: 100vh;
        display: flex;
        flex-direction: column;
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

    .pagination {
        display: flex;
        justify-content: flex-end;
    }
</style>

<body>



    <div class="main-container">
        <div class="left-section bg-white shadow-lg rounded-lg p-6 space-y-6">

            <!-- Add File Type Form -->
            <div>
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Add File Type</h2>
                <form id="addFileTypeForm" class="space-y-4">

                    <div>
                        <label class="block text-gray-600 font-medium">Category</label>
                        <select name="category"
                            class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                            <option value="General">General</option>
                            <option value="Mandatory">Mandatory</option>
                            <option value="Yearly">Yearly</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-600 font-medium">File Type Name</label>
                        <input type="text" name="type_name" required
                            class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="block text-gray-600 font-medium">Points</label>
                        <input type="number" name="points" required
                            class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                    </div>

                    <button type="button" onclick="addFileType()"
                        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                        Add File Type
                    </button>
                </form>
            </div>

            <!-- Pending File Types -->
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Pending File Types</h3>
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="p-2 border">File Type</th>
                            <th class="p-2 border">Category</th>
                            <th class="p-2 border">Points</th>
                            <th class="p-2 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending_file_types as $type): ?>
                            <tr class="text-center border-t hover:bg-gray-50">
                                <td class="p-2"><?= htmlspecialchars(str_replace('_', ' ', $type['type_name'])) ?></td>
                                <td class="p-2"><?= htmlspecialchars($type['category']) ?></td>
                                <td class="p-2"><?= htmlspecialchars($type['points']) ?></td>
                                <td class="p-2 space-x-2">
                                    <button onclick="updateFileTypeStatus(<?= $type['id'] ?>, 'approved')"
                                        class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">
                                        Approve
                                    </button>
                                    <button onclick="deleteFileType(<?= $type['id'] ?>)"
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Approved File Types -->
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Approved File Types</h3>
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="p-2 border">File Type</th>
                            <th class="p-2 border">Category</th>
                            <th class="p-2 border">Points</th>
                            <th class="p-2 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($approved_file_types as $type): ?>
                            <tr class="text-center border-t hover:bg-gray-50">
                                <td class="p-2"><?= htmlspecialchars(str_replace('_', ' ', $type['type_name'])) ?></td>
                                <td class="p-2"><?= htmlspecialchars($type['category']) ?></td>
                                <td class="p-2"><?= htmlspecialchars($type['points']) ?></td>
                                <td class="p-2">
                                    <button onclick="updateFileTypeStatus(<?= $type['id'] ?>, 'pending')"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">
                                        Remove from Approved
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>

        <script>
            function addFileType() {
                var formData = new FormData(document.getElementById("addFileTypeForm"));

                fetch("<?= base_url('conAdmin/addFileType') ?>", {
                    method: "POST",
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        if (data.status === "success") {
                            location.reload(); // Reload the page to show new file types
                        }
                    })
                    .catch(error => console.error("Error:", error));
            }
        </script>

        <div class="right-section bg-white shadow-lg rounded-lg p-6 space-y-6">

            <!-- Section Title -->
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Users and Approved File Types</h3>

            <!-- User Data Table -->
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="p-2 border">User ID</th>
                            <th class="p-2 border">Username</th>
                            <th class="p-2 border">Approved File Types</th>
                            <th class="p-2 border">Uploaded Files</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr class="text-center border-t hover:bg-gray-50">
                                <!-- User ID -->
                                <td class="p-2"><?= htmlspecialchars($user['user_id']) ?></td>

                                <!-- Username -->
                                <td class="p-2 font-semibold text-gray-800"><?= htmlspecialchars($user['username']) ?></td>

                                <!-- Approved File Types -->
                                <td class="p-2">
                                    <ul class="list-disc list-inside text-gray-700 text-sm">
                                        <?php foreach ($approved_file_types as $type): ?>
                                            <li><?= htmlspecialchars($type['type_name']) ?>
                                                (<?= htmlspecialchars($type['category']) ?>)
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>

                                <!-- Uploaded Files -->
                                <td class="p-2">
                                    <ul class="list-disc list-inside text-gray-700 text-sm">
                                        <?php foreach ($user['uploaded_files'] as $file): ?>
                                            <li>
                                                <span class="font-medium"><?= htmlspecialchars($file['file_name']) ?></span>
                                                - <span class="text-gray-500"><?= htmlspecialchars($file['status']) ?></span>
                                                <?php
                                                $file_type = $this->db->get_where('file_types', ['type_name' => $file['file_type']])->row_array();
                                                if ($file_type) {
                                                    echo ' - <span class="text-blue-500">Points: ' . htmlspecialchars($file_type['points']) . '</span>';
                                                }
                                                ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>





    <script>
        function updateFileTypeStatus(id, status) {
            fetch("<?= base_url('conAdmin/updateFileTypeStatus') ?>", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "id=" + id + "&status=" + status
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.status === "success") {
                        location.reload(); // Reload the page to reflect the changes
                    }
                })
                .catch(error => console.error("Error:", error));
        }

    </script>

    <script>
        function deleteFileType(id) {
            if (!confirm("Are you sure you want to delete this file type?")) {
                return;
            }

            fetch("<?= base_url('conAdmin/deleteFileType') ?>", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "id=" + id
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.status === "success") {
                        location.reload(); // Refresh the page to reflect changes
                    }
                })
                .catch(error => console.error("Error:", error));
        }
    </script>



</body>

</html>