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

    // Prepare SQL query to delete the course
    $sql = "DELETE FROM courses WHERE id = ?";
    
    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("i", $course_id);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect back to the dashboard after deletion
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "<p class='text-red-500'>Error: Could not delete the course. Please try again.</p>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<p class='text-red-500'>Error preparing the delete query. Please try again.</p>";
    }
} else {
    echo "<p class='text-red-500'>Invalid request. No course ID provided.</p>";
}

// Close the database connection
$conn->close();
?>
