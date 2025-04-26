<?php
session_start();
require_once('db.php'); // Include your database connection
// If the user is not logged in, redirect them to login page

// Handle login after form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];  // This will be the email for both admin and student
    $password = $_POST['password'];
    $role = $_POST['role']; // Get selected role

    // Admin login check
    if ($role === 'admin') {
        $sql = "SELECT * FROM admins WHERE email='$username'"; // Query admins table
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verify the password using password_verify (since it's hashed in the database)
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user['email']; // Store email in session
                $_SESSION['role'] = 'admin'; // Set role to admin
                header('Location: admin_dashboard.php');  // Redirect to Admin Dashboard
                exit();
            } else {
                $login_error = "Invalid admin credentials.";
            }
        } else {
            $login_error = "Admin not found.";
        }
    }

    // Student login check
    elseif ($role === 'student') {
        $sql = "SELECT * FROM students WHERE email='$username'"; // Query students table
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verify the password using password_verify (since it's hashed in the database)
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user['email']; // Store email in session
                $_SESSION['role'] = 'student'; // Set role to student
                header('Location: student_dashboard.php');  // Redirect to Student Dashboard
                exit();
            } else {
                $login_error = "Invalid student credentials.";
            }
        } else {
            $login_error = "Student not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<style>
    /* Apply background image and opacity overlay */
    body {
        background-image: url('Background.png');
        background-size: cover;
        background-position: center;
    }
</style>

<body class="flex flex-col bg-[#EEC15A20] h-screen justify-center">

    <div class="flex justify-center items-center h-1/4">
        <img width="300" src="logo.png" alt="Logo">
    </div>

    <div class="flex justify-center items-center">
        <form method="POST" action="index.php" class="bg-gradient-to-b from-[#EDD55E] to-[#EEC15A] p-8 rounded-lg shadow-md w-96">
            <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

            <!-- Username (email in this case) -->
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Username (Email)</label>
                <input type="text" name="username" id="username" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
            </div>

            <!-- Role Selection (Admin or Student) -->
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Login as:</label>
                <div class="flex items-center space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="role" value="admin" class="form-radio text-indigo-600">
                        <span class="ml-2">Admin</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="role" value="student" class="form-radio text-indigo-600" checked>
                        <span class="ml-2">Student</span>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-[#6C1A31] text-white py-2 px-4 rounded hover:bg-[#6C1A1e]">Login</button>

            <?php if (isset($login_error)): ?>
                <p class="text-center text-red-500 mt-4"><?php echo $login_error; ?></p>
            <?php endif; ?>

            <!-- Registration Link -->
            <div class="mt-4 text-center">
                <p>Don't have an account? <a href="register.php" class="text-[#6C1A31] font-bold">Register here</a></p>
            </div>
        </form>
    </div>

</body>

</html>