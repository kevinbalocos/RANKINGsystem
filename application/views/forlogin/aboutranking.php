<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Your Platform</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f9f9f9;
            font-family: 'Arial', sans-serif;
        }

        .navbar {
            background-color: #2f4f4f;
        }

        .navbar-brand img {
            height: 40px;
        }

        .about-section {
            background-color: #ffffff;
            padding: 50px 0;
        }

        .about-heading {
            text-align: center;
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 40px;
        }

        .about-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .about-content .section {
            flex: 1 1 45%;
            margin: 10px;
            text-align: center;
        }

        .section img {
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .section h3 {
            color: #2f4f4f;
            font-size: 1.5rem;
            margin-top: 20px;
        }

        .section p {
            color: #555;
            font-size: 1rem;
            line-height: 1.6;
            padding: 0 20px;
        }

        .team-section {
            background-color: #e9f5f1;
            padding: 50px 0;
        }

        .team-heading {
            text-align: center;
            font-size: 2rem;
            color: #2f4f4f;
            margin-bottom: 40px;
        }

        .team-members {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .team-member {
            text-align: center;
            flex: 1 1 22%;
            margin: 10px;
        }

        .team-member img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .team-member h5 {
            color: #333;
            font-size: 1.2rem;
        }

        .team-member p {
            color: #777;
            font-size: 1rem;
            margin-top: 10px;
        }

        .footer {
            background-color: #2f4f4f;
            color: #fff;
            text-align: center;
            padding: 20px;
            margin-top: 50px;
        }

        .footer a {
            color: #66cdaa;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .about-content {
                flex-direction: column;
                align-items: center;
            }

            .about-content .section {
                flex: 1 1 80%;
                margin-bottom: 20px;
            }

            .team-member {
                flex: 1 1 48%;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="https://via.placeholder.com/150x50" alt="Logo">
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- About Section -->
    <!-- About Section -->
    <section class="about-section">
        <h2 class="about-heading">About Us</h2>
        <div class="about-content">
            <div class="section">
                <img src="https://via.placeholder.com/600x400" alt="About Image 1">
                <h3>Connecting with Our System</h3>
                <p>Our system is designed to provide a comprehensive and transparent ranking platform for ERs and
                    faculty in schools. We focus on empowering educational institutions by offering insights that help
                    improve the quality of education and foster healthy competition.</p>
            </div>
            <div class="section">
                <img src="https://via.placeholder.com/600x400" alt="About Image 2">
                <h3>Our Values</h3>
                <p>We value accuracy, fairness, and innovation in our ranking system. Our goal is to create a
                    transparent platform that recognizes the efforts of educators and institutions while helping them
                    improve and grow through detailed feedback and rankings.</p>
            </div>
        </div>
    </section>


    <!-- Team Section -->
    <!-- Team Section -->
    <section class="team-section">
        <h2 class="team-heading">Meet Our Team</h2>
        <div class="team-members">
            <div class="team-member">
                <img src="https://via.placeholder.com/150" alt="Team Member 1">
                <h5>Jade Kevin Balocos</h5>
                <p>Lead Developer</p>
                <p>UI/UX Specialist</p>
                <p>Database Administrator</p>
            </div>
            <div class="team-member">
                <img src="https://via.placeholder.com/150" alt="Team Member 2">
                <h5>Trina Marie Alcantara</h5>
                <p>Project Manager</p>
                <p>Managing the overall project, ensuring deadlines are met</p>
            </div>
            <div class="team-member">
                <img src="https://via.placeholder.com/150" alt="Team Member 3">
                <h5>Richmond Besmonte</h5>
                <p>Developer</p>
                <p>Quality Assurance Lead</p>

            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer class="footer">
        <p>&copy; <?= date('Y'); ?> Ranking System. All Rights Reserved.</p>
        <p>
            <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
        </p>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-qN6g2Rfs0KI3RZ2c2fE2pQeNpLpkzBwYmsrDwt/1lOVFNrS7SWzC12ZcdiTX+LfI"
        crossorigin="anonymous"></script>
</body>

</html>