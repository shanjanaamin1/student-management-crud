// Add student
function addStudent() {
  const name = document.getElementById("name").value;
  const email = document.getElementById("email").value;
  const age = document.getElementById("age").value;
  const gpa = document.getElementById("gpa").value;
  const degree = document.getElementById("degree").value;
  const password = document.getElementById("password").value; // New password field

  // Check if required fields are filled
  if (!name || !email || !age || !password) {
    alert("Please fill out all required fields.");
    return;
  }

  const formData = new FormData();
  formData.append("name", name);
  formData.append("email", email);
  formData.append("age", age);
  formData.append("gpa", gpa);
  formData.append("degree", degree);
  formData.append("password", password); // Send password to backend

  fetch("addStudent.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((data) => {
      if (data.includes("New record created")) {
        fetchStudents(); // Refresh the student table
        alert("Student added successfully!");
      } else {
        alert("Error adding student. Please try again.");
      }
    });
}

// Fetch all students
function fetchStudents() {
  fetch("getStudents.php")
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("student-table").innerHTML = data;
    });
}

// Search students
function searchStudent() {
  const searchTerm = document.getElementById("search").value;
  fetch(`searchStudent.php?searchTerm=${searchTerm}`)
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("student-table").innerHTML = data;
    });
}

// Delete student
function deleteStudent(id) {
  fetch(`deleteStudent.php?id=${id}`)
    .then((response) => response.text())
    .then((data) => {
      fetchStudents(); // Refresh the table after deleting
    });
}

// Admin and Student Login handling
const validAdminUsername = "admin"; // Hardcoded admin username
const validAdminPassword = "password123"; // Hardcoded admin password

// Handle login for Admin or Student
function login() {
  const loginType = document.getElementById("login-type").value; // Get selected login type
  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;
  const email = document.getElementById("email").value; // For student login

  if (loginType === "admin") {
    // Admin login
    if (username === validAdminUsername && password === validAdminPassword) {
      document.getElementById("login-container").classList.add("hidden");
      document.getElementById("app").classList.remove("hidden");
    } else {
      document.getElementById("login-error").classList.remove("hidden");
      document.getElementById("login-error").textContent =
        "Invalid Admin credentials.";
    }
  } else if (loginType === "student") {
    // Student login
    fetch(`validateStudent.php?email=${email}&password=${password}`)
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "success") {
          document.getElementById("login-container").classList.add("hidden");
          document
            .getElementById("student-dashboard")
            .classList.remove("hidden");
        } else {
          document.getElementById("login-error").classList.remove("hidden");
          document.getElementById("login-error").textContent =
            "Invalid Student credentials.";
        }
      });
  }
}

// Call fetchStudents() to load data when the page loads
window.onload = fetchStudents;
