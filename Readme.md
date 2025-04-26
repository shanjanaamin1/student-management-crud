# Student Management System

## Project Overview
This **Student Management System** allows administrators to manage student profiles, courses, and enrollment. The system provides secure login and registration functionalities for both **admin** and **student** users. It is designed to be easy to use and provides features like course enrollment, profile updates, and password management.

---

## Brand Name and Guidelines

### Brand Name:
**Aether University**

### Guidelines:

1. **UI/UX**:
   - The system should have a clean and minimalistic design.
   - Use the color `#EEC15A` as the primary brand color in the interface, ensuring all pages are aligned with the brand’s aesthetic.
   - Avoid overly complex layouts to maintain ease of use.

2. **Security**:
   - All passwords must be securely hashed before storage.
   - Use HTTPS (secure HTTP) for all pages requiring sensitive information.

3. **Role Management**:
   - Admins should have full access to student management features (add/edit/delete students and courses).
   - Students can only view and enroll in courses, and update their own profile information.
   
4. **Database Structure**:
   - The system uses separate tables for `students`, `courses`, and a junction table `student_courses` to manage the many-to-many relationship between students and courses.
   - The `admins` table stores admin user data separately from students.

---

## Setup and Installation

### Requirements:
- PHP (latest version recommended)
- MySQL or MariaDB database
- A web server such as Apache or Nginx

### Installation:

1. Clone the repository or download the project.
2. Import the database schema provided in the `database.sql` file.
3. Set up the necessary configurations in the `db.php` file, such as your database credentials.
4. Upload the project to your local server or web server (Apache or Nginx).
5. Navigate to `index.php` to begin using the application.

---

## Login Details

### Admin Login:
- **Username**: `samin@aum.edu`
- **Password**: `samin123`

### Student Login:
- **Username**: `saminst@aum.edu`
- **Password**: `samin1234`

---

## Features

### Admin Features:
1. **Dashboard**: 
   - View all students and courses.
   - Add, edit, or delete students and courses.
   
2. **Profile Management**: 
   - Admin can update their own profile information.

3. **Course Management**: 
   - Admin can create new courses, view all courses, and assign students to courses.

### Student Features:
1. **Dashboard**:
   - View all available courses.
   - Enroll in courses.
   - Update personal profile information (name, GPA, degree).
   - Change password.

2. **Profile Management**: 
   - Students can update their name, GPA, and degree.

3. **Course Enrollment**: 
   - Students can view available courses and enroll in them.

---

## File Structure

```plaintext
/
|-- db.php              # Database connection and configuration
|-- index.php           # Login page
|-- register.php        # Registration page
|-- student_dashboard.php  # Student dashboard
|-- admin_dashboard.php    # Admin dashboard
|-- logout.php          # Log out functionality
|-- add_student.php     # Add new student functionality
|-- delete_student.php  # Delete student functionality
|-- edit_student.php    # Edit student functionality
|-- student_courses.php # Handle student course enrollment
|-- assets/
    |-- logo.png        # Brand logo
    |-- images/         # Image assets for the UI
|-- README.md           # Project README
