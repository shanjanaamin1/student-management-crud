<?php
require_once('db.php'); // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $gpa = $_POST['gpa'];
    $degree = $_POST['degree'];
    $password = $_POST['password'];  // New password field

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into the students table (since we now have a separate students table)
    $sql = "INSERT INTO students (name, email, age, gpa, degree, password) 
            VALUES ('$name', '$email', '$age', '$gpa', '$degree', '$hashed_password')";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect to admin dashboard after successful student addition
        header('Location: admin_dashboard.php');  // Updated redirect to admin dashboard
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#EEC15A20] m-0">

    <div class="container mx-auto p-6">
        <div class="flex justify-center items-center h-1/4">
            <img width="300" src="logo.png" alt="Aether University Logo">
        </div>

        <div class="bg-gradient-to-b from-[#EDD55E] to-[#EEC15A] p-6 mt-6 rounded-lg shadow-md w-[500px] mx-auto">
            <h2 class="text-2xl font-semibold mb-4">Add Student</h2>
            <form method="POST">
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
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="w-full p-2 border border-gray-300 rounded-md" required>
                </div>
                <button type="submit" class="bg-[#6A1A31] text-white px-4 py-2 rounded-md">Add Student</button>
            </form>
        </div>
    </div>

</body>
</html>
