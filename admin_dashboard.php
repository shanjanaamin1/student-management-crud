<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header('Location: index.php');
    exit();
}

require_once('db.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Student Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#EEC15A20] m-0">

    <div class="container mx-auto p-6">
        <div class="flex gap-6 items-center h-[200px] mb-4">
            <img width="300" src="logo.png" alt="">
            <div>
                <h1 class="text-3xl font-bold mb-6">Welcome to Student Management Dashboard</h1>
                <div>
                    <a href="logout.php" class="bg-[#6A1A31] text-white px-4 py-2 rounded-md">Logout</a>
                    <a href="#" class="bg-[#EEC15A] text-dark px-4 py-2 rounded-md">Github Link</a>
                </div>
            </div>
        </div>

        <section class="flex gap-6">
            <!-- First row: Add student form and display students -->
            <div class="w-[500px] bg-gradient-to-b from-[#EDD55E] to-[#EEC15A] p-6 mt-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold mb-4">Add Student</h2>
                <form method="POST" action="add_student.php">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700">Name</label>
                        <input type="text" name="name" id="name" class="w-full p-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Email</label>
                        <input type="email" name="email" id="email" class="w-full p-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label for="age" class="block text-gray-700">Age</label>
                        <input type="number" name="age" id="age" class="w-full p-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label for="gpa" class="block text-gray-700">GPA</label>
                        <input type="text" name="gpa" id="gpa" class="w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="degree" class="block text-gray-700">Degree</label>
                        <input type="text" name="degree" id="degree" class="w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <button type="submit" class="bg-[#6A1A31] text-white px-4 py-2 rounded-md">Add Student</button>
                </form>
            </div>

            <!-- Display all students -->
            <div class="w-[1000px] bg-gradient-to-b from-[#fff] to-[#e4e4e4] p-4 mt-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold mb-4">All Students</h2>
                <?php
                $sql = "SELECT * FROM students";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo "<table class='min-w-full border-collapse'>";
                    echo "<thead><tr><th class='px-4 py-2 border'>Name</th><th class='px-4 py-2 border'>Email</th><th class='px-4 py-2 border'>Age</th><th class='px-4 py-2 border'>GPA</th><th class='px-4 py-2 border'>Degree</th><th class='px-4 py-2 border'>Actions</th></tr></thead>";
                    echo "<tbody>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td class='px-4 py-2 border'>{$row['name']}</td>
                                <td class='px-4 py-2 border'>{$row['email']}</td>
                                <td class='px-4 py-2 border'>{$row['age']}</td>
                                <td class='px-4 py-2 border'>{$row['gpa']}</td>
                                <td class='px-4 py-2 border'>{$row['degree']}</td>
                                <td class='px-4 py-2 border'>
                                    <a href='edit_student.php?id={$row['id']}' class='text-blue-500'>Edit</a> | 
                                    <a href='delete_student.php?id={$row['id']}' class='text-red-500' onclick=\"return confirm('Are you sure you want to delete this student?')\">Delete</a>
                                </td>
                              </tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<p>No students found.</p>";
                }
                ?>
            </div>
        </section>

        <section class="flex gap-6 mt-6">
            <!-- Second row: Add course form -->
            <div class="w-full sm:w-[500px] bg-gradient-to-b from-[#EDD55E] to-[#EEC15A] p-6 mt-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold mb-4">Create Course</h2>
                <form method="POST" action="add_course.php">
                    <div class="mb-4">
                        <label for="course_name" class="block text-gray-700">Course Name</label>
                        <input type="text" name="course_name" id="course_name" class="w-full p-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700">Description</label>
                        <input type="text" name="description" id="description" class="w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="duration" class="block text-gray-700">Duration</label>
                        <input type="text" name="duration" id="duration" class="w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <button type="submit" class="bg-[#6A1A31] text-white px-4 py-2 rounded-md">Create Course</button>
                </form>
            </div>

            <!-- Display all courses -->
            <div class="w-full sm:w-[1000px] bg-gradient-to-b from-[#fff] to-[#e4e4e4] p-4 mt-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold mb-4">All Courses</h2>
                <?php
                $sql = "SELECT * FROM courses";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo "<table class='min-w-full border-collapse'>";
                    echo "<thead><tr><th class='px-4 py-2 border'>Course Name</th><th class='px-4 py-2 border'>Description</th><th class='px-4 py-2 border'>Duration</th><th class='px-4 py-2 border'>Actions</th></tr></thead>";
                    echo "<tbody>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td class='px-4 py-2 border'>{$row['course_name']}</td>
                                <td class='px-4 py-2 border'>{$row['description']}</td>
                                <td class='px-4 py-2 border'>{$row['duration']}</td>
                                <td class='px-4 py-2 border'>
                                    <a href='edit_course.php?id={$row['id']}' class='text-blue-500'>Edit</a> | 
                                    <a href='delete_course.php?id={$row['id']}' class='text-red-500' onclick=\"return confirm('Are you sure you want to delete this course?')\">Delete</a>
                                </td>
                              </tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<p>No courses found.</p>";
                }
                ?>
            </div>
        </section>

    </div>

    <footer class="bg-[#6A1A31] p-6">
        <p class="text-center text-white">Copyright © 2025 Shanjana Amin. All rights reserved.</p>
    </footer>

</body>

</html>