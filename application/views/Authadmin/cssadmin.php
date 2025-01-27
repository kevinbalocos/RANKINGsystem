<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>viewHome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Include FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
    body {
        background-color: #101010;
        overflow-x: hidden;
    }

    .content {
        margin-left: 0;
        padding: 20px;
        width: 100%;
        transition: margin-left 0.3s;
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: -250px;
        height: 100%;
        width: 150px;
        background-color: #111111;
        color: #fff;
        transition: left 0.3s;
    }

    .sidebar-open .content {
        margin-left: 250px;
    }



    #sidebar-toggle {
        position: fixed;
        top: 10px;
        left: 10px;
        background-color: #4B0082;
        color: #fff;
        border: none;
        cursor: pointer;
    }




    h1 {
        text-align: center;
        color: #333;
        font-family: math;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #662d91;
        color: #fff;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ccc;
    }

    .btn {
        display: inline-block;
        padding: 5px 10px;
        background-color: #662d91;
        color: #fff;
        text-decoration: none;
        border-radius: 10px;
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
        color: #fff;
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
</style>
</head>

<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <form class="d-flex ms-auto" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn" type="submit">Search</button>
            </form>
        </div>
    </nav>
    <br><br>
    <div id="content-container"> </div>
    <!-- Bottom Navbar -->
    <div class="bottom-navbar">
        <a class="fa-solid fa-house botnavtext" onclick="User()" href="<?php echo base_url('Home'); ?>"> Home</a>
        <a class="fa-solid fa-user botnavtext" href="javascript:void(0);" onclick="loadUserInfoContent()"> User Info</a>
    </div>


    <div class="container-fluid">
        <button id="sidebar-toggle" onclick="toggleSidebar()">☰</button>
        <div class="row">
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="position-sticky">
                    <button id="close-sidebar" class="bi bi-house-dash-fill" onclick="toggleSidebar()"></button>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="fa-solid fa-cart-shopping navtext" href="javascript:void(0);"
                                onclick="loadProductContent()"> PRODUCTS</a>
                        </li>

                        <li class="nav-item">
                            <a class="fa-solid fa-boxes-stacked navtext" href="javascript:void(0);"
                                onclick="loadStocksContent()"> STOCK</a>
                        </li>
                        <li class="nav-item">
                            <a class="fa-solid fa-gauge navtext" href="javascript:void(0);"
                                onclick="loadDashboardContent()">DASHBOARD</a>
                        </li>
                        <li class="nav-item">
                            <a class="fa-solid fa-right-from-bracket navtext" onclick="checker()"
                                href="<?php echo base_url('Home/logout'); ?>"> LOGOUT</a>
                        </li>

                    </ul>
                </div>
            </nav>
            <main class="col-md-10 col-lg-10 px-md-4 content">


        </div>
    </div>
    </main>
    </div>
    </div>

    <script>


        //TO STUDY
        function loadDashboardContent() {
            $("#content-container").load('<?php echo base_url('conAdmin/dashboard'); ?>');
        }
        function loadUserInfoContent() {
            $("#content-container").load('<?php echo base_url('conAdmin/userinfo'); ?>');
        }

        function loadProductContent() {
            $("#content-container").load('<?php echo base_url('conAdmin/products'); ?>');
        }
        //JQUERY

        function loadStocksContent() {
            $("#content-container").load('<?php echo base_url('conAdmin/stocks'); ?>');
        }

        function toggleSidebar() {
            const sidebar = document.querySelector(".sidebar");
            const content = document.querySelector(".content");

            if (sidebar.style.left === "0px") {
                sidebar.style.left = "-250px";
                content.style.marginLeft = "0";
            } else {
                sidebar.style.left = "0px";
                content.style.marginLeft = "250px";
            }
        }


        function admin() {
            var admin = confirm('Are you an admin?');
            if (admin == false) {
                event.preventDefault();
            }
        }
        function User() {
            var User = confirm('Are you sure you want to view User?');
            if (User == false) {
                event.preventDefault();
            }
        }





        function checker() {
            var result = confirm('Are you sure na gusto mo kong iwan?');
            if (result == false) {
                event.preventDefault();
            }
        }



    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>


</body>

</html> -->