<?php
require_once('db.php');

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Sanitize the ID to prevent SQL injection
    $id = intval($id);

    // Delete student record from the students table
    $sql = "DELETE FROM students WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header('Location: admin_dashboard.php'); // Redirect to admin dashboard
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "No student ID provided.";
}
?>
