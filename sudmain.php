<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wimaladharma_university";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function executeQuery($conn, $sql, $params, $successMsg) {
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    if ($params) {
        // Pass parameters by reference
        $refs = [];
        foreach ($params as $key => $value) {
            $refs[$key] = &$params[$key];
        }
        call_user_func_array([$stmt, 'bind_param'], $refs);
    }

    if ($stmt->execute()) {
        echo $successMsg;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

if (isset($_POST['save'])) {
    $nic = $_POST['nic'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $telno = $_POST['telno'];
    $course = $_POST['course'];

    $sql = "INSERT INTO student (nic, name, address, tel_no, course) VALUES (?, ?, ?, ?, ?)";
    $params = ["sssss", $nic, $name, $address, $telno, $course];
    executeQuery($conn, $sql, $params, "New record created successfully");

} elseif (isset($_POST['update'])) {
    $nic = $_POST['nic'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $telno = $_POST['telno'];
    $course = $_POST['course'];

    $sql = "UPDATE student SET name=?, address=?, tel_no=?, course=? WHERE nic=?";
    $params = ["sssss", $name, $address, $telno, $course, $nic];
    executeQuery($conn, $sql, $params, "Record updated successfully");

} elseif (isset($_POST['delete'])) {
    $nic = $_POST['nic'];

    $sql = "DELETE FROM student WHERE nic=?";
    $params = ["s", $nic];
    executeQuery($conn, $sql, $params, "Record deleted successfully");

} elseif (isset($_POST['search'])) {
    $nic = $_POST['nic'];

    $sql = "SELECT * FROM student WHERE nic=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("s", $nic);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "NIC: " . $row["nic"] . " - Name: " . $row["name"] . " - Address: " . $row["address"] . " - Telephone: " . $row["tel_no"] . " - Course: " . $row["course"] . "<br>";
        }
    } else {
        echo "0 results";
    }

    $stmt->close();
}

$conn->close();
?>
