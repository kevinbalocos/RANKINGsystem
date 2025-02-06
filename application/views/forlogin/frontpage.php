<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Front Page</title>
    <link rel="stylesheet"
        href="<?= base_url('assets/css/frontpage.css?v=' . filemtime('assets/css/frontpage.css')) ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link rel="icon"
        href="https://up.yimg.com/ib/th?id=OIP.LyQMxucs0UiwtrvJeT44MQHaFg&pid=Api&rs=1&c=1&qlt=95&w=145&h=108"
        type="image/jpg" title="Atom">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.css">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.all.min.js"></script>
    <!-- Add jQuery before SweetAlert2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <style>
        /* Basic custom styles for layout */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            overflow: hidden;
            max-height: 1000vh;
            /* Maximum height of the body */
        }

        .main-container {
            display: flex;
            padding: 2rem;
        }

        .left-section,
        .right-section {
            padding: 1.5rem;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .left-section {
            flex: 1;
            margin-right: 2rem;
        }

        .right-section {
            flex: 1;
            background-color: #ffffff;
            border-left: 1px solid #e5e7eb;
        }

        .filter-section {
            margin-bottom: 1.5rem;
        }

        .navbar {
            background-color: #00695c;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar .navbar-nav .nav-link {
            color: white;
            font-size: 1.1em;
        }

        .navbar .navbar-nav .nav-link:hover {
            color: #ffeb3b;
        }

        .hero {
            background: linear-gradient(to right, #00695c, #004d40);
            color: white;
            padding: 70px 20px;
            text-align: center;
            border-radius: 0 0 20px 20px;
        }

        .hero h1 {
            font-size: 3em;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.25em;
            margin-bottom: 30px;
        }

        .features .feature-box {
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            padding: 25px;
            background-color: #ffffff;
            text-align: center;
            transition: transform 0.3s ease-in-out;
            margin-top: 20px;
        }

        .features .feature-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .features .feature-box .icon {
            font-size: 50px;
            color: #00695c;
        }

        .features .feature-box h3 {
            font-size: 1.5em;
            margin: 20px 0;
        }

        .features .feature-box p {
            color: #6c757d;
        }

        .search-bar .input-group {
            border-radius: 30px;
            overflow: hidden;
        }

        .search-bar .form-control {
            border-radius: 30px;
            padding: 15px 25px;
            font-size: 1.1em;
        }

        .search-bar .btn {
            border-radius: 30px;
            background-color: #00695c;
            color: white;
            padding: 15px 25px;
            font-size: 1.1em;
            border: none;
        }

        .search-bar .btn:hover {
            background-color: #004d40;
        }

        .footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: 50px;
            border-top: 3px solid #00695c;
        }

        .footer a {
            color: #00c851;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        #content-container {
            margin-left: 0;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="<?= base_url('/design/images/greenSPClogo.avif') ?>" alt="Logo" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#" data-view="login">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" data-view="viewregister">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" data-view="viewadmin">Admin</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="<?= base_url('auth/aboutranking') ?>">About</a></li> -->
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('auth/contact') ?>">Contact</a></li>

                </ul>
            </div>
        </div>
    </nav>
    <div class="main-container">

        <!-- Left Section -->
        <div class="left-section">
            <!-- Dynamic Content Container -->
            <div id="content-container" class="container mt-4">
                <div class="text-center">
                    <h2>Welcome to the Platform</h2>
                    <p>Select a navigation item to get started.</p>

                </div>
            </div>
        </div>
        <div class="right-section bg-white rounded-xl shadow-lg p-6 w-full">
            <h4 class="text-center">User Status</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Date Registered</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($users) && !empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $user['username']; ?></td>
                                <td><?= $user['email']; ?></td>
                                <td>
                                    <?php
                                    switch ($user['status']) {
                                        case 'pending':
                                            echo '<span class="badge bg-warning">Pending</span>';
                                            break;
                                        case 'approved':
                                            echo '<span class="badge bg-success">Approved</span>';
                                            break;
                                        case 'rejected':
                                            echo '<span class="badge bg-danger">Rejected</span>';
                                            break;
                                    }
                                    ?>
                                </td>
                                <td><?= date('Y-m-d H:i:s', strtotime($user['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No pending users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>


    </div>

    <!-- Hero Section -->
    <div class="hero">
        <div class="container">
            <h1>Welcome to the HR Management Portal</h1>
            <p>Streamline your tasks, track rankings, and achieve more—all in one place!</p>
        </div>
    </div>
    <!-- <section class="features">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="bx bxs-dashboard icon"></i>
                        <h3>Dashboard</h3>
                        <p>Manage all your tasks and rankings in one streamlined dashboard.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="bx bx-user icon"></i>
                        <h3>User Management</h3>
                        <p>Effortlessly manage user data and roles within the system.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <i class="bx bx-bar-chart icon"></i>
                        <h3>Track Progress</h3>
                        <p>Monitor progress with advanced tracking and reporting tools.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container search-bar">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form id="searchForm">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="Search users, tasks, or rankings...">
                        <button type="submit" class="btn">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div> -->

    <!-- <footer class="footer">
        <p>&copy; <?= date('Y') ?> HR Management Portal. <a href="#">Privacy Policy</a></p>
    </footer> -->

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script>
        // Frontend Controller
        const app = {
            init: function () {
                this.bindEvents();
                this.restoreView();
            },

            bindEvents: function () {
                // Handle link navigation
                document.querySelectorAll('a[data-view]').forEach(link => {
                    link.addEventListener('click', this.navigate.bind(this));
                });

                // Handle popstate events
                window.addEventListener('popstate', this.handlePopState.bind(this));
            },

            navigate: function (event) {
                event.preventDefault();
                const view = event.target.getAttribute('data-view');
                if (view) {
                    this.loadView(view);
                    history.pushState({ view }, '', `?view=${view}`);
                }
            },

            loadView: function (view) {
                fetch(`<?= base_url('auth/') ?>${view}`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('content-container').innerHTML = html;
                    })
                    .catch(() => {
                        document.getElementById('content-container').innerHTML = '<p>Error loading content.</p>';
                    });
            },

            restoreView: function () {
                const params = new URLSearchParams(window.location.search);
                const view = params.get('view') || 'login'; // Default view
                this.loadView(view);
            },

            handlePopState: function (event) {
                if (event.state && event.state.view) {
                    this.loadView(event.state.view);
                }
            }
        };

        // Initialize the app
        document.addEventListener('DOMContentLoaded', () => app.init());
        // Disable zooming functionality
        document.addEventListener('wheel', function (event) {
            if (event.ctrlKey) {
                event.preventDefault(); // Prevent zooming on mouse wheel with ctrl
            }
        }, { passive: false });

        document.addEventListener('gesturestart', function (event) {
            event.preventDefault(); // Prevent pinch zoom on mobile devices
        });

    </script>
</body>

</html>