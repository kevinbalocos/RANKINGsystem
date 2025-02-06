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
        height: calc(100vh);
    }

    .left-section,
    .middle-section {
        padding: 1rem;
        margin: 1rem;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .left-section {
        flex: 1.2;
        margin-right: 2rem;
        overflow-y: auto;
    }

    .middle-section {
        flex: 1;
        background-color: #ffffff;
        border-left: 1px solid #e5e7eb;
        overflow-y: auto;
    }

    .right-section {
        background-color: #ffffff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
        border-left: 1px solid #e5e7eb;
        overflow-y: auto;
        height: 100%;
        width: 500px;
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
                <h2 class="px-2 py-3 text-left text-2xl font-bold text-gray-700 uppercase tracking-wider">Add File Type
                </h2>
                <form id="addFileTypeForm" class="space-y-4">

                    <div>
                        <label
                            class="block px-2 text-left text-sm font-semibold text-black uppercase tracking-wider">Category</label>
                        <select name="category"
                            class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-300 ">
                            <option value="General">General</option>
                            <option value="Mandatory">Mandatory</option>
                            <option value="Yearly">Yearly</option>
                        </select>
                    </div>

                    <div>
                        <label
                            class="block px-2 text-left text-sm font-semibold text-black uppercase tracking-wider">File
                            Type Name</label>
                        <input type="text" name="type_name" required
                            class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                    </div>

                    <div>
                        <label
                            class="block px-2 text-left text-sm font-semibold text-black uppercase tracking-wider">Points</label>
                        <input type="number" name="points" required
                            class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                    </div>

                    <button type="button" onclick="addFileType()"
                        class="w-60 bg-green-200 text-green-800 py-2 rounded-lg hover:bg-green-300 transition">
                        Add File Type
                    </button>
                </form>
            </div>

            <!-- Pending File Types -->
            <div>
                <h3 class="px-6 py-3 text-left text-lg font-semibold text-gray-600 uppercase tracking-wider">Pending
                    File Types</h3>
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                File Type</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Category</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Points</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending_file_types as $type): ?>
                            <tr class="text-center border-t hover:bg-gray-50">
                                <td
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <?= htmlspecialchars(str_replace('_', ' ', $type['type_name'])) ?>
                                </td>
                                <td
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <?= htmlspecialchars($type['category']) ?>
                                </td>
                                <td
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <?= htmlspecialchars($type['points']) ?>
                                </td>
                                <td
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider space-x-2">
                                    <button onclick="updateFileTypeStatus(<?= $type['id'] ?>, 'approved')"
                                        class="bg-green-200 text-green-800 px-2 py-1 rounded hover:bg-green-300  transition">
                                        Approve
                                    </button>
                                    <button onclick="deleteFileType(<?= $type['id'] ?>)"
                                        class="bg-red-200 text-red-800 px-3 py-1 rounded hover:bg-red-300  transition">
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
                <h3 class="px-6 py-3 text-left text-lg font-semibold text-gray-600 uppercase tracking-wider">Approved
                    File Types</h3>
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                File Type</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Category</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Points</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($approved_file_types as $type): ?>
                            <tr class="text-center border-t hover:bg-gray-50">
                                <td
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <?= htmlspecialchars(str_replace('_', ' ', $type['type_name'])) ?>
                                </td>
                                <td
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <?= htmlspecialchars($type['category']) ?>
                                </td>
                                <td
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <?= htmlspecialchars($type['points']) ?>
                                </td>
                                <td
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <button onclick="updateFileTypeStatus(<?= $type['id'] ?>, 'pending')"
                                        class="bg-yellow-200 text-yellow-700 py-1 px-2 rounded hover:bg-yellow-300 ">
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

        <div class="middle-section bg-white shadow-lg rounded-lg p-6 space-y-6">
            <h3 class="px-2 py-2 text-left text-2xl font-bold text-gray-700 uppercase tracking-wider">Users & Approved
                File Types</h3>

            <!-- Search Bar -->
            <div class="relative mb-4">
                <input type="text" id="searchInput" placeholder="Search by Username..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                <i class="fas fa-search absolute right-3 top-3 text-gray-500"></i>
            </div>

            <div class="space-y-4" id="userList">
                <?php foreach ($users as $user): ?>
                    <div class="user-card  bg-white border border-gray-200 rounded-lg shadow p-4"
                        data-username="<?= htmlspecialchars(strtolower($user['username'])) ?>">

                        <!-- User Header -->
                        <div class="flex items-center justify-between">
                            <div>
                                <h4
                                    class="px-1 py-1 text-left text-lg font-semibold text-gray-800 uppercase tracking-wider">
                                    <?= htmlspecialchars($user['username']) ?>
                                </h4>
                                <p class="text-sm text-gray-600">User ID: <?= htmlspecialchars($user['user_id']) ?></p>
                            </div>

                            <!-- Expand Button -->
                            <!-- Expand Button -->
                            <button id="toggle-btn-<?= $user['user_id'] ?>" onclick="toggleDetails(<?= $user['user_id'] ?>)"
                                class="flex items-center gap-2 text-gray-700 hover:text-blue-600 transition duration-200 ease-in-out">
                                <span id="toggle-text-<?= $user['user_id'] ?>" class="text-sm font-medium">Expand</span>
                                <svg id="chevron-<?= $user['user_id'] ?>"
                                    class="w-5 h-5 transition-transform duration-300 ease-in-out transform rotate-0"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>


                        </div>

                        <!-- Summary Section -->
                        <div class="mt-3 text-sm text-gray-700 space-x-2">
                            <?php
                            $approved_types_count = count($approved_file_types);
                            $uploaded_files_count = count($user['uploaded_files']);
                            ?>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-md">
                                <?= $approved_types_count ?> File Types
                            </span>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-md">
                                <?= $uploaded_files_count ?> Files
                            </span>
                        </div>

                        <!-- Hidden Details -->
                        <div id="details-<?= $user['user_id'] ?>" class="hidden mt-4 border-t pt-4 space-y-4">
                            <!-- Approved File Types Section -->
                            <div>
                                <h5 class="py-2 px-1 text-left text-small font-semibold  uppercase tracking-wider">
                                    Approved File Types</h5>
                                <ul class="mt-2 space-y-1">
                                    <?php foreach ($approved_file_types as $type): ?>
                                        <li class="flex justify-between items-center p-2 bg-white border rounded-md shadow-sm">
                                            <i class="fas fa-folder text-gray-500 mr-2"></i>
                                            <span class="darkmode_h1 text-gray-700"><?= htmlspecialchars($type['type_name']) ?>
                                                <span
                                                    class="text-sm text-gray-500">(<?= htmlspecialchars($type['category']) ?>)</span>
                                            </span>

                                            <!-- Check if uploaded -->
                                            <?php
                                            $has_uploaded = false;
                                            foreach ($user['uploaded_files'] as $file) {
                                                if ($file['file_type'] == $type['type_name']) {
                                                    $has_uploaded = true;
                                                    break;
                                                }
                                            }
                                            ?>
                                            <?php if (!$has_uploaded): ?>
                                                <button
                                                    onclick="sendNotification(<?= $user['user_id'] ?>, '<?= htmlspecialchars($type['type_name']) ?>')"
                                                    class="text-red-500 hover:text-red-700">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                </button>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <!-- Uploaded Files Section -->
                            <div>
                                <h5 class="py-2 px-1 text-left text-small font-semibold  uppercase tracking-wider">Uploaded
                                    Files</h5>
                                <ul class="mt-2 space-y-1">
                                    <?php
                                    $grouped_files = [];
                                    foreach ($user['uploaded_files'] as $file) {
                                        $grouped_files[$file['file_type']][] = $file['file_name'];
                                    }
                                    ?>
                                    <?php foreach ($grouped_files as $file_type => $files): ?>
                                        <li class="p-2 bg-gray-100 border rounded-md shadow-sm">
                                            <span class="font-medium text-gray-800"><?= htmlspecialchars($file_type) ?></span>
                                            <ul class="ml-4 mt-1 list-disc list-inside text-gray-700 text-sm">
                                                <?php foreach ($files as $file_name): ?>
                                                    <li><?= htmlspecialchars($file_name) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
        <script>
            // Function to filter users based on search input
            document.getElementById('searchInput').addEventListener('input', function () {
                let query = this.value.toLowerCase();
                let userCards = document.querySelectorAll('.user-card');

                userCards.forEach(card => {
                    let username = card.getAttribute('data-username');
                    if (username.includes(query)) {
                        card.style.display = "block";
                    } else {
                        card.style.display = "none";
                    }
                });
            });

            // Function to expand/collapse user details
            function toggleDetails(userId) {
                const details = document.getElementById(`details-${userId}`);
                const chevron = document.getElementById(`chevron-${userId}`);
                const toggleText = document.getElementById(`toggle-text-${userId}`);

                if (details.classList.contains("hidden")) {
                    details.classList.remove("hidden");
                    chevron.classList.add("rotate-180"); // Rotate Down
                    toggleText.textContent = "Collapse"; // Change text to Collapse
                } else {
                    details.classList.add("hidden");
                    chevron.classList.remove("rotate-180"); // Rotate Up
                    toggleText.textContent = "Expand"; // Change text to Expand
                }
            }


        </script>
        <div class="right-section bg-white shadow-lg rounded-lg p-6 space-y-6">



        </div>
    </div>



    <script>function sendNotification(user_id, file_type) {
            fetch("<?= base_url('conAdmin/sendFileNotification') ?>", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "user_id=" + user_id + "&file_type=" + encodeURIComponent(file_type)
            })
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        icon: data.status === "success" ? "success" : "error",
                        title: data.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                })
                .catch(error => console.error("Error:", error));
        }
    </script>

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