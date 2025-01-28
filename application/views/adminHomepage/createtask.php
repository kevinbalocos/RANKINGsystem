<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <link rel="stylesheet"
        href="<?php echo base_url('assets/css/createtask.css?v=' . filemtime('assets/css/createtask.css')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Add SweetAlert2 library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .main-container {
            display: flex;
            height: calc(100vh - 4rem);
            overflow: hidden;
        }

        .left-section {
            flex: 2;
            padding: 1rem;
        }

        .right-section {
            flex: 1;
            background-color: #f9fafb;
            border-left: 1px solid #e5e7eb;
            max-width: 350px;
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            width: 90%;
            max-width: 500px;
        }

        .createtaskborder {
            border: 1px solid #66cdaa;
            transition: border-color 0.3s, background-color 0.3s;
            width: 300px;
            border-radius: 5px;
        }

        .createtaskborder:focus {
            border-color: #66cdaa;
            outline: none;
            background-color: #ffffff;
        }

        .createtaskborder:hover {
            border-color: #a5d6a7;
        }

        /* Custom scrollbar styles */
        .table-container {
            overflow-y: auto;
            /* Enables vertical scrolling */
            max-height: 800px;
            /* Sets the max height for scrolling */
            scrollbar-width: thin;
            /* Firefox: thin scrollbar */
            scrollbar-color: #66cdaa #f1f1f1;
            /* Firefox: scrollbar thumb and track color */
        }

        /* Webkit (Chrome, Safari) scrollbar styles */
        .table-container::-webkit-scrollbar {
            width: 8px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background-color: #66cdaa;
            border-radius: 10px;
        }

        .table-container::-webkit-scrollbar-track {
            background-color: #f1f1f1;
        }

        .border {
            width: 200px;
        }
    </style>

    <script>
        let currentEditingCell = null;

        function makeEditable(element) {
            if (currentEditingCell === element) return;
            if (currentEditingCell) {
                const originalCell = currentEditingCell;
                const originalValue = originalCell.dataset.originalValue;
                originalCell.innerHTML = originalValue;
                currentEditingCell = null;
            }
            currentEditingCell = element;
            element.dataset.originalValue = element.textContent.trim();

            const taskId = element.dataset.taskId;
            const columnType = element.dataset.columnType;
            const currentValue = element.textContent.trim();
            let input;

            if (columnType === 'status') {
                input = document.createElement('select');
                const options = ['Not Started', 'In Progress', 'Completed'];
                options.forEach(option => {
                    const opt = document.createElement('option');
                    opt.value = option;
                    opt.textContent = option;
                    if (option === currentValue) {
                        opt.selected = true;
                    }
                    input.appendChild(opt);
                });
            } else {
                input = document.createElement('input');
                input.type = columnType === 'due_date' ? 'date' : 'text';
                input.value = currentValue;
                input.className = 'border border-gray-300 rounded p-2 w-full';
            }

            const saveButton = document.createElement('button');
            saveButton.textContent = 'Save';
            saveButton.className = 'bg-green-500 text-white px-2 py-1 rounded ml-2';

            saveButton.onclick = function () {
                const newValue = input.value;

                fetch('<?php echo base_url('conAdmin/updateTaskField'); ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ taskId: taskId, columnType: columnType, newValue: newValue })
                }).then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                }).then(data => {
                    if (data.status === 'error') {
                        alert('Failed to update: ' + data.message);
                        element.innerHTML = element.dataset.originalValue;
                    } else {
                        element.innerHTML = newValue;
                        saveButton.style.display = 'none';
                        currentEditingCell = null;
                    }
                }).catch(error => {
                    alert('An error occurred while saving the task.');
                    element.innerHTML = element.dataset.originalValue;
                });
            };

            element.innerHTML = '';
            element.appendChild(input);
            element.appendChild(saveButton);
            input.focus();
        }

        function deleteTask(taskId) {
            if (confirm('Are you sure you want to delete this task?')) {
                fetch('<?php echo base_url('conAdmin/deleteTask'); ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ taskId: taskId })
                }).then(response => {
                    if (response.ok) window.location.reload();
                    else alert('Failed to delete task.');
                }).catch(error => {
                    alert('An error occurred while deleting the task.');
                });
            }
        }
    </script>
</head>

<body>
    <header class="bg-white shadow px-6 py-3">
        <h1 class="text-2xl font-bold text-gray-800">USER TASKS</h1>
    </header>
    <div class="main-container w-full flex">
        <div class="left-section flex-2 p-6">
            <div class="table-container bg-white rounded-lg shadow-md">
                <table class="table-auto w-full border-collapse">
                    <thead>
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Task Name</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Task For</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Owner</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Due Date</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($tasks) && is_array($tasks)): ?>
                            <?php foreach ($tasks as $task): ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-3">
                                        <input type="checkbox" class="task-checkbox" value="<?php echo $task['id']; ?>">
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800" data-column-type="task_name"
                                        data-task-id="<?php echo $task['id']; ?>" onclick="makeEditable(this)">
                                        <?php echo $task['task_name']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800" data-column-type="task_for"
                                        data-task-id="<?php echo $task['id']; ?>" onclick="makeEditable(this)">
                                        <?php echo htmlspecialchars($task['task_for']); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800" data-column-type="owner"
                                        data-task-id="<?php echo $task['id']; ?>" onclick="makeEditable(this)">
                                        <?php echo $task['owner']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800" data-column-type="status"
                                        data-task-id="<?php echo $task['id']; ?>" onclick="makeEditable(this)">
                                        <?php echo $task['status']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800" data-column-type="due_date"
                                        data-task-id="<?php echo $task['id']; ?>" onclick="makeEditable(this)">
                                        <?php echo date("F j, Y", strtotime($task['due_date'])); ?>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <button class="ml-2 text-red-600 hover:text-red-800"
                                            onclick="deleteTask(<?php echo $task['id']; ?>)">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Right section (form to create tasks) -->
        <div class="right-section flex-1 bg-white p-6">
            <h3 class="text-lg font-medium text-gray-700">Quick Actions</h3>
            <button id="bulkDeleteButton" class="bg-red-500 text-white px-4 py-2 rounded mt-4">
                Bulk Delete
            </button>

            <div id="editUserForm" class="mt-6"></div>
            <ul class="space-y-4 mt-4"></ul>
            <label for="task_name"
                class="text-green-500 text-left text-large font-bold hover:text-red-400 uppercase tracking-wider">CREATE
                TASK</label>
            <form action="<?php echo base_url('conAdmin/processCreateTask'); ?>" method="post" class="space-y-4">
                <div>
                    <label for="task_name"
                        class="text-green-400 text-left text-xs font-semibold hover:text-red-400 uppercase tracking-wider">Task
                        Name</label>
                    <input type="text" name="task_name" id="task_name"
                        class="darkmode_text createtaskborder bg-green-50 block px-6 py-1.5 w-2/5 mb-4 text-sm text-gray-800"
                        required>
                </div>
                <div>
                    <label for="task_for"
                        class="text-green-400 text-left text-xs font-semibold hover:text-red-400 uppercase tracking-wider">Task
                        For</label>
                    <select name="task_for[]" id="task_for"
                        class="createtaskborder bg-green-50 block px-6 py-1.5 w-2/5 mb-4 text-sm text-gray-800 mt-1 block py-2 px-3 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        required>
                        <option value="all">Select All Users</option>
                        <?php if (isset($users) && is_array($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['username']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div>
                    <label for="owner"
                        class="text-green-400 text-left text-xs font-semibold hover:text-red-400 uppercase tracking-wider">Owner
                        of the task</label>
                    <input type="text" name="owner" id="owner"
                        class="darkmode_text createtaskborder bg-green-50 block px-6 py-1.5 w-2/5 mb-4 text-sm text-gray-800"
                        required>
                </div>
                <div>
                    <label for="due_date"
                        class="text-green-400 text-left text-xs font-semibold hover:text-red-400 uppercase tracking-wider">Due
                        Date</label>
                    <input type="date" name="due_date" id="due_date"
                        class="createtaskborder bg-green-50 block px-6 py-1.5 w-2/5 mb-4 text-sm text-gray-800"
                        required>
                </div>
                <button type="submit"
                    class="bg-green-200 px-4 py-2 rounded hover:bg-green-300 transition filter-btn">Add Task</button>
            </form>
        </div>
    </div>

    <script>
        function deleteTask(taskId) {
            // Show confirmation dialog using SweetAlert2
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to undo this action!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#66cdaa',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with task deletion via fetch
                    fetch('<?php echo base_url('conAdmin/deleteTask'); ?>', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ taskId: taskId })
                    }).then(response => {
                        if (response.ok) {
                            // Display success message and reload the page after 1.5 seconds
                            Swal.fire(
                                'Deleted!',
                                'Your task has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.reload(); // Reload to reflect changes
                            });
                        } else {
                            Swal.fire(
                                'Failed!',
                                'There was an issue deleting the task.',
                                'error'
                            );
                        }
                    }).catch(error => {
                        Swal.fire(
                            'Error!',
                            'An error occurred while deleting the task.',
                            'error'
                        );
                    });
                }
            });
        }
        document.getElementById('bulkDeleteButton').addEventListener('click', function () {
            const selectedTasks = Array.from(document.querySelectorAll('.task-checkbox:checked'))
                .map(checkbox => checkbox.value);

            if (selectedTasks.length === 0) {
                Swal.fire('Error', 'No tasks selected for deletion', 'error');
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to undo this action!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete them!',
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('<?php echo base_url("conAdmin/bulkDeleteTasks"); ?>', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ taskIds: selectedTasks }),
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire('Deleted!', 'The selected tasks have been deleted.', 'success')
                                    .then(() => window.location.reload());
                            } else {
                                Swal.fire('Error', 'Failed to delete tasks: ' + data.message, 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Error', 'An error occurred while deleting tasks.', 'error');
                        });
                }
            });
        });

        // Select/Deselect all checkboxes
        document.getElementById('selectAll').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('.task-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });

    </script>

</body>

</html>