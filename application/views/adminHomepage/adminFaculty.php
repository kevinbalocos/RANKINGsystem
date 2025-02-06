<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN FACULTY</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
            max-width: 350px;
        }

        th,
        td {
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="bg-white shadow px-6 py-3">
        <h1 class="text-2xl font-bold text-gray-800">FACULTY</h1>
    </header>

    <div class="main-container">
        <!-- Left Section -->
        <div class="left-section space-y-6">
            <div class="bg-white shadow-lg rounded-lg p-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-xs font-semibold text-gray-600 uppercase">
                                <input type="checkbox" id="select-all" onchange="toggleSelectAll()">
                            </th>
                            <th class="px-4 py-2 text-xs font-semibold text-gray-600 uppercase">Username</th>
                            <th class="px-4 py-2 text-xs font-semibold text-gray-600 uppercase">Rank</th>
                            <th class="px-4 py-2 text-xs font-semibold text-gray-600 uppercase">Faculty</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($users as $user): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 text-sm text-gray-800">
                                    <input type="checkbox" class="user-checkbox" value="<?= $user['id']; ?>"
                                        onchange="toggleUserSelection(this)">
                                </td>

                                <td class="px-4 py-2 text-sm text-gray-800"><?= htmlspecialchars($user['username']); ?></td>
                                <!-- <td class="px-4 py-2 text-sm text-gray-800">
                                    <select name="rank" class="border border-gray-300 rounded-md px-2 py-1"
                                        onchange="updateRank(<?= $user['id']; ?>, this.value)">
                                        <option value="">-- Select Rank --</option>
                                        <?php foreach ($ranks as $rank): ?>
                                            <option value="<?= $rank['name']; ?>" <?= $user['rank'] == $rank['name'] ? 'selected' : ''; ?>>
                                                <?= $rank['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td> -->
                                <td class="px-4 py-2 text-sm text-gray-800">
                                    <?= !empty($user['rank']) ? htmlspecialchars($user['rank']) : '<span class="text-gray-500">No Rank</span>'; ?>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-800">
                                    <select name="faculty" class="border border-gray-300 rounded-md px-2 py-1"
                                        onchange="updateFaculty(<?= $user['id']; ?>, this.value)">
                                        <option value="">-- Select Faculty --</option>
                                        <?php foreach ($faculties as $faculty): ?>
                                            <option value="<?= $faculty['name']; ?>" <?= $user['faculty'] == $faculty['name'] ? 'selected' : ''; ?>>
                                                <?= $faculty['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Right Section -->
        <div class="right-section bg-white border-l px-6 py-6 space-y-6">
            <!-- Section Title -->
            <h3 class="text-lg font-semibold text-gray-800 mb-6">Quick Actions</h3>

            <!-- Two-Column Layout for Cards -->
            <div class="grid grid-cols-1 gap-6">
                <!-- 
            <div class="bg-white shadow-lg rounded-lg p-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Add Rank</h4>
                    <form id="add-rank-form" class="space-y-4">
                        <input type="text"
                            class="w-full px-1 py-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:outline-none"
                            id="rank" name="rank" placeholder="Enter new rank" required>
                        <button
                            class="w-full px-1 py-1 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition duration-150"
                            type="submit">Add Rank</button>
                    </form>
                </div>

                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Add Faculty</h4>
                    <form id="add-faculty-form" class="space-y-4">
                        <input type="text"
                            class="w-full px-1 py-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:outline-none"
                            id="faculty" name="faculty" placeholder="Enter new faculty" required>
                        <button
                            class="w-full px-1 py-1 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition duration-150"
                            type="submit">Add Faculty</button>
                    </form>
                </div> -->


                <!-- Card: Bulk Actions -->
                <div class="bg-white shadow-lg rounded-lg p-6 space-y-6">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Bulk Actions</h4>

                    <!-- Assign Rank -->
                    <div class="space-y-4">
                        <select id="bulk-rank"
                            class="w-full px-1 py-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:outline-none">
                            <option value="">-- Select Rank --</option>
                            <?php foreach ($ranks as $rank): ?>
                                <option value="<?= $rank['name']; ?>"><?= $rank['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button
                            class="w-full px-1 py-1 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition duration-150"
                            onclick="bulkAssignRank()">
                            Assign Rank
                        </button>
                    </div>

                    <!-- Assign Faculty -->
                    <div class="space-y-4">
                        <select id="bulk-faculty"
                            class="w-full px-1 py-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:outline-none">
                            <option value="">-- Select Faculty --</option>
                            <?php foreach ($faculties as $faculty): ?>
                                <option value="<?= $faculty['name']; ?>"><?= $faculty['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button
                            class="w-full px-1 py-1 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition duration-150"
                            onclick="bulkAssignFaculty()">
                            Assign Faculty
                        </button>
                    </div>

                    <!-- Remove Rank -->
                    <button
                        class="w-full px-1 py-1 bg-gray-600 text-white rounded-lg hover:bg-gray-500 transition duration-150"
                        onclick="bulkRemoveRank()">
                        Remove Rank
                    </button>

                    <!-- Remove Faculty -->
                    <button
                        class="w-full px-1 py-1 bg-gray-600 text-white rounded-lg hover:bg-gray-500 transition duration-150"
                        onclick="bulkRemoveFaculty()">
                        Remove Faculty
                    </button>
                </div>

                <!-- Card: Delete Rank -->
                <!-- <div class="bg-white shadow-lg rounded-lg p-6">
                    <h4 class="text-sm font-medium text-gray-700 mt-5 mb-2">Delete Rank</h4>
                    <select id="delete-rank"
                        class="w-full px-1 py-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:outline-none mb-2">
                        <option value="">-- Select Rank --</option>
                        <?php foreach ($ranks as $rank): ?>
                            <option value="<?= $rank['id']; ?>"><?= $rank['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button
                        class="w-full px-1 py-1 bg-gray-600 text-white rounded-lg hover:bg-gray-500 transition duration-150"
                        onclick="deleteRank()">
                        Delete Rank
                    </button>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Delete Faculty</h4>
                    <select id="delete-faculty"
                        class="w-full px-1 py-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:outline-none mb-2">
                        <option value="">-- Select Faculty --</option>
                        <?php foreach ($faculties as $faculty): ?>
                            <option value="<?= $faculty['id']; ?>"><?= $faculty['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button
                        class="w-full px-1 py-1 bg-gray-600 text-white rounded-lg hover:bg-gray-500 transition duration-150"
                        onclick="deleteFaculty()">
                        Delete Faculty
                    </button>
                </div> -->


            </div>
        </div>
        <script>
            function deleteRank() {
                const selectedRankId = document.getElementById('delete-rank').value;

                if (selectedRankId) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to delete this rank!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('<?= base_url('controllerFaculty/deleteRank'); ?>', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({ rank_id: selectedRankId })
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire('Success!', 'Rank deleted successfully!', 'success')
                                            .then(() => {
                                                location.reload();  // Reload page after successful action
                                            });
                                    } else {
                                        Swal.fire('Error!', 'Failed to delete rank.', 'error');
                                    }
                                });
                        }
                    });
                } else {
                    Swal.fire('Warning!', 'Please select a rank to delete.', 'warning');
                }
            }

            function deleteFaculty() {
                const selectedFacultyId = document.getElementById('delete-faculty').value;

                if (selectedFacultyId) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to delete this faculty!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('<?= base_url('controllerFaculty/deleteFaculty'); ?>', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({ faculty_id: selectedFacultyId })
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire('Success!', 'Faculty deleted successfully!', 'success')
                                            .then(() => {
                                                location.reload();  // Reload page after successful action
                                            });
                                    } else {
                                        Swal.fire('Error!', 'Failed to delete faculty.', 'error');
                                    }
                                });
                        }
                    });
                } else {
                    Swal.fire('Warning!', 'Please select a faculty to delete.', 'warning');
                }
            }
        </script>
    </div>
    </div>

    </div>


    <!-- Add SweetAlert2 CSS and JS in your head section -->

    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <script>
        let selectedUsers = [];

        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.user-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
                toggleUserSelection(checkbox);
            });
        }

        function toggleUserSelection(checkbox) {
            const userId = checkbox.value;

            if (checkbox.checked) {
                if (!selectedUsers.includes(userId)) {
                    selectedUsers.push(userId);
                }
            } else {
                const index = selectedUsers.indexOf(userId);
                if (index !== -1) {
                    selectedUsers.splice(index, 1);
                }
            }
        }

        function bulkRemoveRank() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to remove the rank for selected users!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('<?= base_url('controllerFaculty/bulkRemoveRank'); ?>', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ user_ids: selectedUsers })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Success!', 'Ranks removed successfully!', 'success')
                                    .then(() => {
                                        location.reload();  // Reload page after successful action
                                    });
                            } else {
                                Swal.fire('Error!', 'Failed to remove ranks.', 'error');
                            }
                        });
                }
            });
        }

        function bulkRemoveFaculty() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to remove the faculty for selected users!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('<?= base_url('controllerFaculty/bulkRemoveFaculty'); ?>', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ user_ids: selectedUsers })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Success!', 'Faculties removed successfully!', 'success')
                                    .then(() => {
                                        location.reload();  // Reload page after successful action
                                    });
                            } else {
                                Swal.fire('Error!', 'Failed to remove faculties.', 'error');
                            }
                        });
                }
            });
        }

        function bulkAssignRank() {
            const selectedRank = document.getElementById('bulk-rank').value;

            if (selectedRank && selectedUsers.length > 0) {
                fetch('<?= base_url('controllerFaculty/bulkAssignRank'); ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ user_ids: selectedUsers, rank: selectedRank })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Success!', 'Ranks assigned successfully!', 'success')
                                .then(() => {
                                    location.reload();  // Reload page after successful action
                                });
                        } else {
                            Swal.fire('Error!', 'Failed to assign ranks.', 'error');
                        }
                    });
            } else {
                Swal.fire('Warning!', 'Please select a rank and at least one user.', 'warning');
            }
        }

        function bulkAssignFaculty() {
            const selectedFaculty = document.getElementById('bulk-faculty').value;

            if (selectedFaculty && selectedUsers.length > 0) {
                fetch('<?= base_url('controllerFaculty/bulkAssignFaculty'); ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ user_ids: selectedUsers, faculty: selectedFaculty })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Success!', 'Faculties assigned successfully!', 'success')
                                .then(() => {
                                    location.reload();  // Reload page after successful action
                                });
                        } else {
                            Swal.fire('Error!', 'Failed to assign faculties.', 'error');
                        }
                    });
            } else {
                Swal.fire('Warning!', 'Please select a faculty and at least one user.', 'warning');
            }
        }


        function updateRank(userId, rank) {
            fetch('<?= base_url('controllerFaculty/updateRank'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ user_id: userId, rank: rank })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Success!', 'Rank updated successfully!', 'success');
                    } else {
                        Swal.fire('Error!', 'Failed to update rank.', 'error');
                    }
                })
                .catch(error => Swal.fire('Error!', 'An error occurred.', 'error'));
        }

        function updateFaculty(userId, faculty) {
            fetch('<?= base_url('controllerFaculty/updateFaculty'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ user_id: userId, faculty: faculty })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Success!', 'Faculty updated successfully!', 'success');
                    } else {
                        Swal.fire('Error!', 'Failed to update faculty.', 'error');
                    }
                })
                .catch(error => Swal.fire('Error!', 'An error occurred.', 'error'));
        }

    </script>
    <script>
        // Handle Add Rank Form Submission
        // Handle Add Rank Form Submission
        document.getElementById('add-rank-form').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent form from submitting normally
            let rank = document.getElementById('rank').value;

            // Make AJAX request to add rank
            fetch('<?= base_url('controllerFaculty/addRank'); ?>', {
                method: 'POST',
                body: new URLSearchParams({ 'rank': rank })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Success', data.message, 'success')
                            .then(() => {
                                location.reload(); // Reload page after success
                            });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'An error occurred. Please try again.', 'error');
                });
        });

        // Handle Add Faculty Form Submission
        document.getElementById('add-faculty-form').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent form from submitting normally
            let faculty = document.getElementById('faculty').value;

            // Make AJAX request to add faculty
            fetch('<?= base_url('controllerFaculty/addFaculty'); ?>', {
                method: 'POST',
                body: new URLSearchParams({ 'faculty': faculty })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Success', data.message, 'success')
                            .then(() => {
                                location.reload(); // Reload page after success
                            });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'An error occurred. Please try again.', 'error');
                });
        });


    </script>
</body>

</html>