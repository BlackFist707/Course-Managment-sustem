<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Schedules</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Course Schedules</h1>

    <?php
    $sql = "SELECT s.schedule_id, c.course_name, i.instructor_name, s.semester, s.year, s.day_of_week, s.start_time, s.end_time, s.room 
            FROM schedule s
            JOIN courses c ON s.course_id = c.course_id
            JOIN instructors i ON s.instructor_id = i.instructor_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Schedule ID</th>
                    <th>Course</th>
                    <th>Instructor</th>
                    <th>Semester</th>
                    <th>Year</th>
                    <th>Day</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Room</th>
                </tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["schedule_id"] . "</td>
                    <td>" . $row["course_name"] . "</td>
                    <td>" . $row["instructor_name"] . "</td>
                    <td>" . $row["semester"] . "</td>
                    <td>" . $row["year"] . "</td>
                    <td>" . $row["day_of_week"] . "</td>
                    <td>" . $row["start_time"] . "</td>
                    <td>" . $row["end_time"] . "</td>
                    <td>" . $row["room"] . "</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No schedules found.";
    }
    ?>
</body>
</html>
