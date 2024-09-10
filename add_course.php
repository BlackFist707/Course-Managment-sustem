<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Add Course</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="add_instructor.php">Add Instructor</a></li>
                <li><a href="add_student.php">Add Student</a></li>
                <li><a href="enroll_student.php">Enroll Student</a></li>
                <li><a href="view_schedules.php">View Schedules</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Add a New Course</h2>
        <form action="add_course.php" method="POST">
            <input type="text" name="course_name" placeholder="Course Name" required>
            <input type="number" name="credits" placeholder="Credits" required>
            <input type="text" name="department" placeholder="Department" required>
            <select name="prerequisites[]" multiple>
                <?php
                // Fetch all courses for the prerequisites dropdown
                $sql = "SELECT course_id, course_name FROM courses";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['course_id'] . "'>" . $row['course_name'] . "</option>";
                }
                ?>
            </select>
            <!-- Schedule inputs -->
            <h3>Schedule</h3>
            <select name="instructor_id" required>
                <?php
                // Fetch all instructors for the instructor dropdown
                $sql = "SELECT instructor_id, instructor_name FROM instructors";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['instructor_id'] . "'>" . $row['instructor_name'] . "</option>";
                }
                ?>
            </select>
            <input type="text" name="semester" placeholder="Semester" required>
            <input type="number" name="year" placeholder="Year" required>
            <input type="text" name="day_of_week" placeholder="Day of Week" required>
            <input type="time" name="start_time" placeholder="Start Time" required>
            <input type="time" name="end_time" placeholder="End Time" required>
            <input type="text" name="room" placeholder="Room">
            <button type="submit">Add Course</button>
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ensure all required fields are set
            $course_name = $_POST['course_name'] ?? '';
            $credits = $_POST['credits'] ?? '';
            $department = $_POST['department'] ?? '';
            $prerequisites = isset($_POST['prerequisites']) ? $_POST['prerequisites'] : [];

            // Schedule information
            $instructor_id = $_POST['instructor_id'] ?? null;
            $semester = $_POST['semester'] ?? '';
            $year = $_POST['year'] ?? '';
            $day_of_week = $_POST['day_of_week'] ?? '';
            $start_time = $_POST['start_time'] ?? '';
            $end_time = $_POST['end_time'] ?? '';
            $room = $_POST['room'] ?? '';

            // Validate that required fields are not empty
            if (!$course_name || !$credits || !$department || !$instructor_id || !$semester || !$year || !$day_of_week || !$start_time || !$end_time) {
                echo "Please fill all required fields.";
                exit;
            }

            // Insert new course
            $sql = "INSERT INTO courses (course_name, credits, department) 
                    VALUES ('$course_name', '$credits', '$department')";

            if ($conn->query($sql) === TRUE) {
                $course_id = $conn->insert_id; // Get the newly inserted course ID

                // Insert prerequisites
                if (is_array($prerequisites)) {
                    foreach ($prerequisites as $prerequisite_id) {
                        $sql = "INSERT INTO prerequisites (course_id, prerequisite_course_id) 
                                VALUES ('$course_id', '$prerequisite_id')";
                        $conn->query($sql);
                    }
                }

                // Insert schedule
                $sql = "INSERT INTO schedule (course_id, instructor_id, semester, year, day_of_week, start_time, end_time, room) 
                        VALUES ('$course_id', '$instructor_id', '$semester', '$year', '$day_of_week', '$start_time', '$end_time', '$room')";

                if ($conn->query($sql) === TRUE) {
                    echo "Course and schedule added successfully!";
                } else {
                    echo "Error inserting schedule: " . $conn->error;
                }
            } else {
                echo "Error inserting course: " . $conn->error;
            }
        }
        ?>
    </main>
</body>
</html>
