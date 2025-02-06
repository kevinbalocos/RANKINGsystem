<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>FACULTY MANUAL</title>
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
            /* Adjusting for header height */
            overflow: hidden;
        }

        .left-section,
        .right-section {
            overflow-y: auto;
            padding: 1rem;
            margin: 20px;
        }

        .left-section {
            flex: 1;
            background-color: #f9fafb;
        }

        .right-section {
            flex: 1;

        }


        .filter-section {
            margin-bottom: 1.5rem;
        }

        .filter-section select {
            width: 100%;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            font-size: 1rem;
            background-color: #ffffff;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header class="bg-white shadow px-6 py-3">
        <h1 class="text-2xl font-bold text-gray-800">FACULTY MANUAL</h1>
    </header>
    <!-- Main Content -->
    <div class="main-container">

        <!-- Left Section -->
        <div class="left-section bg-white rounded-xl shadow-lg p-6 w-full">

            <div class="container mx-auto">

                <!-- Section Title -->
                <h2 class="text-center text-3xl font-semibold mb-6 text-gray-800">Criteria for Merit Cash Incentive</h2>

                <!-- Teaching Performance -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">1. Teaching Performance and Efficiency of
                        School Service</h3>

                    <h4 class="text-lg font-medium text-gray-600 mt-4">1.1 Teaching Experience</h4>
                    <p class="text-gray-600">Maximum of 7</p>

                    <h4 class="text-lg font-medium text-gray-600 mt-4">1.2 Continuing Professional Development</h4>
                    <p class="text-gray-600">Maximum of 7 (Participation in seminars, conferences, etc. for the last
                        three years)</p>

                    <!-- Table for Professional Development -->
                    <table class="min-w-full table-auto mt-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3 text-left text-sm font-semibold text-gray-700">Level</th>
                                <th class="p-3 text-left text-sm font-semibold text-gray-700">Organizer</th>
                                <th class="p-3 text-left text-sm font-semibold text-gray-700">Resource Speaker</th>
                                <th class="p-3 text-left text-sm font-semibold text-gray-700">Demonstration
                                    Teacher/Paper Presenter</th>
                                <th class="p-3 text-left text-sm font-semibold text-gray-700">Emcee</th>
                                <th class="p-3 text-left text-sm font-semibold text-gray-700">Participant</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">School</td>
                                <td class="p-3 text-sm text-gray-600">0.50</td>
                                <td class="p-3 text-sm text-gray-600">0.25</td>
                                <td class="p-3 text-sm text-gray-600">0.15</td>
                                <td class="p-3 text-sm text-gray-600">0.15</td>
                                <td class="p-3 text-sm text-gray-600">0.10</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">District/Municipality</td>
                                <td class="p-3 text-sm text-gray-600">0.75</td>
                                <td class="p-3 text-sm text-gray-600">0.50</td>
                                <td class="p-3 text-sm text-gray-600">0.25</td>
                                <td class="p-3 text-sm text-gray-600">0.25</td>
                                <td class="p-3 text-sm text-gray-600">0.15</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Division/Provincial</td>
                                <td class="p-3 text-sm text-gray-600">1.00</td>
                                <td class="p-3 text-sm text-gray-600">0.75</td>
                                <td class="p-3 text-sm text-gray-600">0.50</td>
                                <td class="p-3 text-sm text-gray-600">0.50</td>
                                <td class="p-3 text-sm text-gray-600">0.25</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Regional</td>
                                <td class="p-3 text-sm text-gray-600">1.25</td>
                                <td class="p-3 text-sm text-gray-600">1.00</td>
                                <td class="p-3 text-sm text-gray-600">0.75</td>
                                <td class="p-3 text-sm text-gray-600">0.75</td>
                                <td class="p-3 text-sm text-gray-600">0.50</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">National</td>
                                <td class="p-3 text-sm text-gray-600">1.50</td>
                                <td class="p-3 text-sm text-gray-600">1.25</td>
                                <td class="p-3 text-sm text-gray-600">1.00</td>
                                <td class="p-3 text-sm text-gray-600">1.00</td>
                                <td class="p-3 text-sm text-gray-600">0.75</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">International</td>
                                <td class="p-3 text-sm text-gray-600">1.75</td>
                                <td class="p-3 text-sm text-gray-600">1.50</td>
                                <td class="p-3 text-sm text-gray-600">1.25</td>
                                <td class="p-3 text-sm text-gray-600">1.25</td>
                                <td class="p-3 text-sm text-gray-600">1.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Research and Publications -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">2. Research and Publications</h3>
                    <p class="text-gray-600">Maximum of 8</p>

                    <table class="min-w-full table-auto mt-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3 text-left text-sm font-semibold text-gray-700">Category</th>
                                <th class="p-3 text-left text-sm font-semibold text-gray-700">Points per Instance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Thesis/Dissertation Adviser</td>
                                <td class="p-3 text-sm text-gray-600">0.75</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Action Research Done</td>
                                <td class="p-3 text-sm text-gray-600">1.00</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Monograph Published</td>
                                <td class="p-3 text-sm text-gray-600">1.50</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Column in Local Publication</td>
                                <td class="p-3 text-sm text-gray-600">1.00</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Research Panel outside the school</td>
                                <td class="p-3 text-sm text-gray-600">1.50</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Referee of an Outside Publication</td>
                                <td class="p-3 text-sm text-gray-600">3.00</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Instructional Material Published</td>
                                <td class="p-3 text-sm text-gray-600">3.00</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Article Published</td>
                                <td class="p-3 text-sm text-gray-600">4.00</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Commissioned Research</td>
                                <td class="p-3 text-sm text-gray-600">5.00</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Commissioned Research (Data Gathering)</td>
                                <td class="p-3 text-sm text-gray-600">3.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Leadership/Professional Services -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">2.2 Leadership/Professional Services</h3>
                    <p class="text-gray-600">Maximum of 8</p>

                    <table class="min-w-full table-auto mt-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3 text-left text-sm font-semibold text-gray-700">Category</th>
                                <th class="p-3 text-left text-sm font-semibold text-gray-700">Points per Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Principal</td>
                                <td class="p-3 text-sm text-gray-600">0.50</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Asst. Principal</td>
                                <td class="p-3 text-sm text-gray-600">0.25</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Chief Adviser</td>
                                <td class="p-3 text-sm text-gray-600">0.25</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Subject Coordinator/Program Chair</td>
                                <td class="p-3 text-sm text-gray-600">0.25</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Trainer in Contest</td>
                                <td class="p-3 text-sm text-gray-600">0.10 per contest won</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Master of Ceremonies (last three years)</td>
                                <td class="p-3 text-sm text-gray-600">0.10</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Membership in Professional/Civic/Religious
                                    Organizations</td>
                                <td <td class="p-3 text-sm text-gray-600">0.10 per organization</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Officer in Professional/Civic/Religious
                                    Organizations</td>
                                <td class="p-3 text-sm text-gray-600">0.25 per organization</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Guest Speaker</td>
                                <td class="p-3 text-sm text-gray-600">0.25 per engagement</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Judge in a Contest</td>
                                <td class="p-3 text-sm text-gray-600">0.10 per occasion</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
        <!-- Right Section -->
        <div class="right-section bg-white rounded-xl shadow-lg p-6 w-full">

            <div class="overflow-x-auto">
                <h3 class="text-lg font-semibold text-gray-800 mt-4">2.3 Community Service</h3>
                <p class="text-sm text-gray-600 mb-4">One point per hour of community service during the school year
                    (Maximum of 5).</p>

                <h3 class="text-lg font-semibold text-gray-800 mt-4">2.4 Honors/Awards/Recognition</h3>
                <p class="text-sm text-gray-600 mb-4">Maximum of 5</p>

                <div class="overflow-x-auto mb-6">
                    <table class="table-auto w-full border-collapse border border-gray-300 rounded-lg shadow-sm">
                        <thead class="bg-gray-100 text-gray-800">
                            <tr>
                                <th class="p-3 border"> </th>
                                <th class="p-3 border">School</th>
                                <th class="p-3 border">Division/Regional</th>
                                <th class="p-3 border">National</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Winner</td>
                                <td class="p-3 text-sm text-gray-600">1.00</td>
                                <td class="p-3 text-sm text-gray-600">0.50</td>
                                <td class="p-3 text-sm text-gray-600">0.25</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Finalist</td>
                                <td class="p-3 text-sm text-gray-600">2.00</td>
                                <td class="p-3 text-sm text-gray-600">1.00</td>
                                <td class="p-3 text-sm text-gray-600">0.50</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Citation</td>
                                <td class="p-3 text-sm text-gray-600">3.00</td>
                                <td class="p-3 text-sm text-gray-600">1.50</td>
                                <td class="p-3 text-sm text-gray-600">1.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3 class="text-lg font-semibold text-gray-800 mt-4">2.5 Teaching Performance Rating (Last two years)
                </h3>
                <p class="text-sm text-gray-600 mb-4">Maximum of 35</p>

                <div class="overflow-x-auto mb-6">
                    <table class="table-auto w-full border-collapse border border-gray-300 rounded-lg shadow-sm">
                        <thead class="bg-gray-100 text-gray-800">
                            <tr>
                                <th class="p-3 border">Performance Level</th>
                                <th class="p-3 border">Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Excellent</td>
                                <td class="p-3 text-sm text-gray-600">35</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Very Satisfactory</td>
                                <td class="p-3 text-sm text-gray-600">30</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Satisfactory</td>
                                <td class="p-3 text-sm text-gray-600">25</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3 class="text-lg font-semibold text-gray-800 mt-4">2.6 Efficiency of School Service (Last two years)
                </h3>
                <p class="text-sm text-gray-600 mb-4">Maximum of 20</p>

                <div class="overflow-x-auto mb-6">
                    <table class="table-auto w-full border-collapse border border-gray-300 rounded-lg shadow-sm">
                        <thead class="bg-gray-100 text-gray-800">
                            <tr>
                                <th class="p-3 border">Category</th>
                                <th class="p-3 border">Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Class Attendance</td>
                                <td class="p-3 text-sm text-gray-600">5</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Attendance in Faculty Meetings/School Activities
                                    for the Academic Year</td>
                                <td class="p-3 text-sm text-gray-600">5</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Submission of Grades, Reports, Assignments,
                                    Syllabi, Course Outlines</td>
                                <td class="p-3 text-sm text-gray-600">5</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-sm text-gray-600">Accomplishment of Committee Assignments</td>
                                <td class="p-3 text-sm text-gray-600">5</td>
                            </tr>
                            <tr class="hover:bg-gray-50">

                                <td class="p-3 text-sm text-gray-600">
                                    <h4 class="text-md font-semibold text-gray-800 mb-4">2.7 Accountability</h4>
                                    Includes care of property and equipment; participation in
                                    achieving budget and cost-cutting measures; timely remittance of collections and
                                    liquidation of cash
                                    advances.
                                </td>
                                <td class="p-3 text-sm text-gray-600">Maximum of 5</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <section class="mt-6">
                    <h3 class="text-2xl font-semibold text-gray-900">3. Merit Pay Scheme</h3>
                </section>

                <div class="overflow-x-auto mb-6">
                    <table class="w-full border-collapse border border-gray-300 rounded-lg shadow-sm">
                        <thead class="bg-gray-200 text-gray-900">
                            <tr>
                                <th class="p-3 border">Merit Points</th>
                                <th class="p-3 border">Cash Incentive</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr class="bg-white hover:bg-gray-100">
                                <td class="p-3 border">90 and above</td>
                                <td class="p-3 border">₱10,000</td>
                            </tr>
                            <tr class="bg-gray-50 hover:bg-gray-100">
                                <td class="p-3 border">80 - 89</td>
                                <td class="p-3 border">₱5,000</td>
                            </tr>
                            <tr class="bg-gray-50 hover:bg-gray-100">
                                <td class="p-3 border">70-79</td>
                                <td class="p-3 border">₱3,000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>