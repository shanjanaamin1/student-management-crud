<?php
// Start session
session_start();

// Check if the user is an admin
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header('Location: index.php');
    exit();
}

// Include database connection
require_once('db.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $course_name = $_POST['course_name'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];

    // Validate input (basic validation)
    if (!empty($course_name) && !empty($description) && !empty($duration)) {
        // Prepare the SQL query to insert course data into the database
        $sql = "INSERT INTO courses (course_name, description, duration, created_at) 
                VALUES (?, ?, ?, NOW())";

        // Prepare statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters
            $stmt->bind_param("sss", $course_name, $description, $duration);

            // Execute the query
            if ($stmt->execute()) {
                echo "<p class='text-green-500'>Course added successfully!</p>";
                // Redirect back to the dashboard
                header("Location: admin_dashboard.php");
                exit();
            } else {
                echo "<p class='text-red-500'>Error: Could not add course. Please try again.</p>";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "<p class='text-red-500'>Error preparing query. Please try again.</p>";
        }
    } else {
        echo "<p class='text-red-500'>All fields are required!</p>";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#EEC15A20] m-0">

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Add New Course</h1>

        <form method="POST" action="add_course.php" class="bg-gradient-to-b from-[#EDD55E] to-[#EEC15A] p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="course_name" class="block text-gray-700">Course Name</label>
                <input type="text" name="course_name" id="course_name" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4" class="w-full p-2 border border-gray-300 rounded-md" required></textarea>
            </div>
            <div class="mb-4">
                <label for="duration" class="block text-gray-700">Duration</label>
                <input type="text" name="duration" id="duration" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <button type="submit" class="bg-[#6A1A31] text-white px-4 py-2 rounded-md">Add Course</button>
        </form>
    </div>

</body>
</html>
