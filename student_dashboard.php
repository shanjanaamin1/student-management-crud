<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'student') {
    header('Location: index.php');
    exit();
}

require_once('db.php');

// Fetch student details
$email = $_SESSION['user'];
$sql = "SELECT * FROM students WHERE email='$email'";
$result = $conn->query($sql);
$student = $result->fetch_assoc();

// Fetch available courses (Demo 10-20 courses)
$courses_sql = "SELECT * FROM courses LIMIT 20"; // Fetch 20 demo courses
$courses_result = $conn->query($courses_sql);

// Fetch student's enrolled courses (if any)
$student_courses_sql = "SELECT c.course_name FROM student_courses sc JOIN courses c ON sc.course_id = c.id WHERE sc.student_id = {$student['id']}";
$student_courses_result = $conn->query($student_courses_sql);
$enrolled_courses = [];
while ($course = $student_courses_result->fetch_assoc()) {
    $enrolled_courses[] = $course['course_name'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Show a success alert message below the form
    $enrolled_courses_message = "You have successfully enrolled in the following courses:";
    $enrolled_courses_list = [];

    if (isset($_POST['courses'])) {
        // Store the selected courses in an array
        foreach ($_POST['courses'] as $course_id) {
            // Fetch course name based on the course_id
            $course_sql = "SELECT course_name FROM courses WHERE id = $course_id";
            $course_result = $conn->query($course_sql);
            $course = $course_result->fetch_assoc();

            $course_name = $course['course_name']; // Get the course name from the query result
            $enrolled_courses_list[] = $course_name;
        }
    }

    // Join the courses in a comma-separated string
    $enrolled_courses_message .= "<br>" . implode("<br>", $enrolled_courses_list);
}
?>

<!-- HTML form for course enrollment and success message -->



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#EEC15A20] m-0">

    <div class="container mx-auto p-6">
        <div class="flex gap-6 items-center h-[200px] mb-4">
            <img width="300" src="logo.png" alt="">
            <div>
                <h1 class="text-3xl font-bold mb-6">Welcome, <?php echo $student['name']; ?>!</h1>
                <a href="logout.php" class="bg-[#6A1A31] text-white px-4 py-2 rounded-md">Logout</a>
            </div>
        </div>

        <section class="flex gap-6">
            <!-- Profile Information -->
            <div class="bg-gradient-to-b from-[#EDD55E] to-[#EEC15A] p-6 mt-6 rounded-lg shadow-md w-[500px]">
                <h2 class="text-2xl font-semibold mb-4">Profile Information</h2>
                <form method="POST">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700">Name</label>
                        <input type="text" name="name" id="name" class="w-full p-2 border border-gray-300 rounded-md"
                            value="<?php echo htmlspecialchars($student['name']); ?>" required>
                    </div>
                    <div class="mb-4">
                        <label for="gpa" class="block text-gray-700">GPA</label>
                        <input type="text" name="gpa" id="gpa" class="w-full p-2 border border-gray-300 rounded-md"
                            value="<?php echo htmlspecialchars($student['gpa']); ?>" required>
                    </div>
                    <div class="mb-4">
                        <label for="degree" class="block text-gray-700">Degree</label>
                        <input type="text" name="degree" id="degree" class="w-full p-2 border border-gray-300 rounded-md"
                            value="<?php echo htmlspecialchars($student['degree']); ?>" required>
                    </div>
                    <button type="submit" class="bg-[#6A1A31] text-white px-4 py-2 rounded-md">Update Profile</button>
                </form>
            </div>

            <!-- Change Password -->
            <div class="bg-gradient-to-b from-[#EDD55E] to-[#EEC15A] p-6 mt-6 rounded-lg shadow-md w-[500px]">
                <h2 class="text-2xl font-semibold mb-4">Change Password</h2>
                <form method="POST">
                    <div class="mb-4">
                        <label for="new_password" class="block text-gray-700">New Password</label>
                        <input type="password" name="new_password" id="new_password" class="w-full p-2 border border-gray-300 rounded-md">
                    </div>
                    <button type="submit" class="bg-[#6A1A31] text-white px-4 py-2 rounded-md">Change Password</button>
                </form>
            </div>
        </section>

        <section class="mt-6">
            <!-- Available Courses -->
            <div class="bg-gradient-to-b from-[#fff] to-[#e4e4e4] p-4 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold mb-4">Enroll in Courses</h2>
                <form method="POST">
                    <div class="mb-4">
                        <label class="block text-gray-700">Select Courses</label>
                        <select name="courses[]" multiple class="w-full p-2 border border-gray-300 rounded-md">
                            <?php
                            while ($course = $courses_result->fetch_assoc()) {
                                $is_selected = in_array($course['course_name'], $enrolled_courses) ? 'selected' : '';
                                echo "<option value='{$course['id']}' $is_selected>{$course['course_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="bg-[#6A1A31] text-white px-4 py-2 rounded-md">Enroll</button>
                </form>

                <!-- Display success message for course enrollment -->
                <?php if (isset($enrolled_courses_message)): ?>
                    <div class="mt-6 p-4 bg-green-100 border border-green-300 text-green-700 rounded-md">
                        <strong>Success!</strong><br>
                        <?php echo $enrolled_courses_message; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <footer class="bg-[#6A1A31] p-6 mt-6">
        <p class="text-center text-white">Copyright © 2025 Shanjana Amin. All rights reserved.</p>
    </footer>
</body>

</html>