<?php

$servername = "localhost";
$username = "root";
$password = "broony189";
$database = "MarksManagement";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
}

function sanitize($data)
{
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $regNo = sanitize($_POST["regNo"]);
        $catMarks = sanitize($_POST["catMarks"]);
        $exam = sanitize($_POST["exam"]);
        $class = sanitize($_POST["class"]);

        $sql = "INSERT INTO marks (regNo, cat, exam, class) VALUES ('$regNo', '$catMarks', '$exam', '$class')";

        if (mysqli_query($conn, $sql)) {
        } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
}

$sql = "SELECT * FROM marks";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>

<head>
        <title>PHP CAT</title>
        <link rel="stylesheet" href="style.css">
</head>

<body>
        <div class="container">
                <h2>Enter the marks of students</h2>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <label for="regNo">Registration Number:</label>
                        <input type="text" name="regNo" required ><br>

                        <label for="catMarks">CAT Marks:</label>
                        <input type="text" name="catMarks" required><br>

                        <label for="exam">Exam:</label>
                        <input type="text" name="exam" required><br>

                        <label for="class">Class:</label>
                        <input type="text" name="class" required><br>

                        <input type="submit" value="Save Marks">
                </form>

                <br>
                <h3>The Entered Student Marks are:</h3>
                <table>
                        <tr>
                                <th>Registration Number</th>
                                <th>CAT</th>
                                <th>Exam</th>
                                <th>Class</th>
                                <th>Total</th>
                        </tr>
                        <?php
                        // Loop through each row of the result
                        while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['regNo'] . "</td>";
                                echo "<td>" . $row['cat'] . "</td>";
                                echo "<td>" . $row['exam'] . "</td>";
                                echo "<td>" . $row['class'] . "</td>";
                                $total = $row['exam'] + $row['cat'];
                                echo "<td>" . $total . "</td>";
                                echo "</tr>";
                        }
                        ?>
                </table>

                <?php
                // Close the database connection
                mysqli_close($conn);
                ?>
        </div>
</body>

</html>