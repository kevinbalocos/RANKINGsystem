<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="<?php echo base_url('assets/css/adminhome.css?v=' . filemtime('assets/css/adminhome.css')); ?>">
    <link rel="stylesheet"
        href="<?php echo base_url('assets/css/darkmode_landing.css?v=' . filemtime('assets/css/darkmode_landing.css')); ?>">
    <title>ADMIN PANEL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon"
        href="https://up.yimg.com/ib/th?id=OIP.LyQMxucs0UiwtrvJeT44MQHaFg&pid=Api&rs=1&c=1&qlt=95&w=145&h=108"
        type="image/jpg" title="Atom">
    <!-- BOXICONS-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<style>
    .grid div:hover {
        cursor: pointer;
        transform: scale(1.05);
        transition: transform 0.2s ease-in-out;
    }
</style>

<body>
    <!-- SIDE NAVBAR -->
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="https://up.yimg.com/ib/th?id=OIP.LyQMxucs0UiwtrvJeT44MQHaFg&pid=Api&rs=1&c=1&qlt=95&w=145&h=108"
                        alt="logo">
                </span>

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

                <div class="text header-text">
                    <span class="name">ADMIN HR</span>
                    <span class="profession"></span>
                </div>
            </div>
            <i class='bx bx-chevron-right toggle'></i>
        </header>
        <div class="menu-bar">
            <div class="menu">
                <li class="search-box">
                    <!-- Search Icon: changed to a magnifying glass -->
                    <i class='bx bx-search-alt icon'></i>
                    <input class=" text-left text-small font-semibold  uppercase tracking-wider" type="search"
                        id="search-bar" placeholder="Search" oninput="filterTasks()">
                </li>
                <li class="nav-link">
                    <a href="javascript:void(0);" onclick="loadView('dashboard')">
                        <!-- Dashboard Icon: changed to a house -->
                        <i class='bx bx-home-circle icon'></i>
                        <span class="text nav-text">DASHBOARD</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="javascript:void(0);" onclick="loadView('manage_user')">
                        <!--  Icon: changed to a house -->
                        <i class='bx bx-home-circle icon'></i>
                        <span class="text nav-text">MANAGE USER ACCOUNT</span>
                    </a>
                </li>


                <!-- <li class="nav-link">
                    <a href="javascript:void(0);" onclick="loadView('assignShift')">
                        <i class='bx bx-calendar icon'></i>
                        <span class="text nav-text">ASSIGN SHIFT</span>
                    </a>
                </li> -->
                <li class="nav-link">
                    <a href="javascript:void(0);" onclick="loadView('FacultyAdmin')">
                        <!-- User Icon: changed to a group of people -->
                        <i class='bx bx-group icon'></i>
                        <span class="text nav-text">ADMIN FACULTY</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="javascript:void(0);" onclick="loadView('FacultyManual')">
                        <!-- Trophy Icon: changed to medal -->
                        <i class='bx bx-medal icon'></i>
                        <span class="text nav-text">FACULTY MANUAL</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="javascript:void(0);" onclick="loadView('rankingtask')">
                        <!-- Trophy Icon: changed to medal -->
                        <i class='bx bx-medal icon'></i>
                        <span class="text nav-text">USER RANK</span>
                    </a>
                </li>
                <li class="nav-link">
                    <!-- User Icon: changed to a calendar -->
                    <div class="darkmode_lines mt-12 w-full border-b border-gray-800">
                        <!-- Your content here -->
                    </div>
                </li>


                <!-- <li class="nav-link">
                    <a href="javascript:void(0);" onclick="loadView('createTask')">
                        <i class='bx bx-check-square icon'></i>
                        <span class="text nav-text">USER TASK</span>
                    </a>
                </li> -->
                <li class="nav-link">
                    <a href="javascript:void(0);" onclick="loadView('userUploadedTasks')">
                        <i class='bx bx-cloud-upload icon'></i>
                        <span class="text nav-text">TASK/FACULTY</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="javascript:void(0);" onclick="loadView('adminUserRequirements')">
                        <!--  Icon: changed to a house -->
                        <i class='bx bx-home-circle icon'></i>
                        <span class="text nav-text">ASSIGN REQUIREMENTS</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="javascript:void(0);" onclick="loadView('userFiles')">
                        <!-- File Icon: changed to folder-open -->
                        <i class='bx bx-folder-open icon'></i>
                        <span class="text nav-text">USER REQUIREMENT</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="javascript:void(0);" onclick="loadView('userInfo')">
                        <!-- User Information Icon: changed to user-circle -->
                        <i class='bx bx-user-circle icon'></i>
                        <span class="text nav-text">USER INFORMATION</span>
                    </a>
                </li>



            </div>

            <div class="bottom-content">
                <li class="nav-link">
                    <a href="javascript:void(0);" onclick="loadView('Feedback')">
                        <!-- User Information Icon: changed to user-circle -->
                        <i class='bx bx-user-circle icon'></i>
                        <span class="text nav-text">FEEDBACK</span>
                    </a>
                </li>

                <li>
                    <a onclick="checker(event)" href="<?php echo base_url('Home/logout'); ?>">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>
                <li class="mode">
                    <div class="moon-sun">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
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
        <div id="content-container"></div>
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

        // Toggle dark mode
        modeSwitch.addEventListener("click", () => {
            // Toggle the dark class on body
            body.classList.toggle("dark");

            // Update the mode text
            modeText.innerText = body.classList.contains("dark") ? "Light Mode" : "Dark Mode";

            // Store the dark mode preference in localStorage
            localStorage.setItem('darkMode', body.classList.contains("dark"));
        });

        // Check dark mode preference on page load
        document.addEventListener("DOMContentLoaded", function () {
            const darkModePreference = localStorage.getItem('darkMode') === 'true';

            // If dark mode was previously set, enable dark mode
            if (darkModePreference) {
                body.classList.add("dark");
                modeText.innerText = "Light Mode"; // Update the mode text
            } else {
                body.classList.remove("dark");
                modeText.innerText = "Dark Mode"; // Update the mode text
            }

            // Load the view if stored
            const storedView = localStorage.getItem('adminCurrentView');
            if (storedView) {
                loadView(storedView);
            } else {
                loadView('dashboard'); // Default to Dashboard if no view is stored
            }
        });

        // Function to load different views based on menu click
        function loadView(viewName) {
            let url = '';
            switch (viewName) {
                case 'dashboard':
                    url = '<?php echo base_url('conAdmin/dashboard'); ?>';
                    break;
                case 'rankingtask':
                    url = '<?php echo base_url('conAdmin/rankingtask'); ?>';
                    break;
                case 'manage_user':
                    url = '<?php echo base_url('auth/manage_users'); ?>';
                    break;
                case 'createTask':
                    url = '<?php echo base_url('conAdmin/tasks'); ?>';
                    break;
                case 'adminUserRequirements':
                    url = '<?php echo base_url('conAdmin/adminUserRequirements'); ?>';
                    break;

                case 'userUploadedTasks':
                    url = '<?php echo base_url('conAdmin/userUploadedTasks'); ?>';
                    break;
                case 'userFiles':
                    url = '<?php echo base_url('conAdmin/userfiles'); ?>';
                    break;
                case 'assignShift':
                    url = '<?php echo base_url('controllerAttendance/assignShift'); ?>';
                    break;
                case 'userInfo':
                    url = '<?php echo base_url('conAdmin/userinfo'); ?>';
                    break;
                case 'tasks':
                    url = '<?php echo base_url('conAdmin/tasks'); ?>';
                    break;
                case 'FacultyAdmin':
                    url = '<?php echo base_url('controllerFaculty/FacultyAdmin'); ?>';
                    break;
                case 'userInfo':
                    url = '<?php echo base_url('conAdmin/userinfo'); ?>';
                    break;
                case 'FacultyManual':
                    url = '<?php echo base_url('conFacultyManual/adminManualFaculty'); ?>';
                    break;
                case 'Feedback':
                    url = '<?php echo base_url('Auth/feedback_contact'); ?>';
                    break;
                case 'userfiles':
                    url = '<?php echo base_url('conAdmin/userfiles'); ?>';
                    break;
                default:
                    url = '<?php echo base_url('conAdmin/dashboard'); ?>';
            }

            $("#content-container").html("<div class='loading'>Loading...</div>");
            $("#content-container").load(url, function (response, status, xhr) {
                if (status === "error") {
                    $("#content-container").html("<h2>Sorry, there was an error loading the page.</h2>");
                    console.error(`Error loading ${viewName}: `, xhr.status, xhr.statusText);
                } else {
                    console.log(`${viewName} loaded successfully`);
                    localStorage.setItem('adminCurrentView', viewName);
                }
            });
        }

        // Logout confirmation
        function checker(event) {
            event.preventDefault(); // Prevent the default action of the logout link

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