enroll_student.php<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style  .css">
    <title>Enroll Student</title>
</head>
<body>
    <h1>Enroll a Student in a Course</h1>
    <form action="enroll_student.php" method="POST">
        <label for="student">Student:</label>
        <select name="student_id" required>
            <?php
            $sql = "SELECT student_id, student_name FROM students";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['student_id'] . "'>" . $row['student_name'] . "</option>";
            }
            ?>
        </select>
        <br>
        <label for="course">Course:</label>
        <select name="course_id" required>
            <?php
            $sql = "SELECT course_id, course_name FROM courses";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['course_id'] . "'>" . $row['course_name'] . "</option>";
            }
            ?>
        </select>
        <br>
        <input type="date" name="enrollment_date" required>
        <button type="submit">Enroll</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $student_id = $_POST['student_id'];
        $course_id = $_POST['course_id'];
        $enrollment_date = $_POST['enrollment_date'];

        $sql = "INSERT INTO enrollments (student_id, course_id, enrollment_date) 
                VALUES ('$student_id', '$course_id', '$enrollment_date')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Student enrolled successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
    ?>
</body>
</html>
