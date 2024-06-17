<?php
$path = mysqli_connect("localhost", "root", "", "wimaladharma_university");


$nic = $_REQUEST['nic'];
$name = $_REQUEST['name'];
$Address = $_REQUEST['Address'];
$tel_no = isset($_REQUEST['tel_no']) ? $_REQUEST['tel_no'] : ''; $course = $_REQUEST['course'];

if (isset($_POST['save'])) {
  
    $sql = "INSERT INTO student (nic, name, Address, tel_no, course) VALUES ('$nic', '$name', '$Address', '$tel_no', '$course')";

    if (mysqli_query($path, $sql)) {
        echo "registration successfully.";
    } else {
        echo "Error: " . mysqli_error($path);
    }
}
?>
