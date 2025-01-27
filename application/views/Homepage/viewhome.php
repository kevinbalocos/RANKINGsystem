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
    <style>

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
                    <input type="search" id="search-bar" placeholder="Search" oninput="filterTasks()">
                </li>

                <li class="nav-link">
                    <a class="darkmode_sidebar_links" href="javascript:void(0);" onclick="loadUserDashboard()">
                        <i class='darkmode_sidebar_links bx bxs-dashboard icon'></i>
                        <span class="text nav-text">DASHBOARD</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a class="darkmode_sidebar_links" href="javascript:void(0);" onclick="loadAttendanceContent()">
                        <i class='darkmode_sidebar_links bx bx-bell icon'></i>
                        <span class="text nav-text">ATTENDANCE</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a class="darkmode_sidebar_links" href="javascript:void(0);" onclick="loadUserTasksContent()">
                        <i class='darkmode_sidebar_links bx bx-task icon'></i>
                        <span class="text nav-text">TASKS</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a class="darkmode_sidebar_links" href="javascript:void(0);" onclick="loadRequirementStatus()">
                        <i class='darkmode_sidebar_links bx bx-bell icon'></i>
                        <span class="text nav-text">REQUIREMENT STATUS</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a class="darkmode_sidebar_links" href="javascript:void(0);" onclick="loadFacultyContent()">
                        <i class='darkmode_sidebar_links bx bxs-user-badge icon'></i>
                        <span class="text nav-text">FACULTY</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a class="darkmode_sidebar_links" href="javascript:void(0);" onclick="loadProfileContent()">
                        <i class='darkmode_sidebar_links bx bxs-user-badge icon'></i>
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
                case 'dashboard':
                    url = '<?php echo base_url('conAdmin/userDashboard'); ?>';
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

        function loadUserDashboard() {
            loadView('dashboard');
        }
        function loadFacultyContent() {
            loadView('userFaculty');
        }

        function loadProfileContent() {
            loadView('profile');
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