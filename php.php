<?php
$path = new mysqli("localhost", "root", "", "wimaladharma_university");

if ($path->connect_error) {
    die("Connection failed: " . $path->connect_error);
}

$code = $_REQUEST['nic'];

$stmt = $path->prepare("SELECT nic, name, Address, tel_no, course FROM student WHERE nic = ?");
$stmt->bind_param("s", $code);


$stmt->execute();


$result = $stmt->get_result();


if ($result->num_rows > 0) {
        echo "<table border='2'>
            <tr>
                <th>NIC</th>
                <th>Name</th>
                <th>Address</th>
                <th>Telephone Number</th>
                <th>Course</th>
            </tr>";

   
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['nic']}</td>
                <td>{$row['name']}</td>
                <td>{$row['Address']}</td>
                <td>{$row['tel_no']}</td>
                <td>{$row['course']}</td>
              </tr>";
    }

        echo "</table>";
} else {
    echo "No records found.";
}


$stmt->close();
$path->close();
?>
