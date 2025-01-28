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

    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');

    * {
        font-family: 'Poppins';
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    ::selection {
        background: linear-gradient(145deg, #a1ffce, #05eebb, #025240);
        color: #003d28;
        text-shadow: 0 0 10px rgba(86, 209, 183, 0.7);
    }

    ::-moz-selection {
        background: linear-gradient(145deg, #a1ffce, #05eebb, #025846);
        color: #003d28;
        text-shadow: 0 0 10px rgba(6, 61, 49, 0.7);
    }


    :root {
        /* -----COLORS------ */
        --body-color: #E4E9f7;
        --sidebar-color: white;
        --primary-color: #78c1b1;
        --primary-color-light: #F6F5FF;
        --toggle-color: #DDD;
        --text-color: #707070;

        /*T ----TRANSITIONS----*/
        --tran-02: all 0.2s ease;
        --tran-03: all 0.3s ease;
        --tran-04: all 0.4s ease;
        --tran-05: all 0.5s ease;
    }


    body {
        height: 10vh;
        height: 100%;
        background: var(--body-color);
        transition: var(--tran-05);

    }


    hs {
        color: var(--primary-color);
    }

    .name {
        color: var(--primary-color);
    }

    /* -----SIDEBAR----- */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 250px;
        padding: 10px 14px;
        background: var(--sidebar-color);
        transition: var(--tran-05);
        z-index: 100;
    }

    .sidebar.close {
        width: 88px;
        cursor: pointer;
    }

    /* -----REUSABLE CSS----- */
    .sidebar .text {
        font-size: 16px;
        font-weight: 500;
        color: var(--text-color);
        transition: var(--tran-03);
        white-space: nowrap;
        opacity: 1;
    }

    .sidebar.close .text {
        opacity: 0;
    }

    .sidebar .image {
        min-width: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #content-container {
        margin-left: 35px;
    }


    .sidebar li {
        height: 50px;
        margin-top: 10px;
        list-style: none;
        display: flex;
        align-items: center;
    }

    .sidebar li .icon {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 60px;
        font-size: 20px;

    }

    .sidebar li .icon,
    .sidebar li .text {
        color: var(--text-color);
        transition: var(--tran-02);
    }


    .sidebar header {
        position: relative;
    }


    .sidebar .image-text img {
        width: 40px;
        border-radius: 6px;
        height: 40px;
    }

    .sidebar header .image-text {
        display: flex;
        align-items: center;
        height: 30px;

    }

    header .image-text .header-text {
        display: flex;
        flex-direction: column;
    }


    .header-text .name {
        font-weight: 600;
    }

    .header-text .profession {
        margin-top: -2px;
    }

    .sidebar header .toggle {
        position: absolute;
        top: 50%;
        right: -25px;
        transform: translateY(-50%) rotate(180deg);
        height: 25px;
        width: 25px;
        background: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: var(--sidebar-color);
        font-size: 22px;
        transition: var(--tran-03);
    }

    .sidebar .menu {
        margin-top: 35px;
    }

    .sidebar .search-box {
        background-color: var(--primary-color-light);
        border-radius: 6px;
        transition: var(--tran-05);

    }

    .sidebar.close header .toggle {
        transform: translateY(-50%);
    }


    .search-box input {
        height: 100%;
        width: 100%;
        outline: none;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 500;
        background-color: var(--primary-color-light);
        transition: var(--tran-05);
    }



    .sidebar li a {
        width: 100%;
        height: 100%;
        display: flex;
        ;
        align-items: center;
        text-decoration: none;
        border-radius: 6px;
        transition: var(--tran-04);
    }

    .sidebar li a:hover {
        background-color: var(--primary-color);
    }

    .sidebar li a:hover .icon,
    .sidebar li a:hover .text {
        color: var(--sidebar-color);
    }



    .sidebar .menu-bar {
        height: calc(100% - 50px);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .sidebar {
        width: 100%;
        width: 290px;
    }

    .menu-bar .mode {
        position: relative;
        border-radius: 6px;
        background: var(--primary-color-light);
    }


    .menu-bar .mode .moon-sun {
        height: 50px;
        width: 60px;
        display: flex;
        align-items: center;
    }


    .menu-bar .mode i {
        position: absolute;
        transition: var(--tran-03);
    }

    .menu-bar .mode i.sun {
        opacity: 0;
    }


    .menu-bar .mode .toggle-switch {
        position: absolute;
        right: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        min-width: 60px;
        cursor: pointer;
        border-radius: 6px;
        background: var(--primary-color-light);
    }

    .toggle-switch .switch {
        position: relative;
        height: 22px;
        width: 44px;
        border-radius: 25px;
        background: var(--toggle-color);
        transition: var(--tran-05);
    }

    .switch::before {
        content: '';
        position: absolute;
        height: 15px;
        width: 15px;
        border-radius: 50%;
        top: 50%;
        left: 5px;
        transform: translateY(-50%);
        background: var(--sidebar-color);
        transition: var(--tran-03);
    }


    .home {
        position: relative;
        left: 250px;
        height: 200vh;
        width: calc(100% - 250px);
        background: var(--body-color);
        transition: var(--tran-05);

    }

    .home .text {
        font-size: 30px;
        font-weight: 500;
        color: var(--text-color);
        padding: 8px 40px;
    }

    .sidebar.close~.home {
        left: 50px;
        width: calc(100% - 50px);
    }



    h1 {
        text-align: center;
        color: #333;
        font-family: math;
    }

    .btn:hover {
        background-color: #DDA0DD;
        color: white;
    }

    .navbar .d-flex {
        justify-content: flex-end;
    }

    .navtext {
        color: #720e9e;
        text-decoration: none;
        padding-top: 10px;
        margin-bottom: 5px;


    }



    .navtext:hover {
        text-decoration: underline;

        padding-top: 10px;
        color: white;
        transition: text-decoration 1.3s;
    }

    .bottom-navbar {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #662d91;
        padding: 10px;
        text-align: center;
        z-index: 1000;
    }

    .botnavtext {
        color: #101010;
        margin-left: 10px;
        margin-right: 10px;
        text-decoration: none;

    }

    .botnavtext:hover {
        color: white;
    }

    /* Hide the bottom scrollbar */
    body {
        overflow-x: hidden;
        /* Hides the bottom scrollbar */
        overflow-y: scroll;
        /* Keeps the right scrollbar */
    }


    ::-webkit-scrollbar {
        width: 5px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #66cdaa;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-track {
        background-color: #66cdaa;
    }

    .underline_navlink {}
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
                    <input type="search" id="search-bar" placeholder="Search" oninput="filterTasks()">
                </li>
                <li class="nav-link">
                    <a href="javascript:void(0);" onclick="loadView('dashboard')">
                        <!-- Dashboard Icon: changed to a house -->
                        <i class='bx bx-home-circle icon'></i>
                        <span class="text nav-text">DASHBOARD</span>
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
                    <a href="javascript:void(0);" onclick="loadView('createTask')">
                        <!-- Task Icon: changed to checklist -->
                        <i class='bx bx-check-square icon'></i>
                        <span class="text nav-text">USER TASK</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="javascript:void(0);" onclick="loadView('userUploadedTasks')">
                        <i class='bx bx-cloud-upload icon'></i>
                        <span class="text nav-text">USER UPLOADED TASK</span>
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
                    <!-- User Icon: changed to a calendar -->
                    <div class="darkmode_lines mt-12 w-full border-b border-gray-800">
                        <!-- Your content here -->
                    </div>
                </li>


                <style>
                </style>
                <li class="nav-link">
                    <a href="javascript:void(0);" onclick="loadView('assignShift')">
                        <!-- User Icon: changed to a calendar -->
                        <i class='bx bx-calendar icon'></i>
                        <span class="text nav-text">ASSIGN SHIFT</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="javascript:void(0);" onclick="loadView('FacultyAdmin')">
                        <!-- User Icon: changed to a group of people -->
                        <i class='bx bx-group icon'></i>
                        <span class="text nav-text">ADMIN FACULTY</span>
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
                case 'createTask':
                    url = '<?php echo base_url('conAdmin/tasks'); ?>';
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