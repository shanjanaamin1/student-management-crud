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

// Check if the course ID is provided in the URL
if (isset($_GET['id'])) {
    $course_id = $_GET['id'];

    // Fetch the current course details from the database
    $sql = "SELECT * FROM courses WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $course_id); // Bind the course ID parameter
        $stmt->execute();
        $result = $stmt->get_result();
        
        // If course is found, populate the form
        if ($result->num_rows == 1) {
            $course = $result->fetch_assoc();
        } else {
            echo "<p class='text-red-500'>Course not found.</p>";
            exit();
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<p class='text-red-500'>Error fetching course data. Please try again.</p>";
        exit();
    }
} else {
    echo "<p class='text-red-500'>Invalid request. No course ID provided.</p>";
    exit();
}

// Handle form submission to update course
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $course_name = $_POST['course_name'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];

    // Validate input (basic validation)
    if (!empty($course_name) && !empty($description) && !empty($duration)) {
        // Prepare the SQL query to update the course data
        $sql = "UPDATE courses SET course_name = ?, description = ?, duration = ?, updated_at = NOW() WHERE id = ?";
        
        // Prepare statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters
            $stmt->bind_param("sssi", $course_name, $description, $duration, $course_id);

            // Execute the query
            if ($stmt->execute()) {
                echo "<p class='text-green-500'>Course updated successfully!</p>";
                // Redirect back to the dashboard
                header("Location: admin_dashboard.php");
                exit();
            } else {
                echo "<p class='text-red-500'>Error: Could not update course. Please try again.</p>";
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
    <title>Edit Course</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#EEC15A20] m-0">

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Edit Course: <?php echo htmlspecialchars($course['course_name']); ?></h1>

        <form method="POST" action="edit_course.php?id=<?php echo $course_id; ?>"
            class="bg-gradient-to-b from-[#EDD55E] to-[#EEC15A] p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="course_name" class="block text-gray-700">Course Name</label>
                <input type="text" name="course_name" id="course_name" class="w-full p-2 border border-gray-300 rounded-md"
                    value="<?php echo htmlspecialchars($course['course_name']); ?>" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4" class="w-full p-2 border border-gray-300 rounded-md"
                    required><?php echo htmlspecialchars($course['description']); ?></textarea>
            </div>
            <div class="mb-4">
                <label for="duration" class="block text-gray-700">Duration</label>
                <input type="text" name="duration" id="duration" class="w-full p-2 border border-gray-300 rounded-md"
                    value="<?php echo htmlspecialchars($course['duration']); ?>" required>
            </div>
            <button type="submit" class="bg-[#6A1A31] text-white px-4 py-2 rounded-md">Update Course</button>
        </form>
    </div>

</body>

</html>
