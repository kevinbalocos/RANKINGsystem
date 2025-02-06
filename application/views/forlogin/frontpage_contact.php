<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@heroicons/react@1.0.6/dist/outline.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Custom background gradient */
        .custom-bg {
            background-image: linear-gradient(to right, #00695c, #004d40);
            background-size: cover;
            background-position: center;
        }

        /* Apply the gradient to body */
        .bg-custom {
            background: linear-gradient(to right, #00695c, #004d40);
        }

        /* Apply gradient for buttons */
        .bg-custom-button {
            background-color: #00695c;
        }

        .bg-custom-button:hover {
            background-color: #004d40;
        }

        .text-custom {
            color: #004d40;
        }
    </style>
    <script>
        function toggleForm() {
            const formContainer = document.getElementById("contactForm");
            formContainer.classList.toggle("hidden");
        }
    </script>
</head>

<body class="bg-custom">

    <!-- Header Section -->
    <header class="bg-custom-button text-white py-2 shadow-md">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold">Contact Us</h1>
            <p class="mt-2 text-gray-200">We're here to help! Reach out to us anytime.</p>
        </div>
    </header>

    <!-- Contact Section -->
    <section class="relative h-screen">
        <!-- Map Background -->
        <div class="absolute inset-0">
            <iframe class="w-full h-full" frameborder="0" marginheight="0" marginwidth="0" title="map" scrolling="no"
                src="https://maps.google.com/maps?width=100%&height=600&hl=en&q=San%20Pablo%20Colleges&ie=UTF8&t=&z=14&iwloc=B&output=embed"
                style="filter: grayscale(1) contrast(1.2) opacity(0.6);"></iframe>
        </div>

        <!-- Eye Icon -->
        <div class="absolute top-10 left-10">
            <svg onclick="toggleForm()" xmlns="http://www.w3.org/2000/svg"
                class="h-8 w-8 text-white cursor-pointer hover:text-green-800 transition duration-200" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
            </svg>
        </div>

        <!-- Contact Form -->
        <div id="contactForm" class="absolute top-10 right-10 bg-white rounded-lg p-8 shadow-xl w-1/3">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Get in Touch</h2>
            <p class="text-gray-600 mb-6">
                Have questions or feedback? Drop us a message, and we'll get back to you as soon as possible.
            </p>
            <form action="<?php echo base_url('auth/contact_submit'); ?>" method="POST">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-600">Full Name</label>
                    <input type="text" id="name" name="name"
                        class="w-full bg-gray-100 rounded border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 text-gray-700 py-2 px-4 outline-none transition duration-200 ease-in-out"
                        placeholder="Jade Kevin Balocos" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-600">Email Address</label>
                    <input type="email" id="email" name="email"
                        class="w-full bg-gray-100 rounded border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 text-gray-700 py-2 px-4 outline-none transition duration-200 ease-in-out"
                        placeholder="jadekevin@example.com" required>
                </div>
                <div class="mb-4">
                    <label for="message" class="block text-sm font-medium text-gray-600">Your Message</label>
                    <textarea id="message" name="message"
                        class="w-full bg-gray-100 rounded border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 text-gray-700 py-2 px-4 h-32 resize-none outline-none transition duration-200 ease-in-out"
                        placeholder="Write your message here..." required></textarea>
                </div>
                <button type="submit"
                    class="w-full bg-custom-button text-white py-2 px-4 rounded hover:bg-custom-button transition duration-200">
                    Send Message
                </button>
            </form>
            <?php if (isset($error)): ?>
                <div class="text-red-500"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <div class="text-green-500"><?php echo $success; ?></div>
            <?php endif; ?>

        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-custom-button text-gray-200 py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Your Company Name. All Rights Reserved.</p>
        </div>
    </footer>

</body>

</html>