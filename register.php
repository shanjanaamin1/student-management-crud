<?php
require_once('db.php'); // Include database connection

// If the user is not logged in, redirect them to login page

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];  // Plain text password from form
    $role = $_POST['role'];  // Admin or Student
    $name = $_POST['name'];  // Name of the user
    $age = $_POST['age'];    // Age of the user
    $gpa = $_POST['gpa'];    // GPA (only for students)
    $degree = $_POST['degree'];  // Degree (only for students)

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into the correct table based on the role
    if ($role == 'admin') {
        // Insert into the admins table
        $sql = "INSERT INTO admins (email, password, name) 
                VALUES ('$email', '$hashed_password', '$name')";
    } else if ($role == 'student') {
        // Insert into the students table
        $sql = "INSERT INTO students (email, password, role, name, age, gpa, degree) 
                VALUES ('$email', '$hashed_password', 'student', '$name', '$age', '$gpa', '$degree')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "New user created successfully.";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();  // Close the connection
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Student Management</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Apply background image and opacity overlay */
        body {
            background-image: url('Background.png');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="flex flex-col bg-[#EEC15A20] h-auto justify-top">

    <div class="flex justify-center items-center py-2">
        <img width="300" src="logo.png" alt="Logo">
    </div>

    <div class="flex justify-center items-center">
        <form method="POST" action="register.php" class="bg-gradient-to-b from-[#EDD55E] to-[#EEC15A] p-8 rounded-lg shadow-md w-[500px]">
            <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
            </div>

            <!-- Role Selection -->
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Role:</label>
                <select name="role" class="w-full p-2 border border-gray-300 rounded" required>
                    <option value="admin">Admin</option>
                    <option value="student">Student</option>
                </select>
            </div>

            <!-- Additional Fields for Students -->
            <div class="mb-4">
                <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                <input type="number" name="age" id="age" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div class="mb-4">
                <label for="gpa" class="block text-sm font-medium text-gray-700">GPA</label>
                <input type="text" name="gpa" id="gpa" class="w-full p-2 border border-gray-300 rounded">
            </div>

            <div class="mb-4">
                <label for="degree" class="block text-sm font-medium text-gray-700">Degree</label>
                <input type="text" name="degree" id="degree" class="w-full p-2 border border-gray-300 rounded">
            </div>

            <button type="submit" class="w-full bg-[#6C1A31] text-white py-2 px-4 rounded hover:bg-dark">Register</button>
            <!-- Sign In Link -->
            <div class="flex justify-center mt-4">
                <p class="text-sm">Already have an account? <a href="index.php" class="text-[#6C1A31] font-bold hover:text-blue-700">Sign In</a></p>
            </div>
        </form>
    </div>


</body>

</html>