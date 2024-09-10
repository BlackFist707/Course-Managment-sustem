<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Add Instructor</title>
</head>
<body>
    <h1>Add a New Instructor</h1>
    <form action="add_instructor.php" method="POST">
        <input type="text" name="instructor_name" placeholder="Instructor Name" required>
        <input type="text" name="department" placeholder="Department" required>
        <button type="submit">Add Instructor</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $instructor_name = $_POST['instructor_name'];
        $department = $_POST['department'];

        $sql = "INSERT INTO instructors (instructor_name, department) 
                VALUES ('$instructor_name', '$department')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Instructor added successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
    ?>
</body>
</html>
