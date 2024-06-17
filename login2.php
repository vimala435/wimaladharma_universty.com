<?php
$path = new mysqli("localhost", "root", "", "wimaladharma_university");


if ($path->connect_error) {
    die("Connection failed: " . $path->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are present
    if(isset($_POST['name'], $_POST['nic'])) {
        $username = htmlspecialchars($_POST['name']);
        $password = htmlspecialchars($_POST['nic']);

        
        $sql = $path->prepare("SELECT * FROM student WHERE name = ? AND nic = ?");

        if ($sql === false) {
            die("Error preparing statement: " . htmlspecialchars($path->error));
        }

        
        $sql->bind_param("ss", $username, $password);

        if (!$sql->execute()) {
            die("Error executing statement: " . htmlspecialchars($sql->error));
        }

        $result = $sql->get_result();

        if ($result->num_rows > 0) {
            echo "<table border=2><tr><td>NIC</td><td>Name</td><td>Address</td><td>Tel_no</td><td>Course</td></tr>";
            while ($row = $result->fetch_assoc()) {
                
                $nic = isset($row["nic"]) ? htmlspecialchars($row["nic"]) : '';
                $name = isset($row["name"]) ? htmlspecialchars($row["name"]) : '';
                $address = isset($row["address"]) ? htmlspecialchars($row["address"]) : '';
                $tel_no = isset($row["tel_no"]) ? htmlspecialchars($row["tel_no"]) : '';
                $course = isset($row["course"]) ? htmlspecialchars($row["course"]) : '';
                
                echo "<tr><td>$nic</td><td>$name</td><td>$address</td><td>$tel_no</td><td>$course</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No records found.";
        }

        // Close the statement
        $sql->close();
    } else {
        echo "Required fields are missing.";
    }
}
header("Location: insut.html");
exit();



$path->close();
?>
