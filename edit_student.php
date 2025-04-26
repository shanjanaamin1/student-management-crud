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

// Check if the student ID is provided in the URL
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Fetch the current student details from the database
    $sql = "SELECT * FROM students WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $student_id); // Bind the student ID parameter
        $stmt->execute();
        $result = $stmt->get_result();

        // If student is found, populate the form
        if ($result->num_rows == 1) {
            $student = $result->fetch_assoc();
        } else {
            echo "<p class='text-red-500'>Student not found.</p>";
            exit();
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<p class='text-red-500'>Error fetching student data. Please try again.</p>";
        exit();
    }
} else {
    echo "<p class='text-red-500'>Invalid request. No student ID provided.</p>";
    exit();
}

// Handle form submission to update student data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $gpa = $_POST['gpa'];
    $degree = $_POST['degree'];

    // Validate input (basic validation)
    if (!empty($name) && !empty($email) && !empty($age)) {
        // Prepare the SQL query to update student data
        $sql = "UPDATE students SET name = ?, email = ?, age = ?, gpa = ?, degree = ?, updated_at = NOW() WHERE id = ?";

        // Prepare statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters
            $stmt->bind_param("sssssi", $name, $email, $age, $gpa, $degree, $student_id);

            // Execute the query
            if ($stmt->execute()) {
                echo "<p class='text-green-500'>Student updated successfully!</p>";
                // Redirect back to the dashboard
                header("Location: admin_dashboard.php");
                exit();
            } else {
                echo "<p class='text-red-500'>Error: Could not update student. Please try again.</p>";
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
    <title>Edit Student</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#EEC15A20] m-0">

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Edit Student: <?php echo htmlspecialchars($student['name']); ?></h1>

        <form method="POST" action="edit_student.php?id=<?php echo $student_id; ?>"
            class="bg-gradient-to-b from-[#EDD55E] to-[#EEC15A] p-6 rounded-lg shadow-md mb-4">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" name="name" id="name" class="w-full p-2 border border-gray-300 rounded-md"
                    value="<?php echo htmlspecialchars($student['name']); ?>" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="w-full p-2 border border-gray-300 rounded-md"
                    value="<?php echo htmlspecialchars($student['email']); ?>" required>
            </div>
            <div class="mb-4">
                <label for="age" class="block text-gray-700">Age</label>
                <input type="number" name="age" id="age" class="w-full p-2 border border-gray-300 rounded-md"
                    value="<?php echo htmlspecialchars($student['age']); ?>" required>
            </div>
            <div class="mb-4">
                <label for="gpa" class="block text-gray-700">GPA</label>
                <input type="text" name="gpa" id="gpa" class="w-full p-2 border border-gray-300 rounded-md"
                    value="<?php echo htmlspecialchars($student['gpa']); ?>">
            </div>
            <div class="mb-4">
                <label for="degree" class="block text-gray-700">Degree</label>
                <input type="text" name="degree" id="degree" class="w-full p-2 border border-gray-300 rounded-md"
                    value="<?php echo htmlspecialchars($student['degree']); ?>">
            </div>
            <button type="submit" class="bg-[#6A1A31] text-white px-4 py-2 rounded-md">Update Student</button>
        </form>
        <a href="admin_dashboard.php" class="bg-[#EEC15A] text-white px-4 py-2 rounded-md">Back</a>
    </div>

</body>

</html>