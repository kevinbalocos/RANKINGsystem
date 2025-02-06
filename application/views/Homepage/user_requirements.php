<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USER REQUIREMENTS</title>
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








    <!-- <header class="bg-white shadow px-6 py-3">
        <h1 class="darkmode_h1 text-2xl font-bold text-gray-700 uppercase tracking-wider">USER REQUIREMENTS
        </h1>
    </header>
 -->


    <!-- Approval Progress -->
    <!-- <div class="approval bg-white p-6 rounded-lg shadow-md mb-8 mt-8">
        <h3 class="text-xl font-bold mb-4">Approval Progress</h3>
        <div class="w-full bg-gray-200 rounded-full h-6">
            <div class="bg-green-400 h-6 rounded-full text-white text-center text-sm" style="width: <?= $progress ?>%;">
                <?= round($progress, 2) ?>%
            </div>
        </div>
    </div> -->

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- General File Progress -->
        <div class="approval bg-white p-6 rounded-lg shadow-md mb-8 mt-8">
            <h3 class="px-6 py-3 text-left text-xl font-semibold text-gray-700 uppercase tracking-wider">General File
                Approval Progress</h3>
            <div class="w-full bg-gray-200 rounded-full h-6">
                <div class="bg-green-400 h-6 rounded-full text-white text-center text-sm"
                    style="width: <?= $generalProgress ?>%;">
                    <?= round($generalProgress, 2) ?>%
                </div>
            </div>
        </div>

        <!-- Mandatory File Progress -->
        <div class="approval bg-white p-6 rounded-lg shadow-md mb-8 mt-8">
            <h3 class="px-6 py-3 text-left text-xl font-semibold text-gray-700 uppercase tracking-wider">Mandatory File
                Approval Progress</h3>
            <div class="w-full bg-gray-200 rounded-full h-6">
                <div class="bg-green-400 h-6 rounded-full text-white text-center text-sm"
                    style="width: <?= $mandatoryProgress ?>%;">
                    <?= round($mandatoryProgress, 2) ?>%
                </div>
            </div>
        </div>

        <!-- Yearly File Progress -->
        <div class="approval bg-white p-6 rounded-lg shadow-md mb-8 mt-8">
            <h3 class="px-6 py-3 text-left text-xl font-semibold text-gray-700 uppercase tracking-wider">Yearly File
                Approval Progress</h3>
            <div class="w-full bg-gray-200 rounded-full h-6">
                <div class="bg-green-400 h-6 rounded-full text-white text-center text-sm"
                    style="width: <?= $yearlyProgress ?>%;">
                    <?= round($yearlyProgress, 2) ?>%
                </div>
            </div>
        </div>
    </div>




    <!-- Upload Section -->
    <div class="file-uploader bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="px-6 py-3 text-left text-xl font-semibold text-gray-700 uppercase tracking-wider">Upload Files</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- General File Upload Form -->
            <form action="<?= base_url('conAdmin/uploadGeneralFile') ?>" method="post" enctype="multipart/form-data"
                class="darkmode bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 ease-in-out"
                onsubmit="handleFileUpload(event, this)">

                <label for="file_type" class="block text-sm font-medium text-gray-700 mb-2">Select File Type:</label>
                <div class="relative mb-4">
                    <select name="file_type" class="w-full border border-gray-300 rounded-lg py-3 text-gray-700"
                        required>
                        <?php if (!empty($general_file_types)): ?>
                            <?php foreach ($general_file_types as $file): ?>
                                <option value="<?= strtolower($file['type_name']) ?>">

                                    <?= strtoupper($file['type_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled selected>File Type is Empty</option>
                        <?php endif; ?>
                    </select>

                </div>

                <label for="requirements_file" class="block text-sm font-medium text-gray-700 mb-2">Select File:</label>
                <div class="relative">
                    <input type="file" name="requirements_file" id="requirements_file" accept=".pdf,.docx,.png,.jpg"
                        class="w-full opacity-0 absolute top-0 left-0 h-full cursor-pointer" required
                        onchange="updateFileName(this, 'fileNameText')">

                    <button type="button"
                        class="w-full border border-gray-300 rounded-lg py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 transition flex items-center justify-center">
                        <span id="fileNameText" class="mr-2">Choose File</span>
                    </button>
                </div>

                <div class="flex justify-between items-center mt-4">
                    <button type="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-300 transition">Upload</button>
                    <button type="button" class="bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400 transition"
                        onclick="resetFileInput('requirements_file', 'fileNameText')">Clear</button>
                </div>
            </form>



            <!-- Mandatory Requirements Upload Form -->
            <form
                class="darkmode bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 ease-in-out"
                action="<?= base_url('conAdmin/uploadMandatoryRequirementFile') ?>" method="post"
                enctype="multipart/form-data" onsubmit="handleFileUpload(event, this)">

                <label class="block text-sm font-medium text-gray-700 mb-2">Select Mandatory Requirement:</label>
                <div class="relative mb-4">
                    <select name="file_type" class="w-full border border-gray-300 rounded-lg py-3 text-gray-700">
                        <?php if (!empty($mandatory_file_types)): ?>

                            <?php foreach ($mandatory_file_types as $file): ?>
                                <option value="<?= strtolower($file['type_name']) ?>">

                                    <?= strtoupper($file['type_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled selected>File Type is Empty</option>
                        <?php endif; ?>
                    </select>

                </div>

                <label class="block text-sm font-medium text-gray-700 mb-2">Upload File:</label>
                <div class="relative">
                    <input type="file" name="requirements" id="mandatory_requirements_file"
                        accept=".pdf,.docx,.png,.jpg" required
                        class="w-full opacity-0 absolute top-0 left-0 h-full cursor-pointer"
                        onchange="updateFileName(this, 'mandatory_file_name')">
                    <button type="button"
                        class="w-full border border-gray-300 rounded-lg py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 transition flex items-center justify-center">
                        <span id="mandatory_file_name" class="mr-2">Choose File</span>
                    </button>

                </div>

                <div class="flex justify-between items-center mt-4">
                    <button type="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-300 transition">Upload</button>
                    <button type="button" class="bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400 transition"
                        onclick="resetFileInput('mandatory_requirements_file', 'mandatory_file_name')">Clear</button>
                </div>
            </form>

            <!-- Yearly Requirements Upload Form -->
            <form
                class="darkmode bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 ease-in-out"
                action="<?= base_url('conAdmin/uploadYearlyFile') ?>" method="post" enctype="multipart/form-data"
                onsubmit="handleFileUpload(event, this)">

                <label class="block text-sm font-medium text-gray-700 mb-2">Select Yearly Requirement:</label>
                <div class="relative mb-4">
                    <select name="file_type" class="w-full border border-gray-300 rounded-lg py-3 text-gray-700">
                        <?php if (!empty($yearly_file_types)): ?>

                            <?php foreach ($yearly_file_types as $file): ?>
                                <option value="<?= strtolower($file['type_name']) ?>">

                                    <?= strtoupper($file['type_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled selected>File Type is Empty</option>
                        <?php endif; ?>
                    </select>


                </div>

                <label class="block text-sm font-medium text-gray-700 mb-2">Upload File:</label>
                <div class="relative">
                    <input type="file" name="requirements" id="yearly_requirements_file" accept=".pdf,.docx,.png,.jpg"
                        required class="w-full opacity-0 absolute top-0 left-0 h-full cursor-pointer"
                        onchange="updateFileName(this, 'yearly_file_name')">
                    <button type="button"
                        class="w-full border border-gray-300 rounded-lg py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 transition flex items-center justify-center">
                        <span id="yearly_file_name" class="mr-2">Choose File</span>
                    </button>

                </div>

                <div class="flex justify-between items-center mt-4">
                    <button type="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-300 transition">Upload</button>
                    <button type="button" class="bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400 transition"
                        onclick="resetFileInput('yearly_requirements_file', 'yearly_file_name')">Clear</button>
                </div>
            </form>


        </div>
    </div>

    <script>
        // Handle File Upload with AJAX and Toast
        function handleFileUpload(event, form) {
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
                        showToast(data.message, false); // Show success toast
                        form.reset(); // Reset the form after successful upload
                    } else {
                        showToast(data.message || 'An error occurred during upload.', true); // Show error toast
                    }
                })
                .catch((error) => {
                    showToast('An error occurred. Please try again.', true); // Show error toast for unexpected errors
                });

            // Reload the page after Toastify finishes
            setTimeout(function () {
                location.reload(); // Reload the page
            }, 2000); // 3000ms delay (the duration of the toast)
        }



    </script>



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

    <!-- User Uploaded Files -->
    <div class="table bg-white p-6 rounded-lg shadow-md">
        <h2 class="px-6 py-3 text-left text-xl font-semibold text-gray-600 uppercase tracking-wider">User Uploaded Files
        </h2>
        <table class="table-auto w-full text-left text-gray-700">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">File
                        Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Points
                    </th> <!-- New column for points -->
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Category</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date
                        Uploaded</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date
                        Modified</th> <!-- New column for updated_at -->
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody id="files-table-body">
                <?php if (!empty($uploaded_files)): ?>
                    <?php foreach ($uploaded_files as $file): ?>
                        <tr class="file-row border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-3"><?= htmlspecialchars($file['file_name']) ?></td>
                            <td class="px-4 py-3"><?= ucfirst(htmlspecialchars($file['file_type'])) ?></td>
                            <td class="px-4 py-3"><?= htmlspecialchars($file['points']) ?></td> <!-- Display points -->

                            <td class="px-4 py-3">
                                <?php
                                if (strpos($file['file_path'], 'mandatory_requirements') !== false) {
                                    echo '<span class="text-red-500">Mandatory</span>';
                                } elseif (strpos($file['file_path'], 'yearly_requirements') !== false) {
                                    echo '<span class="text-blue-500">Yearly Event</span>';
                                } else {
                                    echo '<span class="text-green-500">Credential</span>';
                                }
                                ?>
                            </td>

                            <td class="px-4  py-3">
                                <?php
                                $statusClass = '';
                                $statusText = ucfirst(htmlspecialchars($file['status']));
                                // Add background and text colors based on status
                                if ($file['status'] == 'pending') {
                                    $statusClass = 'bg-yellow-100 inline-block py-1 px-3 rounded-full text-xs font-semibold text-yellow-800 px-2 py-1'; // Yellow for Pending
                                    $statusText = 'Pending';
                                } elseif ($file['status'] == 'approved') {
                                    $statusClass = 'bg-green-100 inline-block py-1 px-3 rounded-full text-xs font-semibold text-green-800 px-2 py-1'; // Green for Approved
                                    $statusText = 'Approved';
                                } elseif ($file['status'] == 'denied') {
                                    $statusClass = 'bg-red-100 inline-block py-1 px-3 rounded-full text-xs font-semibold text-red-800 px-2 py-1'; // Red for Denied
                                    $statusText = 'Denied';
                                }
                                ?>
                                <span class="<?= $statusClass ?>"><?= $statusText ?></span>
                            </td>
                            <td class="px-4 py-3"><?= date('F j, Y - g:i A', strtotime($file['uploaded_at'])) ?></td>
                            <td class="px-4 py-3">
                                <?php if (empty($file['updated_at'])): ?>
                                    <span class="text-gray-500">Unread</span> <!-- Display "Unread" if updated_at is empty -->
                                <?php else: ?>
                                    <?= date('F j, Y - g:i A', strtotime($file['updated_at'])) ?>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3">
                                <button href="<?= base_url(htmlspecialchars($file['file_path'])) ?>"
                                    class="bg-green-500 text-white px-4 py-2 rounded">Download</button>


                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center py-3 text-gray-500">No files uploaded yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>





    <script>
        function updateFileName(input, fileNameId = 'fileNameText') {
            var fileName = input.files.length > 0 ? input.files[0].name : "Choose File";
            document.getElementById(fileNameId).textContent = fileName;
        }

        function resetFileInput(inputId, fileNameId = 'fileNameText') {
            document.getElementById(inputId).value = ""; // Clear the file input
            document.getElementById(fileNameId).textContent = "Choose File"; // Reset the displayed text
        }



        function resetFileInput(inputId) {
            document.getElementById(inputId).value = '';
        }

        function filterFiles(status) {
            const rows = document.querySelectorAll('.file-row');
            rows.forEach(row => {
                const fileStatus = row.cells[3].textContent.trim(); // Get status from the fourth column (Status)
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
        function resetFileInput(inputId, fileNameId = 'fileNameText') {
            let fileInput = document.getElementById(inputId);
            let newFileInput = document.createElement("input");

            // Copy attributes from original input
            newFileInput.type = "file";
            newFileInput.name = fileInput.name;
            newFileInput.id = fileInput.id;
            newFileInput.accept = fileInput.accept;
            newFileInput.required = fileInput.required;
            newFileInput.className = fileInput.className;
            newFileInput.onchange = fileInput.onchange;

            // Replace the old input with the new one
            fileInput.parentNode.replaceChild(newFileInput, fileInput);

            // Reset displayed file name
            document.getElementById(fileNameId).textContent = "Choose File";

            // Show success message
            showToast("Cleared current file!", false);
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

</body>

</html>