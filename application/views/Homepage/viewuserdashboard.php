<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <style>
        div.approval,
        div.buttons,
        div.file-uploader,
        div.table,
        .grid {
            margin-left: 20px;
        }
    </style>
</head>

<body class="bg-gray-100 p-10">
    <header class="bg-white shadow px-6 py-3">
        <h1 class="text-2xl font-bold text-gray-800">DASHBOARD</h1>
    </header>

    <!-- Approval Progress -->
    <div class="approval bg-white p-6 rounded-lg shadow-md mb-8 mt-8">
        <h3 class="text-xl font-bold mb-4">Approval Progress</h3>
        <div class="w-full bg-gray-200 rounded-full h-6">
            <div class="bg-green-400 h-6 rounded-full text-white text-center text-sm" style="width: <?= $progress ?>%;">
                <?= round($progress, 2) ?>%
            </div>
        </div>
    </div>

    <!-- Dashboard Statistics -->
    <div class="upload grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <h2 class="text-lg font-semibold">Uploaded Files</h2>
            <p class="text-2xl text-blue-500 font-bold"><?= $totalUploaded ?> Files</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <h2 class="text-lg font-semibold">Pending Approval</h2>
            <p class="text-2xl text-yellow-500 font-bold"><?= $pendingFiles ?> Files</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <h2 class="text-lg font-semibold">Approved Files</h2>
            <p class="text-2xl text-green-500 font-bold"><?= $approvedFiles ?> Files</p>
        </div>
    </div>

    <!-- Filter Buttons and Search Bar -->
    <div class="buttons flex justify-between items-center mb-6">
        <div class="flex gap-4">
            <button class="bg-purple-200 px-4 py-2 rounded hover:bg-purple-300 transition filter-btn"
                onclick="filterFiles('All')">All Files</button>
            <button class="bg-green-200 px-4 py-2 rounded hover:bg-green-300 transition filter-btn"
                onclick="filterFiles('Approved')">Approved</button>
            <button class="bg-yellow-200 px-4 py-2 rounded hover:bg-yellow-300 transition filter-btn"
                onclick="filterFiles('Pending')">Pending</button>
            <button class="bg-red-200 px-4 py-2 rounded hover:bg-red-300 transition filter-btn"
                onclick="filterFiles('Denied')">Denied</button>
        </div>
    </div>

    <!-- Upload Section -->
    <div class="file-uploader bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-xl font-bold mb-4">Upload Files</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Requirements File -->
            <form action="<?= base_url('conAdmin/uploadGeneralFile') ?>" method="post" enctype="multipart/form-data"
                class="darkmode bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 ease-in-out"
                onsubmit="handleFileUpload(event, this)">
                <label for="requirements_file" class="block text-sm font-medium text-gray-700 mb-2">Requirements
                    File:</label>
                <div class="relative">
                    <input type="file" name="requirements_file" id="requirements_file" accept=".pdf,.docx,.png,.jpg"
                        class="w-full opacity-0 absolute top-0 left-0 h-full cursor-pointer" required>
                    <button type="button"
                        class="w-full border border-gray-300 rounded-lg py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 transition flex items-center justify-center">
                        <span class="mr-2">CORE REQUIREMENTS</span>
                    </button>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <button type="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-300 transition">Upload</button>
                    <button type="button" class="bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400 transition"
                        onclick="resetFileInput('requirements_file')">Clear</button>
                </div>
            </form>

            <!-- SSS File -->
            <form action="<?= base_url('conAdmin/uploadSSSFile') ?>" method="post" enctype="multipart/form-data"
                onsubmit="handleFileUpload(event, this, 'SSS File Uploaded Successfully!');"
                class="darkmode bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 ease-in-out">
                <label for="sss_file" class="block text-sm font-medium text-gray-700 mb-2">SSS File:</label>
                <div class="relative">
                    <input type="file" name="sss_file" id="sss_file" accept=".pdf,.docx,.png,.jpg"
                        class="w-full opacity-0 absolute top-0 left-0 h-full cursor-pointer" required>
                    <button type="button"
                        class="w-full border border-gray-300 rounded-lg py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 transition flex items-center justify-center">
                        <span class="mr-2">SSS</span>
                    </button>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <button type="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-300 transition">Upload</button>
                    <button type="button" class="bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400 transition"
                        onclick="resetFileInput('sss_file')">Clear</button>
                </div>
            </form>

            <!-- PAGIBIG File -->
            <form action="<?= base_url('conAdmin/uploadPagibigFile') ?>" method="post" enctype="multipart/form-data"
                onsubmit="handleFileUpload(event, this, 'PAGIBIG File Uploaded Successfully!');"
                class="darkmode bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 ease-in-out">
                <label for="pagibig_file" class="block text-sm font-medium text-gray-700 mb-2">PAGIBIG File:</label>
                <div class="relative">
                    <input type="file" name="pagibig_file" id="pagibig_file" accept=".pdf,.docx,.png,.jpg"
                        class="w-full opacity-0 absolute top-0 left-0 h-full cursor-pointer" required>
                    <button type="button"
                        class="w-full border border-gray-300 rounded-lg py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 transition flex items-center justify-center">
                        <span class="mr-2">PAGIBIG</span>
                    </button>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <button type="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-300 transition">Upload</button>
                    <button type="button" class="bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400 transition"
                        onclick="resetFileInput('pagibig_file')">Clear</button>
                </div>
            </form>


        </div>
    </div>


    <!-- User Uploaded Files -->
    <div class="table bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4">User Uploaded Files</h2>
        <table class="table-auto w-full text-left text-gray-700">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3">File Name</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody id="files-table-body">
                <?php if (!empty($uploaded_files)): ?>
                    <?php foreach ($uploaded_files as $file): ?>
                        <tr class="file-row border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-3"><?= htmlspecialchars($file['file_name']) ?></td>
                            <td class="px-4 py-3"><?= ucfirst(htmlspecialchars($file['file_type'])) ?></td>
                            <td class="px-4 py-3"><?= ucfirst(htmlspecialchars($file['status'])) ?></td>
                            <td class="px-4 py-3">
                                <a href="<?= base_url(htmlspecialchars($file['file_path'])) ?>"
                                    class="bg-green-500 text-white px-4 py-2 rounded">Download</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center py-3 text-gray-500">No files uploaded yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        function resetFileInput(inputId) {
            document.getElementById(inputId).value = '';
        }

        function filterFiles(status) {
            const rows = document.querySelectorAll('.file-row');
            rows.forEach(row => {
                const fileStatus = row.cells[2].textContent.trim(); // Get status from the third column (Status)
                if (status === 'All' || fileStatus === status) {
                    row.style.display = ''; // Show row
                } else {
                    row.style.display = 'none'; // Hide row
                }
            });
        }


    </script>

    <script>
        // Function to show Toastify notification
        function showToast(message, isError = false) {
            Toastify({
                text: message,
                style: {
                    background: isError ? "linear-gradient(to right, #FF5C8D, #FF8364)" : "linear-gradient(to right, #00b09b, #96c93d)", // Error is red, success is green
                    color: "white",
                    fontSize: "14px",
                    fontWeight: "bold",
                    padding: "10px 20px",
                    borderRadius: "5px",
                },
                duration: 3000, // Duration in milliseconds
                gravity: "top", // Position
                position: "right", // Right side
                className: "custom-toastify",
            }).showToast();
        }

        // Function to validate file name length
        function validateFileNameLength(inputId) {
            const fileInput = document.getElementById(inputId);
            const fileName = fileInput.files[0]?.name;

            if (fileName && fileName.length > 30) {
                showToast('File name exceeds the 30 character limit.', true);
                fileInput.value = ''; // Clear the file input
                return false;
            }
            return true;
        }

        // Attach the validation function to the form submit event
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function (event) {
                const inputId = form.querySelector('input[type="file"]').id;
                if (!validateFileNameLength(inputId)) {
                    event.preventDefault(); // Prevent form submission if file name is too long
                }
            });
        });
    </script>
    <script>
        // Function to reset the file input field and show toast
        function resetFileInput(inputId) {
            const fileInput = document.getElementById(inputId);
            const currentFile = fileInput.files[0]; // Get the current file

            if (currentFile) {
                // If a file is selected, clear it and show a success toast
                fileInput.value = '';
                showToast("Cleared current file!", false);
            } else {
                // If no file is selected, show a message that there's no file
                showToast("There's no file yet.", true);
            }
        }

        // Function to show Toastify notification
        function showToast(message, isError = false) {
            Toastify({
                text: message,
                style: {
                    background: isError ? "linear-gradient(to right, #FF5C8D, #FF8364)" : "linear-gradient(to right, #00b09b,rgb(0, 160, 189))", // Error is red, success is green
                    color: "white",
                    fontSize: "14px",
                    fontWeight: "bold",
                    padding: "10px 20px",
                    borderRadius: "5px",
                },
                duration: 3000, // Duration in milliseconds
                gravity: "top", // Position
                position: "right", // Right side
                className: "custom-toastify",
            }).showToast();
        }

    </script>
    <script>
        // Handle File Upload with AJAX and Toast
        function handleFileUpload(event, form, successMessage) {
            event.preventDefault(); // Prevent default form submission
            const formData = new FormData(form); // Create a FormData object

            // Perform AJAX request
            fetch(form.action, {
                method: 'POST',
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === 'success') {
                        showToast(successMessage, false); // Show success toast
                        form.reset(); // Reset the form after successful upload
                    } else {
                        showToast(data.message || 'An error occurred during upload.', true); // Show error toast
                    }
                })
                .catch((error) => {
                    showToast('An error occurred. Please try again.', true); // Show error toast for unexpected errors
                });
        }

        // Function to reset file input
        function resetFileInput(inputId) {
            const fileInput = document.getElementById(inputId);
            if (fileInput.files.length > 0) {
                fileInput.value = ''; // Clear file input
                showToast('File input cleared.', false); // Show toast for clearing
            } else {
                showToast('No file to clear.', true); // Show error toast if no file is selected
            }
        }


        // Show Toastify notification
        function showToast(message, isError = false) {
            Toastify({
                text: message,
                style: {
                    background: isError ? "linear-gradient(to right, #FF5C8D, #FF8364)" : "linear-gradient(to right, #00b09b, #96c93d)", // Error is red, success is green
                    color: "white",
                    fontSize: "14px",
                    fontWeight: "bold",
                    padding: "10px 20px",
                    borderRadius: "5px",
                },
                duration: 3000, // Duration in milliseconds
                gravity: "top", // Position
                position: "right", // Right side
            }).showToast();
        }

    </script>
</body>

</html>