<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USER PANEL</title>
    <link rel="stylesheet"
        href="<?php echo base_url('assets/css/viewhome.css?v=' . filemtime('assets/css/viewhome.css')); ?>">
    <link rel="stylesheet"
        href="<?php echo base_url('assets/css/darkmode_landing.css?v=' . filemtime('assets/css/darkmode_landing.css')); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link rel="icon"
        href="https://up.yimg.com/ib/th?id=OIP.LyQMxucs0UiwtrvJeT44MQHaFg&pid=Api&rs=1&c=1&qlt=95&w=145&h=108"
        type="image/jpg" title="Atom">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- BOXICONS-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        #notificationDropdown {
            width: 48rem;
            /* Doubled the width */
        }
    </style>
</head>

<body>







    <!-- SIDE NAVBAR -->
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="<?= base_url($user['uploaded_profile_image'] ?? 'uploads/default_profiles/default_profile.avif'); ?>"
                        alt="Profile Image">
                </span>

                <div class="text header-text">
                    <span class="name">
                        <?php echo $username; ?>
                    </span>

                    <span class="profession"><?= htmlspecialchars($user['rank']); ?></span>

                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>



        <script>
            function filterTasks() {
                const searchQuery = document.getElementById('search-bar').value.toLowerCase();
                const rows = document.querySelectorAll('table tbody tr');

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    const rowText = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');

                    if (rowText.includes(searchQuery)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
        </script>

        <script>
            function filterTasks() {
                const searchQuery = document.getElementById('search-bar').value.toLowerCase();
                const rows = document.querySelectorAll('table tbody tr');

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    const rowText = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');

                    if (rowText.includes(searchQuery)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
        </script>

        <div class="menu-bar">
            <div class="menu">
                <li class="search-box">
                    <i class='bx bx-search icon'></i>
                    <input class="py-2 px-3 text-left text-small font-semibold  uppercase tracking-wider" type="search"
                        id="search-bar" placeholder="Search" oninput="filterTasks()">
                </li>
                <li class="nav-link">
                    <a class="darkmode_sidebar_links" href="javascript:void(0);" onclick="loaduserDashboard()">
                        <i class="darkmode_sidebar_links bx bx-home-circle icon"></i> <!-- userrequirements icon -->
                        <span class="text nav-text">DASHBOARD</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a class="darkmode_sidebar_links" href="javascript:void(0);" onclick="loadUseruserrequirements()">
                        <i class="darkmode_sidebar_links bx bx-home-circle icon"></i> <!-- userrequirements icon -->
                        <span class="text nav-text">USER REQUIREMENTS</span>
                    </a>
                </li>

                <!-- <li class="nav-link">
                    <a class="darkmode_sidebar_links" href="javascript:void(0);" onclick="loadAttendanceContent()">
                        <i class="darkmode_sidebar_links bx bx-calendar-check icon"></i> 
                        <span class="text nav-text">ATTENDANCE</span>
                    </a>
                </li> -->
                <li class="nav-link">
                    <a class="darkmode_sidebar_links" href="javascript:void(0);" onclick="loadManualFacultyContent()">
                        <i class="darkmode_sidebar_links bx bx-list-check icon"></i> <!-- Tasks icon -->
                        <span class="text nav-text">FACULTY MANUAL</span>
                    </a>
                </li>
                <!-- <li class="nav-link">
                    <a class="darkmode_sidebar_links" href="javascript:void(0);" onclick="loadUserTasksContent()">
                        <i class="darkmode_sidebar_links bx bx-list-check icon"></i> 
                        <span class="text nav-text">TASKS</span>
                    </a>
                </li> -->

                <li class="nav-link">
                    <a class="darkmode_sidebar_links" href="javascript:void(0);" onclick="loadRequirementStatus()">
                        <i class="darkmode_sidebar_links bx bx-clipboard icon"></i> <!-- Requirement status icon -->
                        <span class="text nav-text">REQUIREMENT STATUS</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a class="darkmode_sidebar_links" href="javascript:void(0);" onclick="loadFacultyContent()">
                        <i class="darkmode_sidebar_links bx bx-book icon"></i> <!-- Book icon -->
                        <span class="text nav-text">FACULTY</span>
                    </a>
                </li>




                <li class="nav-link">
                    <a class="darkmode_sidebar_links" href="javascript:void(0);" onclick="loadProfileContent()">
                        <i class="darkmode_sidebar_links bx bx-user-circle icon"></i> <!-- Profile icon -->
                        <span class="text nav-text">PROFILE</span>
                    </a>
                </li>

            </div>

            <div class="bottom-content">
                <li class="">
                    <a class="darkmode_sidebar_links" onclick="checker(event)"
                        href="<?php echo base_url('Home/logout'); ?>">
                        <i class='darkmode_sidebar_links bx bx-log-out icon'></i>
                        <span class="text nav-text">Logout</span>
                    </a>

                </li>

                <li class="mode">
                    <div class="moon-sun">
                        <i class='darkmode_sidebar_links bx bx-moon icon moon'></i>
                        <i class='darkmode_sidebar_links bx bx-sun icon sun'></i>
                    </div>
                    <span class="mode-text text">Dark Mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
            </div>
        </div>
    </nav>

    <section class="home">
        <!-- Navbar with Notification Icon -->
        <!-- Navbar with Notification Icon -->
        <nav class="bg-white p-4 flex justify-between items-center">
            <div class="font-bold text-lg pl-10">Faculty Ranking and Data Management System for Academic Excellence
            </div>

            <!-- Notification Icon -->
            <div class="relative">
                <a id="notificationButton" class="cursor-pointer relative focus:outline-none"
                    onclick="toggleDropdown()">
                    <i class="fas fa-bell text-green-600 text-2xl"></i>
                    <!-- Notification Counter -->
                    <span id="notificationCounter"
                        class="absolute -top-2 -right-2 bg-green-200 text-green-800 text-xs font-bold rounded-full px-2">
                        <?= $unread_notifications ?>
                    </span>
                </a>


                <!-- Notification Dropdown -->
                <div id="notificationDropdown"
                    class="notifications_design hidden absolute right-0 mt-2 w-192 bg-white shadow-lg rounded-lg z-10">
                    <div class="p-4">
                        <h3 class="font-bold text-lg flex space-x-2 px-1 py-2 justify-between">Notifications
                            <button class=" text-green-800 hover:bg-green-300 text-green-800 rounded px-2"
                                onclick="markNotificationsRead()">Mark all as read</button>
                            <!-- Delete All Notifications Button -->
                            <button class="    text-red-800 hover:bg-red-300 rounded px-2 "
                                onclick="deleteAll_ViewHome_Notifications()">Delete all notifications</button>
                        </h3>
                        <ul class="mt-2">
                            <?php foreach ($notifications as $notification): ?>
                                <li class="bg-gray-100 p-2 mb-2 rounded flex justify-between items-center">
                                    <div>
                                        <p><?= htmlspecialchars($notification['message']) ?></p>
                                        <p class="text-sm text-gray-500">
                                            <?= date('F j, Y, g:i a', strtotime($notification['created_at'])) ?>
                                        </p>
                                    </div>
                                </li>
                            <?php endforeach; ?>

                            <!-- Notifications for Requirements -->
                            <!-- <?php foreach ($notifications_requirements as $notification): ?>
                                <li class="bg-gray-100 p-2 mb-2 rounded flex justify-between items-center">
                                    <div>
                                        <p><?= htmlspecialchars($notification['message']) ?></p>
                                        <p class="text-sm text-gray-500">
                                            <?= date('F j, Y, g:i a', strtotime($notification['created_at'])) ?>
                                        </p>
                                    </div>
                                    <button onclick="deleteNotification(<?= $notification['id'] ?>, 'requirements')"
                                        class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </li>
                            <?php endforeach; ?> -->

                            <!-- <?php foreach ($notifications_requirements as $notification): ?>
                                <li class="bg-gray-100 p-2 mb-2 rounded flex justify-between items-center">
                                    <div>
                                        <p><?= htmlspecialchars($notification['message']) ?></p>
                                        <p class="text-sm text-gray-500">
                                            <?= date('F j, Y, g:i a', strtotime($notification['created_at'])) ?>
                                        </p>
                                    </div>
                                </li>
                            <?php endforeach; ?> -->


                            <?php foreach ($notifications_rankup as $notification): ?>
                                <li id="notification-<?= $notification['id'] ?>"
                                    class="bg-gray-100 p-2 mb-2 rounded flex justify-between items-center">
                                    <div>
                                        <p><?= htmlspecialchars($notification['message']) ?></p>
                                        <p class="text-sm text-gray-500">
                                            <?= date('F j, Y, g:i a', strtotime($notification['created_at'])) ?>
                                        </p>
                                    </div>
                                    <!-- <button onclick="deleteNotification(<?= $notification['id'] ?>, 'rankup')"
                                        class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-trash-alt"></i>
                                    </button> -->
                                </li>
                            <?php endforeach; ?>


                        </ul>


                    </div>
                </div>


        </nav>

        <script>
            // Toggle the visibility of the notification dropdown
            function toggleDropdown() {
                const dropdown = document.getElementById('notificationDropdown');
                dropdown.classList.toggle('hidden');
            }


            // Mark all notifications as read
            function markNotificationsRead() {
                fetch('<?= base_url('conAdmin/markNotificationsRead') ?>', {
                    method: 'POST',
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Close the dropdown
                            toggleDropdown();

                            // Update the notification counter
                            document.getElementById('notificationCounter').innerText = '0'; // Set the counter to 0
                            document.getElementById('notificationCounter').style.display = 'none'; // Hide if 0

                            // Optionally, you can show a toast notification or alert the user here
                            Toastify({
                                text: "All notifications marked as read",
                                backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                                duration: 3000
                            }).showToast();
                        } else {
                            alert('Error marking notifications as read');
                        }
                    });
            }
            // Delete all notifications
            function deleteAll_ViewHome_Notifications() {
                if (confirm("Are you sure you want to delete all notifications?")) {
                    fetch('<?= base_url('conAdmin/deleteAll_ViewHome_Notifications') ?>', {
                        method: 'POST',
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                // Close the dropdown
                                toggleDropdown();

                                // Clear the notification counter and hide it
                                document.getElementById('notificationCounter').innerText = '0';
                                document.getElementById('notificationCounter').style.display = 'none';

                                // Optionally, show a success toast
                                Toastify({
                                    text: "All notifications deleted",
                                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc3a0)",
                                    duration: 3000
                                }).showToast();

                                // Optionally, clear the notifications list in the dropdown
                                document.querySelector('#notificationDropdown ul').innerHTML = '';
                            } else {
                                alert('Error deleting notifications');
                            }
                        });
                }
            }

            // Delete a notification
            function deleteNotification(notificationId, notificationType = 'requirements') {
                fetch('<?= base_url('conAdmin/delete_viewhome_notifications') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        notification_id: notificationId,
                        notification_type: notificationType
                    }),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Remove the deleted notification from the UI
                            const notificationElement = document.getElementById('notification-' + notificationId);
                            if (notificationElement) {
                                notificationElement.remove();
                            }

                            // Update the notification counter
                            document.getElementById('notificationCounter').innerText = data.unread_notifications;

                            // Optionally, show a success message
                            Toastify({
                                text: "Notification deleted successfully",
                                backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc3a0)",
                                duration: 3000,
                                position: "bottom-right"
                            }).showToast();
                        } else {
                            alert('Error deleting notification');
                        }
                    });
            }





        </script>


        <div id="content-container"></div> <!-- This will load the usertask.php view dynamically -->
    </section>

    <script>
        const body = document.querySelector("body"),
            sidebar = body.querySelector(".sidebar"),
            toggle = body.querySelector(".toggle"),
            modeSwitch = body.querySelector(".toggle-switch"),
            modeText = body.querySelector(".mode-text");

        toggle.addEventListener("click", () => {
            sidebar.classList.toggle("close");
            // Save the state in localStorage
            const isClosed = sidebar.classList.contains("close");
            localStorage.setItem("sidebarState", isClosed ? "closed" : "open");
        });

        // On page load, restore the sidebar state
        document.addEventListener("DOMContentLoaded", function () {
            const savedSidebarState = localStorage.getItem("sidebarState");

            if (savedSidebarState === "closed") {
                sidebar.classList.add("close");
            } else {
                sidebar.classList.remove("close");
            }
        });
        modeSwitch.addEventListener("click", () => {
            body.classList.toggle("dark");

            // Save dark mode state in localStorage
            if (body.classList.contains("dark")) {
                modeText.innerText = "Light Mode";
                localStorage.setItem('darkMode', 'true'); // Store dark mode preference
            } else {
                modeText.innerText = "Dark Mode";
                localStorage.setItem('darkMode', 'false'); // Store light mode preference
            }
        });

        // On page load, check for dark mode preference in localStorage
        document.addEventListener("DOMContentLoaded", function () {
            const darkModePreference = localStorage.getItem('darkMode') === 'true';
            if (darkModePreference) {
                body.classList.add('dark');
                modeText.innerText = "Light Mode"; // Update the text to indicate Light Mode
            } else {
                modeText.innerText = "Dark Mode"; // Update the text to indicate Dark Mode
            }

            // Load the stored view on page refresh
            const storedView = localStorage.getItem('currentView');
            if (storedView) {
                loadView(storedView);
            } else {
                loadHomeContent(); // Default to Home if no view is stored
            }
        });

        function loadView(viewName) {
            let url = '';
            switch (viewName) {
                case 'userrequirements':
                    url = '<?php echo base_url('conAdmin/userrequirements'); ?>';
                    break;
                case 'userDashboard':
                    url = '<?php echo base_url('Home/userDashboard'); ?>';
                    break;
                case 'userAttendance':
                    url = '<?php echo base_url('controllerAttendance/userAttendance'); ?>';
                    break;
                case 'tasks':
                    url = '<?php echo base_url('Home/userTasks'); ?>';
                    break;
                case 'userFaculty':
                    url = '<?php echo base_url('controllerFaculty/UserFaculty'); ?>';
                    break;
                case 'profile':
                    url = '<?php echo base_url('Home/clientprofile'); ?>';
                    break;
                case 'requirementstatus':
                    url = '<?php echo base_url('conAdmin/requirementstatus'); ?>';
                    break;
                case 'userManualFaculty':
                    url = '<?php echo base_url('conFacultyManual/userManualFaculty'); ?>';
                    break;
                default:
                    url = '<?php echo base_url('Home/DefaultHome'); ?>';
            }

            $("#content-container").load(url, function (response, status, xhr) {
                if (status === "error") {
                    console.error(`Error loading ${viewName}: `, xhr.status, xhr.statusText);
                } else {
                    console.log(`${viewName} loaded successfully`);
                    localStorage.setItem('currentView', viewName); // Store current view
                }
            });
        }

        function loadHomeContent() {
            loadView('home');
        }
        function loadAttendanceContent() {
            loadView('userAttendance');
        }

        function loadUserTasksContent() {
            loadView('tasks');
        }

        function loadRequirementStatus() {
            loadView('requirementstatus');
        }

        function loadUseruserrequirements() {
            loadView('userrequirements');
        }
        function loadFacultyContent() {
            loadView('userFaculty');
        }

        function loadProfileContent() {
            loadView('profile');
        }
        function loadManualFacultyContent() {
            loadView('userManualFaculty');
        }
        function loaduserDashboard() {
            loadView('userDashboard');
        }

        function checker(event) {
            event.preventDefault(); // Prevent the default action of the logout link

            // SweetAlert2 confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to log out!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, log me out!',
                cancelButtonText: 'No, stay logged in!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with logout if confirmed
                    window.location.href = '<?php echo base_url('Home/logout'); ?>';
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>